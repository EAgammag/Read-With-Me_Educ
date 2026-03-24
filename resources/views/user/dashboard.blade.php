<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('My Learning Progress') }} 🎯
            </h2>
            <span class="px-4 py-2 bg-indigo-100 text-indigo-800 rounded-full font-bold">
                Level {{ $stats['level'] }}
            </span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Banner -->
            <div class="bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 rounded-2xl shadow-xl p-8 mb-8 text-white">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <div>
                        <h1 class="text-3xl font-bold mb-2">Welcome back, {{ $user->name }}! 👋</h1>
                        <p class="text-white/80">Keep up the great work! You're doing amazing!</p>
                    </div>
                    <div class="mt-4 md:mt-0">
                        <a href="{{ route('words.index') }}" class="inline-block px-6 py-3 bg-white text-indigo-600 rounded-full font-bold hover:bg-gray-100 transition shadow-lg">
                            🚀 Continue Learning
                        </a>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-lg rounded-2xl p-6 text-center transform hover:scale-105 transition">
                    <div class="text-4xl mb-2">📚</div>
                    <p class="text-3xl font-bold text-indigo-600">{{ $stats['words_practiced'] }}</p>
                    <p class="text-sm text-gray-500">Words Practiced</p>
                </div>

                <div class="bg-white overflow-hidden shadow-lg rounded-2xl p-6 text-center transform hover:scale-105 transition">
                    <div class="text-4xl mb-2">⭐</div>
                    <p class="text-3xl font-bold text-green-600">{{ $stats['words_mastered'] }}</p>
                    <p class="text-sm text-gray-500">Words Mastered</p>
                </div>

                <div class="bg-white overflow-hidden shadow-lg rounded-2xl p-6 text-center transform hover:scale-105 transition">
                    <div class="text-4xl mb-2">🎯</div>
                    <p class="text-3xl font-bold {{ $stats['accuracy'] >= 80 ? 'text-green-600' : ($stats['accuracy'] >= 50 ? 'text-amber-600' : 'text-red-600') }}">
                        {{ $stats['accuracy'] }}%
                    </p>
                    <p class="text-sm text-gray-500">Accuracy</p>
                </div>

                <div class="bg-white overflow-hidden shadow-lg rounded-2xl p-6 text-center transform hover:scale-105 transition">
                    <div class="text-4xl mb-2">🏆</div>
                    <p class="text-3xl font-bold text-purple-600">{{ $stats['total_attempts'] }}</p>
                    <p class="text-sm text-gray-500">Total Tries</p>
                </div>
            </div>

            <!-- Overall Progress Bar -->
            <div class="bg-white overflow-hidden shadow-lg rounded-2xl p-6 mb-8">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold text-gray-800">📊 Overall Progress</h3>
                    <span class="text-sm text-gray-500">{{ $stats['words_mastered'] }} / {{ $stats['total_words'] }} words mastered</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-6">
                    <div class="h-6 rounded-full bg-gradient-to-r from-green-400 to-emerald-500 flex items-center justify-center text-white text-sm font-bold transition-all duration-500" 
                         style="width: {{ max($stats['progress_percent'], 5) }}%">
                        {{ $stats['progress_percent'] }}%
                    </div>
                </div>
                <p class="mt-3 text-center text-gray-600">
                    @if($stats['progress_percent'] >= 100)
                        🎉 Amazing! You've mastered all the words!
                    @elseif($stats['progress_percent'] >= 75)
                        🌟 Almost there! You're doing fantastic!
                    @elseif($stats['progress_percent'] >= 50)
                        💪 Great progress! Keep going!
                    @elseif($stats['progress_percent'] >= 25)
                        🚀 You're on your way! Keep practicing!
                    @else
                        📖 Let's learn some new words today!
                    @endif
                </p>
            </div>

            <!-- Level Progress Breakdown -->
            <div class="bg-white overflow-hidden shadow-lg rounded-2xl p-6 mb-8">
                <h3 class="text-lg font-bold text-gray-800 mb-6 flex items-center">
                    <span class="text-2xl mr-2">🎯</span> Progress by Level
                </h3>
                <div class="space-y-4">
                    <!-- Level 1: Words -->
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <div class="flex items-center">
                                <span class="text-2xl mr-2">🎯</span>
                                <div>
                                    <p class="font-bold text-gray-800">Level 1: Word Mastery</p>
                                    <p class="text-xs text-gray-500">Phonetic Foundations</p>
                                </div>
                            </div>
                            <span class="text-sm font-bold text-pink-600">{{ $stats['level_1_completed'] }}/{{ $stats['level_1_total'] }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-3">
                            @php
                                $level1Percent = $stats['level_1_total'] > 0 ? ($stats['level_1_completed'] / $stats['level_1_total']) * 100 : 0;
                            @endphp
                            <div class="h-3 rounded-full bg-gradient-to-r from-pink-400 to-rose-500 transition-all duration-500" 
                                 style="width: {{ max($level1Percent, 2) }}%"></div>
                        </div>
                    </div>

                    <!-- Level 2: Phrases -->
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <div class="flex items-center">
                                <span class="text-2xl mr-2">🔊</span>
                                <div>
                                    <p class="font-bold text-gray-800">Level 2: Phrase Mastery</p>
                                    <p class="text-xs text-gray-500">Articulation & Flow</p>
                                </div>
                            </div>
                            <span class="text-sm font-bold text-orange-600">{{ $stats['level_2_completed'] }}/{{ $stats['level_2_total'] }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-3">
                            @php
                                $level2Percent = $stats['level_2_total'] > 0 ? ($stats['level_2_completed'] / $stats['level_2_total']) * 100 : 0;
                            @endphp
                            <div class="h-3 rounded-full bg-gradient-to-r from-orange-400 to-amber-500 transition-all duration-500" 
                                 style="width: {{ max($level2Percent, 2) }}%"></div>
                        </div>
                    </div>

                    <!-- Level 3: Sentences -->
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <div class="flex items-center">
                                <span class="text-2xl mr-2">✨</span>
                                <div>
                                    <p class="font-bold text-gray-800">Level 3: Sentence Mastery</p>
                                    <p class="text-xs text-gray-500">Syntactic Precision</p>
                                </div>
                            </div>
                            <span class="text-sm font-bold text-green-600">{{ $stats['level_3_completed'] }}/{{ $stats['level_3_total'] }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-3">
                            @php
                                $level3Percent = $stats['level_3_total'] > 0 ? ($stats['level_3_completed'] / $stats['level_3_total']) * 100 : 0;
                            @endphp
                            <div class="h-3 rounded-full bg-gradient-to-r from-green-400 to-emerald-500 transition-all duration-500" 
                                 style="width: {{ max($level3Percent, 2) }}%"></div>
                        </div>
                    </div>

                    <!-- Level 4: Stories -->
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <div class="flex items-center">
                                <span class="text-2xl mr-2">📖</span>
                                <div>
                                    <p class="font-bold text-gray-800">Level 4: Reading Comprehension</p>
                                    <p class="text-xs text-gray-500">Cognitive Integration</p>
                                </div>
                            </div>
                            <span class="text-sm font-bold text-purple-600">{{ $stats['level_4_completed'] }}/{{ $stats['level_4_total'] }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-3">
                            @php
                                $level4Percent = $stats['level_4_total'] > 0 ? ($stats['level_4_completed'] / $stats['level_4_total']) * 100 : 0;
                            @endphp
                            <div class="h-3 rounded-full bg-gradient-to-r from-purple-400 to-violet-500 transition-all duration-500" 
                                 style="width: {{ max($level4Percent, 2) }}%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-8">
                <!-- Words to Learn -->
                <div class="bg-white overflow-hidden shadow-lg rounded-2xl p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                        <span class="text-2xl mr-2">🆕</span> New Words to Learn
                    </h3>
                    @if($wordsToLearn->count() > 0)
                        <div class="space-y-3">
                            @foreach($wordsToLearn as $word)
                                <a href="{{ route('words.show', $word) }}" 
                                   class="flex items-center justify-between p-4 bg-blue-50 hover:bg-blue-100 rounded-xl transition">
                                    <span class="text-xl font-bold text-blue-700">{{ $word->word }}</span>
                                    <span class="px-3 py-1 bg-blue-200 text-blue-800 rounded-full text-sm">Start →</span>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8 text-gray-500">
                            <div class="text-4xl mb-2">🎉</div>
                            <p>You've practiced all available words!</p>
                        </div>
                    @endif
                </div>

                <!-- Words In Progress -->
                <div class="bg-white overflow-hidden shadow-lg rounded-2xl p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                        <span class="text-2xl mr-2">⏳</span> Keep Practicing
                    </h3>
                    @if($wordsInProgress->count() > 0)
                        <div class="space-y-3">
                            @foreach($wordsInProgress as $progress)
                                <a href="{{ route('words.show', $progress->word) }}" 
                                   class="flex items-center justify-between p-4 bg-amber-50 hover:bg-amber-100 rounded-xl transition">
                                    <div>
                                        <span class="text-xl font-bold text-amber-700">{{ $progress->word->word }}</span>
                                        <div class="flex items-center mt-1">
                                            <div class="w-20 bg-gray-200 rounded-full h-2 mr-2">
                                                <div class="h-2 rounded-full bg-amber-500" style="width: {{ $progress->accuracy }}%"></div>
                                            </div>
                                            <span class="text-xs text-gray-500">{{ $progress->accuracy }}%</span>
                                        </div>
                                    </div>
                                    <span class="px-3 py-1 bg-amber-200 text-amber-800 rounded-full text-sm">Practice →</span>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8 text-gray-500">
                            <div class="text-4xl mb-2">📚</div>
                            <p>Start practicing to see words here!</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Mastered Words -->
            <div class="mt-8 bg-white overflow-hidden shadow-lg rounded-2xl p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                    <span class="text-2xl mr-2">⭐</span> Words You've Mastered
                </h3>
                @if($masteredWords->count() > 0)
                    <div class="flex flex-wrap gap-3">
                        @foreach($masteredWords as $progress)
                            <a href="{{ route('words.show', $progress->word) }}" 
                               class="px-4 py-2 bg-gradient-to-r from-green-100 to-emerald-100 text-green-800 rounded-full font-bold hover:from-green-200 hover:to-emerald-200 transition flex items-center gap-2">
                                <span>✓</span>
                                <span>{{ $progress->word->word }}</span>
                            </a>
                        @endforeach
                    </div>
                    @if($stats['words_mastered'] > 10)
                        <p class="mt-4 text-center text-gray-500 text-sm">
                            Showing 10 of {{ $stats['words_mastered'] }} mastered words
                        </p>
                    @endif
                @else
                    <div class="text-center py-8 text-gray-500">
                        <div class="text-4xl mb-2">🎯</div>
                        <p>Master words by practicing them with high accuracy!</p>
                        <p class="text-sm mt-1">Get 80%+ accuracy with at least 3 attempts to master a word.</p>
                    </div>
                @endif
            </div>

            <!-- Recent Activity -->
            <div class="mt-8 bg-white overflow-hidden shadow-lg rounded-2xl p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                    <span class="text-2xl mr-2">📝</span> Recent Activity
                </h3>
                @if($recentActivity->count() > 0)
                    <div class="space-y-3">
                        @foreach($recentActivity as $activity)
                            <a href="{{ route($activity->route_name, $activity->content_id) }}" 
                               class="block p-4 bg-gradient-to-r hover:from-indigo-50 hover:to-purple-50 rounded-xl transition border border-gray-100 hover:border-indigo-200">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div class="flex-shrink-0">
                                            @if($activity->content_type === 'word')
                                                <span class="flex items-center justify-center w-10 h-10 rounded-full bg-pink-100 text-pink-600 font-bold">🎯</span>
                                            @elseif($activity->content_type === 'phrase')
                                                <span class="flex items-center justify-center w-10 h-10 rounded-full bg-orange-100 text-orange-600 font-bold">🔊</span>
                                            @elseif($activity->content_type === 'sentence')
                                                <span class="flex items-center justify-center w-10 h-10 rounded-full bg-green-100 text-green-600 font-bold">✨</span>
                                            @else
                                                <span class="flex items-center justify-center w-10 h-10 rounded-full bg-purple-100 text-purple-600 font-bold">📖</span>
                                            @endif
                                        </div>
                                        <div>
                                            <p class="font-bold text-gray-800">{{ $activity->content_name }}</p>
                                            <p class="text-sm text-gray-500">
                                                Level {{ $activity->level_number }} • {{ ucfirst($activity->content_type) }}
                                                @if($activity->score)
                                                    • Score: {{ $activity->score }}
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium">✓ Completed</span>
                                        <p class="text-xs text-gray-500 mt-1">{{ $activity->completed_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500">
                        <div class="text-4xl mb-2">🌟</div>
                        <p>Start practicing to see your activity here!</p>
                        <a href="{{ route('levels.index') }}" class="inline-block mt-4 px-6 py-2 bg-indigo-600 text-white rounded-full font-bold hover:bg-indigo-700 transition">
                            Start Learning →
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
