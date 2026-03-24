<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                � Level 2: Articulation & Flow
            </h2>
            <a href="{{ route('levels.index') }}" class="text-orange-600 hover:text-orange-800 font-bold">
                ← Back to Levels
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-orange-50 via-amber-50 to-yellow-50 min-h-screen">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <!-- Progress Header -->
            <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-800">🔊 Phrase Mastery</h3>
                        <p class="text-gray-600">Focus on rhythm and word transitions using voice recognition</p>
                    </div>
                    <div class="text-right">
                        <span class="text-3xl font-bold text-orange-600">
                            {{ $completedCount }}/{{ $totalPhrases }}
                        </span>
                        <p class="text-sm text-gray-500">Phrases Mastered</p>
                    </div>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-6 overflow-hidden">
                    @php
                        $percentage = $totalPhrases > 0 ? ($completedCount / $totalPhrases) * 100 : 0;
                    @endphp
                    <div class="h-full bg-gradient-to-r from-orange-400 to-amber-500 rounded-full transition-all duration-500 flex items-center justify-center"
                         style="width: {{ $percentage }}%">
                        @if($percentage > 5)
                            <span class="text-white font-bold">{{ round($percentage) }}%</span>
                        @endif
                    </div>
                </div>

                @if($allCompleted)
                    <div class="mt-4 p-4 bg-green-100 rounded-xl text-center">
                        <p class="text-xl font-bold text-green-700">🎉 Congratulations! Level 2 Complete!</p>
                        <p class="text-green-600">Level 3: Sentence Mastery is now unlocked!</p>
                        <a href="{{ route('levels.sentences') }}" class="inline-block mt-2 px-6 py-2 bg-green-500 text-white rounded-lg font-bold hover:bg-green-600 transition">
                            Continue to Level 3 →
                        </a>
                    </div>
                @else
                    <p class="mt-4 text-center text-gray-600">
                        🎤 <strong>Voice Recognition:</strong> Speak each phrase clearly, focusing on smooth word transitions.
                    </p>
                @endif
            </div>

            <!-- Phrase Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($phrases as $phrase)
                    @php
                        $isCompleted = in_array($phrase->id, $completedIds);
                    @endphp
                    <a href="{{ route('levels.phrases.practice', $phrase->id) }}" 
                       class="relative group transform transition-all duration-300 hover:scale-105">
                        <div class="bg-white rounded-2xl shadow-lg p-6 
                                    {{ $isCompleted ? 'ring-4 ring-green-400 bg-green-50' : 'hover:shadow-xl' }}">
                            <!-- Completion Badge -->
                            @if($isCompleted)
                                <div class="absolute -top-2 -right-2 bg-green-500 text-white rounded-full w-8 h-8 flex items-center justify-center shadow-lg z-10">
                                    ✓
                                </div>
                            @endif
                            
                            <!-- Phrase Display -->
                            <div class="text-xl font-bold mb-2 
                                        {{ $isCompleted ? 'text-green-600' : 'text-gray-800 group-hover:text-orange-600' }}">
                                "{{ $phrase->phrase }}"
                            </div>
                            
                            <!-- Meaning -->
                            <p class="text-gray-500 text-sm mb-2">{{ $phrase->meaning }}</p>
                            
                            <!-- Status Text -->
                            <div class="text-sm {{ $isCompleted ? 'text-green-600' : 'text-gray-400' }}">
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
                    <h4 class="font-bold text-gray-800 mb-2">💡 Phrase Tips:</h4>
                    <ul class="text-left text-gray-600 space-y-1">
                        <li>• Speak naturally without pausing between words</li>
                        <li>• Focus on smooth transitions</li>
                        <li>• Listen first, then repeat</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
