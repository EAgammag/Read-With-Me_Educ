<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            🎯 Learning Levels
        </h2>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-indigo-50 via-purple-50 to-pink-50 min-h-screen">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <!-- Flash Messages -->
            @if(session('error'))
                <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg" role="alert">
                    <p class="font-bold">🔒 Level Locked</p>
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            <!-- Hero Section -->
            <div class="text-center mb-12">
                <h1 class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent mb-4">
                    🚀 Your Reading Journey
                </h1>
                <p class="text-xl text-gray-600">Master each level to unlock the next! Complete all items with 100% accuracy. 🎯</p>
            </div>

            <!-- Level Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @foreach($levels as $level)
                    <div class="relative group">
                        <!-- Animated Background -->
                        <div class="absolute -inset-1 bg-gradient-to-r {{ $level['color'] }} rounded-3xl blur opacity-25 group-hover:opacity-50 transition duration-500 {{ !$level['unlocked'] ? 'grayscale' : '' }}"></div>
                        
                        <div class="relative bg-white rounded-2xl shadow-xl overflow-hidden transform transition-all duration-300 {{ $level['unlocked'] ? 'hover:scale-105' : 'opacity-75' }}">
                            <!-- Lock Overlay -->
                            @if(!$level['unlocked'])
                                <div class="absolute inset-0 bg-gray-900/50 z-10 flex items-center justify-center">
                                    <div class="text-center text-white">
                                        <div class="text-6xl mb-2">🔒</div>
                                        <p class="text-lg font-bold">{{ $level['requirement'] }}</p>
                                    </div>
                                </div>
                            @endif

                            <!-- Level Header -->
                            <div class="bg-gradient-to-r {{ $level['color'] }} p-6 text-white {{ !$level['unlocked'] ? 'grayscale' : '' }}">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <span class="text-6xl">{{ $level['emoji'] }}</span>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-4xl font-bold">Level {{ $level['number'] }}</span>
                                        <p class="text-sm opacity-90">{{ $level['subtitle'] }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Level Content -->
                            <div class="p-6">
                                <h3 class="text-2xl font-bold text-gray-800 mb-1">{{ $level['title'] }}</h3>
                                <p class="text-gray-600 mb-4">{{ $level['description'] }}</p>

                                <!-- Progress Bar -->
                                <div class="mb-4">
                                    <div class="flex justify-between text-sm mb-1">
                                        <span class="text-gray-600">Progress</span>
                                        <span class="font-bold text-gray-800">{{ $level['completed'] }}/{{ $level['total'] }}</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-4 overflow-hidden">
                                        @php
                                            $percentage = $level['total'] > 0 ? ($level['completed'] / $level['total']) * 100 : 0;
                                        @endphp
                                        <div class="h-full bg-gradient-to-r {{ $level['color'] }} rounded-full transition-all duration-500 flex items-center justify-center"
                                             style="width: {{ $percentage }}%">
                                            @if($percentage > 10)
                                                <span class="text-xs text-white font-bold">{{ round($percentage) }}%</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Accuracy Indicator for Voice Levels -->
                                @if($level['number'] <= 3)
                                    <div class="flex items-center justify-center gap-2 mb-4 text-sm">
                                        <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full font-medium">
                                            🎤 Voice Recognition Required
                                        </span>
                                        <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full font-medium">
                                            ✓ 100% Accuracy
                                        </span>
                                    </div>
                                @else
                                    <div class="flex items-center justify-center gap-2 mb-4 text-sm">
                                        <span class="px-3 py-1 bg-purple-100 text-purple-800 rounded-full font-medium">
                                            📝 Typed Answers
                                        </span>
                                        <span class="px-3 py-1 bg-amber-100 text-amber-800 rounded-full font-medium">
                                            📖 Comprehension
                                        </span>
                                    </div>
                                @endif

                                <!-- Stars -->
                                <div class="flex justify-center mb-4">
                                    @for($i = 1; $i <= 3; $i++)
                                        @if($percentage >= ($i * 33.33))
                                            <span class="text-3xl mx-1 animate-pulse">⭐</span>
                                        @else
                                            <span class="text-3xl mx-1 opacity-30">☆</span>
                                        @endif
                                    @endfor
                                </div>

                                <!-- Action Button -->
                                @php
                                    $routes = [
                                        1 => 'levels.words',
                                        2 => 'levels.phrases',
                                        3 => 'levels.sentences',
                                        4 => 'levels.stories',
                                    ];
                                    $buttonText = $level['completed'] > 0 ? 'Continue' : 'Start';
                                    if ($percentage >= 100) {
                                        $buttonText = 'Review';
                                    }
                                @endphp
                                @if($level['unlocked'])
                                    <a href="{{ route($routes[$level['number']]) }}" 
                                       class="block w-full py-4 bg-gradient-to-r {{ $level['color'] }} text-white text-center text-xl font-bold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                                        {{ $buttonText }} {{ $level['emoji'] }}
                                    </a>
                                @else
                                    <button disabled 
                                            class="block w-full py-4 bg-gray-300 text-gray-500 text-center text-xl font-bold rounded-xl cursor-not-allowed">
                                        🔒 Locked
                                    </button>
                                @endif
                            </div>

                            <!-- Completion Badge -->
                            @if($percentage >= 100 && $level['unlocked'])
                                <div class="absolute top-4 left-4 bg-yellow-400 text-yellow-900 px-4 py-2 rounded-full font-bold text-sm shadow-lg animate-bounce z-20">
                                    ✅ Complete!
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Encouragement Message -->
            <div class="mt-12 text-center">
                <div class="inline-block bg-white rounded-2xl shadow-lg p-6">
                    <p class="text-2xl">
                        @php
                            $totalCompleted = collect($levels)->sum('completed');
                            $totalItems = collect($levels)->sum('total');
                            $overallProgress = $totalItems > 0 ? ($totalCompleted / $totalItems) * 100 : 0;
                        @endphp
                        
                        @if($overallProgress == 0)
                            🌟 Ready to start your reading journey? Begin with Level 1!
                        @elseif($overallProgress < 25)
                            🎉 Great start! Master each word with your voice!
                        @elseif($overallProgress < 50)
                            🌈 You're doing amazing! Keep practicing!
                        @elseif($overallProgress < 75)
                            🚀 Wow! You're halfway there!
                        @elseif($overallProgress < 100)
                            ⭐ Almost there! You're a reading superstar!
                        @else
                            🏆 CONGRATULATIONS! You've mastered all levels!
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
