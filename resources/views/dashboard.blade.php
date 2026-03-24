<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-indigo-50 via-purple-50 to-pink-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Card -->
            <div class="bg-white overflow-hidden shadow-xl rounded-3xl mb-8">
                <div class="bg-gradient-to-r from-purple-500 to-pink-500 p-8 text-white text-center">
                    <h1 class="text-4xl font-bold mb-2">👋 Welcome back, {{ Auth::user()->name }}!</h1>
                    <p class="text-xl text-purple-100">Ready for today's reading adventure?</p>
                </div>
                <div class="p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <a href="{{ route('levels.index') }}" 
                           class="block p-6 bg-gradient-to-r from-purple-500 to-violet-500 text-white rounded-2xl text-center hover:shadow-xl transform hover:scale-105 transition-all">
                            <div class="text-5xl mb-3">🎯</div>
                            <div class="text-2xl font-bold">Learning Levels</div>
                            <div class="text-purple-100">Words → Phrases → Sentences → Stories</div>
                        </a>
                        <a href="{{ route('user.dashboard') }}" 
                           class="block p-6 bg-gradient-to-r from-green-500 to-emerald-500 text-white rounded-2xl text-center hover:shadow-xl transform hover:scale-105 transition-all">
                            <div class="text-5xl mb-3">📊</div>
                            <div class="text-2xl font-bold">My Progress</div>
                            <div class="text-green-100">Track your achievements</div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-white rounded-2xl shadow-lg p-6 text-center">
                    <div class="text-4xl mb-2">📚</div>
                    <div class="text-2xl font-bold text-pink-600">25</div>
                    <div class="text-gray-500">Words</div>
                </div>
                <div class="bg-white rounded-2xl shadow-lg p-6 text-center">
                    <div class="text-4xl mb-2">💬</div>
                    <div class="text-2xl font-bold text-orange-600">20</div>
                    <div class="text-gray-500">Phrases</div>
                </div>
                <div class="bg-white rounded-2xl shadow-lg p-6 text-center">
                    <div class="text-4xl mb-2">✨</div>
                    <div class="text-2xl font-bold text-green-600">20</div>
                    <div class="text-gray-500">Sentences</div>
                </div>
                <div class="bg-white rounded-2xl shadow-lg p-6 text-center">
                    <div class="text-4xl mb-2">📖</div>
                    <div class="text-2xl font-bold text-purple-600">2</div>
                    <div class="text-gray-500">Stories</div>
                </div>
            </div>

            <!-- Start Learning Button -->
            <div class="text-center">
                <a href="{{ route('levels.index') }}" 
                   class="inline-block px-12 py-6 bg-gradient-to-r from-yellow-400 via-orange-500 to-red-500 text-white text-2xl font-bold rounded-2xl shadow-xl hover:shadow-2xl transform hover:scale-105 transition-all animate-pulse">
                    🚀 Start Learning Now!
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
