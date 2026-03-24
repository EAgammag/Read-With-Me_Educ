<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class SpeechController extends Controller
{
    public function transcribe(Request $request)
    {
        // Log incoming request for debugging
        Log::info('Transcription request received', [
            'has_file' => $request->hasFile('audio'),
            'file_mime' => $request->hasFile('audio') ? $request->file('audio')->getMimeType() : null,
            'file_size' => $request->hasFile('audio') ? $request->file('audio')->getSize() : null,
        ]);

        $apiKey = config('services.google.speech_api_key');
        
        if (empty($apiKey)) {
            Log::error('Google Cloud API key not configured');
            return response()->json([
                'success' => false,
                'error' => 'Google Cloud API key not configured.',
            ], 500);
        }

        if (!$request->hasFile('audio')) {
            return response()->json([
                'success' => false,
                'error' => 'No audio file received.',
            ], 400);
        }

        try {
            $audioFile = $request->file('audio');
            $audioContent = base64_encode(file_get_contents($audioFile->getRealPath()));
            
            // Determine encoding based on mime type
            $mimeType = $audioFile->getMimeType();
            $encoding = 'WEBM_OPUS';
            $sampleRate = 48000;
            
            if (str_contains($mimeType, 'wav')) {
                $encoding = 'LINEAR16';
                $sampleRate = 16000;
            } elseif (str_contains($mimeType, 'mp3') || str_contains($mimeType, 'mpeg')) {
                $encoding = 'MP3';
                $sampleRate = 16000;
            } elseif (str_contains($mimeType, 'ogg')) {
                $encoding = 'OGG_OPUS';
                $sampleRate = 48000;
            }

            Log::info('Sending to Google Speech API', ['encoding' => $encoding, 'mimeType' => $mimeType]);

            // Call Google Cloud Speech-to-Text API
            $response = Http::post("https://speech.googleapis.com/v1/speech:recognize?key={$apiKey}", [
                'config' => [
                    'encoding' => $encoding,
                    'sampleRateHertz' => $sampleRate,
                    'languageCode' => 'en-US',
                    'enableAutomaticPunctuation' => false,
                    'model' => 'default',
                ],
                'audio' => [
                    'content' => $audioContent,
                ],
            ]);

            $result = $response->json();
            
            Log::info('Google Speech API response', ['result' => $result]);

            if (isset($result['results'][0]['alternatives'][0]['transcript'])) {
                $transcript = strtolower(trim($result['results'][0]['alternatives'][0]['transcript']));
                
                return response()->json([
                    'success' => true,
                    'transcript' => $transcript,
                ]);
            } else {
                // No speech detected or empty result
                return response()->json([
                    'success' => false,
                    'error' => 'No speech detected. Please speak clearly.',
                ], 400);
            }
        } catch (\Exception $e) {
            Log::error('Transcription failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            
            return response()->json([
                'success' => false,
                'error' => 'Transcription failed: ' . $e->getMessage(),
            ], 500);
        }
    }
}
