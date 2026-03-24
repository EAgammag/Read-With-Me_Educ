<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                📖 Level 4: Cognitive Integration
            </h2>
            <a href="{{ route('levels.index') }}" class="text-purple-600 hover:text-purple-800 font-bold">
                ← Back to Levels
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-purple-50 via-violet-50 to-indigo-50 min-h-screen">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
                <div class="text-center mb-6">
                    <h3 class="text-3xl font-bold text-gray-800 mb-2">📖 Reading Comprehension</h3>
                    <p class="text-gray-600">Choose a story, read it carefully, then answer comprehension questions by typing.</p>
                    <div class="flex justify-center gap-4 mt-4">
                        <span class="px-4 py-2 bg-purple-100 text-purple-800 rounded-full font-medium">
                            📝 Type Your Answers
                        </span>
                        <span class="px-4 py-2 bg-blue-100 text-blue-800 rounded-full font-medium">
                            🧠 Critical Thinking
                        </span>
                        <span class="px-4 py-2 bg-green-100 text-green-800 rounded-full font-medium">
                            📚 Choose Your Story
                        </span>
                    </div>
                </div>
                
                <div class="flex items-center justify-between">
                    <span class="text-gray-600">Progress</span>
                    <span class="text-xl font-bold text-purple-600">
                        {{ count($completedIds) }}/{{ count($stories) }} Stories Read
                    </span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-4 overflow-hidden mt-2">
                    @php
                        $percentage = count($stories) > 0 ? (count($completedIds) / count($stories)) * 100 : 0;
                    @endphp
                    <div class="h-full bg-gradient-to-r from-purple-400 to-violet-500 rounded-full transition-all duration-500"
                         style="width: {{ $percentage }}%"></div>
                </div>

                @if($percentage >= 100)
                    <div class="mt-4 p-4 bg-gradient-to-r from-yellow-100 to-green-100 rounded-xl text-center">
                        <p class="text-xl font-bold text-green-700">🏆 Congratulations! You've completed all levels!</p>
                        <p class="text-green-600">You are now a reading master! Keep practicing to maintain your skills.</p>
                    </div>
                @endif
            </div>

            <!-- Story Library -->
            <h4 class="text-2xl font-bold text-gray-800 mb-4">📚 Story Library</h4>
            <p class="text-gray-600 mb-6">Select a story that interests you. You can read them in any order!</p>

            <!-- Story Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($stories as $story)
                    @php
                        $isCompleted = in_array($story->id, $completedIds);
                        $score = $storyScores[$story->id] ?? null;
                    @endphp
                    <a href="{{ route('levels.stories.read', $story->id) }}" 
                       class="block relative group transform transition-all duration-300 hover:scale-105">
                        <div class="bg-white rounded-2xl shadow-lg overflow-hidden h-full
                                    {{ $isCompleted ? 'ring-4 ring-green-400' : 'hover:shadow-xl' }}">
                            <!-- Story Header -->
                            <div class="bg-gradient-to-r from-purple-400 to-violet-500 p-6 text-white">
                                <div class="text-6xl text-center mb-2">{{ $story->image_emoji }}</div>
                                <h3 class="text-xl font-bold text-center">{{ $story->title }}</h3>
                            </div>
                            
                            <!-- Story Info -->
                            <div class="p-4">
                                <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                    {{ Str::limit($story->content, 100) }}
                                </p>
                                
                                <div class="flex items-center justify-between">
                                    <span class="px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-sm font-bold">
                                        {{ $story->questions_count }} Questions
                                    </span>
                                    
                                    @if($isCompleted)
                                        <div class="text-right">
                                            <span class="text-green-600 font-bold text-sm">✅ Complete</span>
                                            @if($score !== null)
                                                <div class="text-xs text-gray-500">Score: {{ $score }}%</div>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-purple-500 font-bold text-sm group-hover:text-purple-700">
                                            Read →
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Completion Badge -->
                            @if($isCompleted)
                                <div class="absolute top-4 right-4 bg-green-500 text-white rounded-full w-8 h-8 flex items-center justify-center shadow-lg">
                                    ✓
                                </div>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>

            <!-- Help Message -->
            <div class="mt-8 text-center">
                <div class="inline-block bg-white rounded-2xl shadow-lg p-6">
                    <h4 class="font-bold text-gray-800 mb-2">💡 Reading Tips:</h4>
                    <ul class="text-left text-gray-600 space-y-1">
                        <li>• Read the story at your own pace</li>
                        <li>• Pay attention to details and characters</li>
                        <li>• You can re-read sections before answering</li>
                        <li>• Type your answers carefully in the comprehension test</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
