<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                ✨ Level 3: Syntactic Precision
            </h2>
            <a href="{{ route('levels.index') }}" class="text-green-600 hover:text-green-800 font-bold">
                ← Back to Levels
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-green-50 via-emerald-50 to-teal-50 min-h-screen">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <!-- Progress Header -->
            <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-800">✨ Sentence Mastery</h3>
                        <p class="text-gray-600">Read with proper intonation, pacing, and punctuation cues</p>
                    </div>
                    <div class="text-right">
                        <span class="text-3xl font-bold text-green-600">
                            {{ $completedCount }}/{{ $totalSentences }}
                        </span>
                        <p class="text-sm text-gray-500">Sentences Mastered</p>
                    </div>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-6 overflow-hidden">
                    @php
                        $percentage = $totalSentences > 0 ? ($completedCount / $totalSentences) * 100 : 0;
                    @endphp
                    <div class="h-full bg-gradient-to-r from-green-400 to-emerald-500 rounded-full transition-all duration-500 flex items-center justify-center"
                         style="width: {{ $percentage }}%">
                        @if($percentage > 5)
                            <span class="text-white font-bold">{{ round($percentage) }}%</span>
                        @endif
                    </div>
                </div>

                @if($allCompleted)
                    <div class="mt-4 p-4 bg-green-100 rounded-xl text-center">
                        <p class="text-xl font-bold text-green-700">🎉 Congratulations! Level 3 Complete!</p>
                        <p class="text-green-600">Level 4: Reading Comprehension is now unlocked!</p>
                        <a href="{{ route('levels.stories') }}" class="inline-block mt-2 px-6 py-2 bg-green-500 text-white rounded-lg font-bold hover:bg-green-600 transition">
                            Continue to Level 4 →
                        </a>
                    </div>
                @else
                    <p class="mt-4 text-center text-gray-600">
                        🎤 <strong>Voice Recognition:</strong> Speak each sentence with natural pacing and intonation.
                    </p>
                @endif
            </div>

            <!-- Category Filter -->
            @php
                $categoryEmojis = [
                    'animals' => '🐾',
                    'activities' => '🎮',
                    'objects' => '📦',
                    'nature' => '🌿',
                    'daily life' => '🏠',
                    'food' => '🍕',
                    'learning' => '📚',
                    'emotions' => '😊',
                ];
            @endphp

            <!-- Sentence List -->
            <div class="space-y-4">
                @foreach($sentences as $sentence)
                    @php
                        $isCompleted = in_array($sentence->id, $completedIds);
                        $emoji = $categoryEmojis[$sentence->category] ?? '📝';
                    @endphp
                    <a href="{{ route('levels.sentences.practice', $sentence->id) }}" 
                       class="block relative group transform transition-all duration-300 hover:scale-[1.02]">
                        <div class="bg-white rounded-2xl shadow-lg p-6 flex items-center gap-4
                                    {{ $isCompleted ? 'ring-4 ring-green-400 bg-green-50' : 'hover:shadow-xl' }}">
                            <!-- Category Emoji -->
                            <div class="text-4xl">{{ $emoji }}</div>
                            
                            <!-- Sentence -->
                            <div class="flex-1">
                                <div class="text-xl font-bold 
                                            {{ $isCompleted ? 'text-green-600' : 'text-gray-800 group-hover:text-emerald-600' }}">
                                    {{ $sentence->sentence }}
                                </div>
                                <div class="text-sm text-gray-500 mt-1 flex items-center gap-2">
                                    <span class="px-2 py-0.5 bg-gray-100 rounded">{{ ucfirst($sentence->category) }}</span>
                                    @if($isCompleted)
                                        <span class="text-green-600">⭐ Mastered</span>
                                    @else
                                        <span class="text-gray-400">🎤 Tap to speak</span>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Status -->
                            <div class="text-2xl">
                                @if($isCompleted)
                                    <span class="text-green-500">✅</span>
                                @else
                                    <span class="text-gray-300 group-hover:text-emerald-400">→</span>
                                @endif
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <!-- Help Message -->
            <div class="mt-8 text-center">
                <div class="inline-block bg-white rounded-2xl shadow-lg p-6">
                    <h4 class="font-bold text-gray-800 mb-2">💡 Sentence Reading Tips:</h4>
                    <ul class="text-left text-gray-600 space-y-1">
                        <li>• Pause briefly at commas</li>
                        <li>• Use rising intonation for questions</li>
                        <li>• Speak at a natural pace</li>
                        <li>• Express emotion where appropriate</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
