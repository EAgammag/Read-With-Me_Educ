<?php

namespace App\Http\Controllers;

use App\Models\Word;
use App\Models\Phrase;
use App\Models\Sentence;
use App\Models\Story;
use App\Models\UserProgress;
use App\Models\LevelProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Basic stats
        $stats = [
            'level' => $user->level,
            'words_practiced' => $user->progress()->count(),
            'words_mastered' => $user->masteredWords()->count(),
            'total_attempts' => $user->progress()->sum('attempts'),
            'correct_attempts' => $user->progress()->sum('correct_attempts'),
        ];
        
        $stats['accuracy'] = $stats['total_attempts'] > 0 
            ? round(($stats['correct_attempts'] / $stats['total_attempts']) * 100) 
            : 0;

        $stats['total_words'] = Word::count();
        $stats['progress_percent'] = $stats['total_words'] > 0 
            ? round(($stats['words_mastered'] / $stats['total_words']) * 100) 
            : 0;

        // Level-based progress stats
        $stats['level_1_completed'] = LevelProgress::where('user_id', $user->id)
            ->where('level_number', 1)
            ->where('content_type', 'word')
            ->where('completed', true)
            ->count();
        $stats['level_1_total'] = Word::count();
        
        $stats['level_2_completed'] = LevelProgress::where('user_id', $user->id)
            ->where('level_number', 2)
            ->where('content_type', 'phrase')
            ->where('completed', true)
            ->count();
        $stats['level_2_total'] = Phrase::count();
        
        $stats['level_3_completed'] = LevelProgress::where('user_id', $user->id)
            ->where('level_number', 3)
            ->where('content_type', 'sentence')
            ->where('completed', true)
            ->count();
        $stats['level_3_total'] = Sentence::count();
        
        $stats['level_4_completed'] = LevelProgress::where('user_id', $user->id)
            ->where('level_number', 4)
            ->where('content_type', 'story')
            ->where('completed', true)
            ->count();
        $stats['level_4_total'] = Story::count();

        // Get recent activity from LevelProgress (showing all content types)
        $recentActivity = LevelProgress::where('user_id', $user->id)
            ->where('completed', true)
            ->with(['user'])
            ->latest('completed_at')
            ->take(10)
            ->get()
            ->map(function($progress) {
                $content = null;
                $contentName = '';
                $routeName = '';
                
                switch($progress->content_type) {
                    case 'word':
                        $content = Word::find($progress->content_id);
                        $contentName = $content ? $content->word : 'Unknown';
                        $routeName = 'levels.words.practice';
                        break;
                    case 'phrase':
                        $content = Phrase::find($progress->content_id);
                        $contentName = $content ? $content->phrase : 'Unknown';
                        $routeName = 'levels.phrases.practice';
                        break;
                    case 'sentence':
                        $content = Sentence::find($progress->content_id);
                        $contentName = $content ? $content->sentence : 'Unknown';
                        $routeName = 'levels.sentences.practice';
                        break;
                    case 'story':
                        $content = Story::find($progress->content_id);
                        $contentName = $content ? $content->title : 'Unknown';
                        $routeName = 'levels.stories.read';
                        break;
                }
                
                return (object)[
                    'level_number' => $progress->level_number,
                    'content_type' => $progress->content_type,
                    'content_name' => $contentName,
                    'score' => $progress->score,
                    'completed_at' => $progress->completed_at,
                    'route_name' => $routeName,
                    'content_id' => $progress->content_id,
                ];
            });

        // Get mastered words from UserProgress (words only)
        $masteredWords = $user->masteredWords()
            ->with('word')
            ->latest('updated_at')
            ->take(10)
            ->get();

        // Get recent word progress (for backward compatibility with existing view)
        $recentProgress = $user->progress()
            ->with('word')
            ->latest('updated_at')
            ->take(5)
            ->get();

        // Get words to practice (not mastered yet)
        $wordsToLearn = Word::whereDoesntHave('progress', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })->take(5)->get();

        // Get words in progress (started but not mastered)
        $wordsInProgress = $user->progress()
            ->with('word')
            ->where('mastered', false)
            ->latest('updated_at')
            ->take(5)
            ->get();

        return view('user.dashboard', compact(
            'user', 
            'stats', 
            'recentProgress',
            'recentActivity',
            'wordsToLearn', 
            'wordsInProgress', 
            'masteredWords'
        ));
    }

    public function recordProgress(Request $request)
    {
        $request->validate([
            'word_id' => 'required|exists:words,id',
            'correct' => 'required|boolean',
        ]);

        $user = Auth::user();
        
        $progress = UserProgress::firstOrCreate(
            ['user_id' => $user->id, 'word_id' => $request->word_id],
            ['attempts' => 0, 'correct_attempts' => 0]
        );

        $progress->attempts++;
        if ($request->correct) {
            $progress->correct_attempts++;
        }
        
        // Mark as mastered if accuracy >= 80% and at least 3 attempts
        if ($progress->attempts >= 3 && $progress->accuracy >= 80) {
            $progress->mastered = true;
        }
        
        $progress->last_practiced_at = now();
        $progress->save();

        // Update user's total words practiced
        $user->total_words_practiced = $user->progress()->count();
        $user->save();

        return response()->json([
            'success' => true,
            'progress' => $progress,
            'mastered' => $progress->mastered,
        ]);
    }
}
