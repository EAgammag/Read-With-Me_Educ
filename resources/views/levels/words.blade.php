<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                🎯 Level 1: Phonetic Foundations
            </h2>
            <a href="{{ route('levels.index') }}" class="text-pink-600 hover:text-pink-800 font-bold">
                ← Back to Levels
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-pink-50 via-rose-50 to-red-50 min-h-screen">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <!-- Progress Header -->
            <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-800">🎯 Word Mastery</h3>
                        <p class="text-gray-600">Use your voice to pronounce each word with 100% accuracy</p>
                    </div>
                    <div class="text-right">
                        <span class="text-3xl font-bold text-pink-600">
                            {{ $completedCount }}/{{ $totalWords }}
                        </span>
                        <p class="text-sm text-gray-500">Words Mastered</p>
                    </div>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-6 overflow-hidden">
                    @php
                        $percentage = $totalWords > 0 ? ($completedCount / $totalWords) * 100 : 0;
                    @endphp
                    <div class="h-full bg-gradient-to-r from-pink-400 to-rose-500 rounded-full transition-all duration-500 flex items-center justify-center"
                         style="width: {{ $percentage }}%">
                        @if($percentage > 5)
                            <span class="text-white font-bold">{{ round($percentage) }}%</span>
                        @endif
                    </div>
                </div>

                @if($allCompleted)
                    <div class="mt-4 p-4 bg-green-100 rounded-xl text-center">
                        <p class="text-xl font-bold text-green-700">🎉 Congratulations! Level 1 Complete!</p>
                        <p class="text-green-600">Level 2: Phrase Mastery is now unlocked!</p>
                        <a href="{{ route('levels.phrases') }}" class="inline-block mt-2 px-6 py-2 bg-green-500 text-white rounded-lg font-bold hover:bg-green-600 transition">
                            Continue to Level 2 →
                        </a>
                    </div>
                @else
                    <p class="mt-4 text-center text-gray-600">
                        🎤 <strong>Voice Recognition:</strong> Click any word, then speak it clearly. 100% accuracy required to unlock Level 2!
                    </p>
                @endif
            </div>

            <!-- Word Grid -->
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 lg:grid-cols-6 gap-4">
                @foreach($words as $word)
                    @php
                        $isCompleted = in_array($word->id, $completedIds);
                    @endphp
                    <a href="{{ route('levels.words.practice', $word->id) }}" 
                       class="relative group transform transition-all duration-300 hover:scale-110">
                        <div class="bg-white rounded-2xl shadow-lg p-4 text-center 
                                    {{ $isCompleted ? 'ring-4 ring-green-400 bg-green-50' : 'hover:shadow-xl' }}">
                            <!-- Completion Badge -->
                            @if($isCompleted)
                                <div class="absolute -top-2 -right-2 bg-green-500 text-white rounded-full w-8 h-8 flex items-center justify-center shadow-lg z-10">
                                    ✓
                                </div>
                            @endif
                            
                            <!-- Word Display -->
                            <div class="text-2xl md:text-3xl font-bold mb-1
                                        {{ $isCompleted ? 'text-green-600' : 'text-gray-800 group-hover:text-pink-600' }}">
                                {{ $word->word }}
                            </div>
                            
                            <!-- Status Text -->
                            <div class="text-xs {{ $isCompleted ? 'text-green-600' : 'text-gray-400' }}">
                                @if($isCompleted)
                                    ⭐ Mastered
                                @else
                                    🎤 Tap to speak
                                @endif
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <!-- Help Message -->
            <div class="mt-8 text-center">
                <div class="inline-block bg-white rounded-2xl shadow-lg p-6">
                    <h4 class="font-bold text-gray-800 mb-2">💡 How it works:</h4>
                    <ol class="text-left text-gray-600 space-y-1">
                        <li>1. Click any word to practice</li>
                        <li>2. Listen to the pronunciation</li>
                        <li>3. Click the microphone and say the word</li>
                        <li>4. Get 100% accuracy to mark it complete</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
