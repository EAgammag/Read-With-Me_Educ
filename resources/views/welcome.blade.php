<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Read With Me - Learn to Read!</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=fredoka:400,500,600,700&family=nunito:400,600,700,800" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            :root {
                --color-primary: #4F46E5;
                --color-secondary: #F59E0B;
                --color-accent: #10B981;
            }
            body {
                font-family: 'Nunito', sans-serif;
            }
            h1, h2, h3 {
                font-family: 'Fredoka', sans-serif;
            }
            .animate-float {
                animation: float 3s ease-in-out infinite;
            }
            .animate-float-delay {
                animation: float 3s ease-in-out infinite;
                animation-delay: 1s;
            }
            .animate-float-delay-2 {
                animation: float 3s ease-in-out infinite;
                animation-delay: 2s;
            }
            @keyframes float {
                0%, 100% { transform: translateY(0px); }
                50% { transform: translateY(-20px); }
            }
            .animate-bounce-slow {
                animation: bounce-slow 2s ease-in-out infinite;
            }
            @keyframes bounce-slow {
                0%, 100% { transform: scale(1); }
                50% { transform: scale(1.05); }
            }
            .rainbow-text {
                background: linear-gradient(90deg, #FF6B6B, #FFE66D, #4ECDC4, #6C5CE7, #FF6B6B);
                background-size: 200% auto;
                -webkit-background-clip: text;
                background-clip: text;
                -webkit-text-fill-color: transparent;
                animation: rainbow 3s linear infinite;
            }
            @keyframes rainbow {
                to { background-position: 200% center; }
            }
            .letter-tile {
                transition: all 0.3s ease;
            }
            .letter-tile:hover {
                transform: scale(1.2) rotate(-5deg);
            }
        </style>
    </head>
    <body class="bg-gradient-to-b from-sky-100 via-purple-50 to-pink-100 min-h-screen" x-data="welcomePage()">
        <!-- Navigation -->
        <header class="p-4 md:p-6">
            <nav class="max-w-6xl mx-auto flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="text-4xl">📚</span>
                    <span class="text-2xl font-bold text-indigo-600">Read With Me</span>
                </div>
                @if (Route::has('login'))
                    <div class="flex items-center gap-3">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="px-6 py-2 bg-indigo-600 text-white rounded-full font-bold hover:bg-indigo-700 transition shadow-lg">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="px-5 py-2 text-indigo-600 font-bold hover:text-indigo-800 transition">
                                Log in
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="px-6 py-2 bg-amber-400 text-amber-900 rounded-full font-bold hover:bg-amber-500 transition shadow-lg">
                                    Sign Up Free!
                                </a>
                            @endif
                        @endauth
                    </div>
                @endif
            </nav>
        </header>

        <!-- Hero Section -->
        <main class="max-w-6xl mx-auto px-4 py-8 md:py-16">
            <div class="text-center mb-12">
                <!-- Floating Letters -->
                <div class="flex justify-center gap-4 mb-8">
                    <span class="letter-tile text-6xl md:text-8xl font-bold text-red-500 animate-float cursor-pointer" @click="speakLetter('A')">A</span>
                    <span class="letter-tile text-6xl md:text-8xl font-bold text-amber-500 animate-float-delay cursor-pointer" @click="speakLetter('B')">B</span>
                    <span class="letter-tile text-6xl md:text-8xl font-bold text-green-500 animate-float-delay-2 cursor-pointer" @click="speakLetter('C')">C</span>
                </div>

                <h1 class="text-4xl md:text-6xl font-bold mb-6">
                    <span class="rainbow-text">Learn to Read</span>
                    <br>
                    <span class="text-gray-800">One Word at a Time! 🎉</span>
                </h1>

                <p class="text-xl md:text-2xl text-gray-600 max-w-2xl mx-auto mb-8">
                    Fun, interactive phonics for young readers. Click letters, hear sounds, and watch words come alive!
                </p>

                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-12">
                    @auth
                        <a href="{{ route('words.index') }}" class="animate-bounce-slow px-8 py-4 bg-gradient-to-r from-indigo-500 to-purple-600 text-white text-xl font-bold rounded-full shadow-xl hover:shadow-2xl transition transform hover:scale-105">
                            🚀 Start Learning Now!
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="animate-bounce-slow px-8 py-4 bg-gradient-to-r from-indigo-500 to-purple-600 text-white text-xl font-bold rounded-full shadow-xl hover:shadow-2xl transition transform hover:scale-105">
                            🚀 Start Learning Free!
                        </a>
                        <a href="{{ route('login') }}" class="px-8 py-4 bg-white text-indigo-600 text-xl font-bold rounded-full shadow-lg hover:shadow-xl transition border-2 border-indigo-200">
                            I Have an Account
                        </a>
                    @endauth
                </div>
            </div>

            <!-- Interactive Demo Section -->
            <div class="bg-white rounded-3xl shadow-2xl p-8 md:p-12 mb-16">
                <h2 class="text-3xl font-bold text-center text-gray-800 mb-8">
                    ✨ Try it Now! Click the word below:
                </h2>
                
                <div class="flex justify-center gap-4 mb-8">
                    <template x-for="(letter, index) in demoWord" :key="index">
                        <button 
                            @click="playDemoLetter(letter, index)"
                            :class="{ 'scale-125 bg-yellow-300 ring-4 ring-yellow-400': activeDemo === index }"
                            class="w-20 h-20 md:w-28 md:h-28 flex items-center justify-center bg-gradient-to-br from-sky-100 to-indigo-100 rounded-2xl text-4xl md:text-6xl font-bold text-indigo-700 shadow-lg hover:shadow-xl transition-all duration-200 cursor-pointer hover:scale-110 border-4 border-indigo-200"
                            x-text="letter"
                        ></button>
                    </template>
                </div>

                <div class="flex justify-center gap-4">
                    <button @click="playFullDemo" class="px-6 py-3 bg-green-500 hover:bg-green-600 text-white rounded-full font-bold shadow-lg flex items-center gap-2 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z" />
                        </svg>
                        Hear the Word
                    </button>
                    <button @click="changeDemoWord" class="px-6 py-3 bg-purple-500 hover:bg-purple-600 text-white rounded-full font-bold shadow-lg flex items-center gap-2 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        New Word
                    </button>
                </div>
            </div>

            <!-- Features Section -->
            <div class="grid md:grid-cols-3 gap-8 mb-16">
                <div class="bg-white rounded-3xl shadow-xl p-8 text-center transform hover:scale-105 transition">
                    <div class="text-6xl mb-4">🔤</div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-3">Interactive Phonics</h3>
                    <p class="text-gray-600">Click on each letter to hear its sound. Learn how letters combine to make words!</p>
                </div>
                <div class="bg-white rounded-3xl shadow-xl p-8 text-center transform hover:scale-105 transition">
                    <div class="text-6xl mb-4">👀</div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-3">Visual Tracking</h3>
                    <p class="text-gray-600">Watch words light up as you hear them. Connect sounds with letters visually!</p>
                </div>
                <div class="bg-white rounded-3xl shadow-xl p-8 text-center transform hover:scale-105 transition">
                    <div class="text-6xl mb-4">📖</div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-3">Learn in Context</h3>
                    <p class="text-gray-600">Hear words used in sentences. Build vocabulary while having fun!</p>
                </div>
            </div>

            <!-- Word Showcase -->
            <div class="bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 rounded-3xl shadow-2xl p-8 md:p-12 text-white text-center mb-16">
                <h2 class="text-3xl font-bold mb-6">🌟 Sight Words to Explore</h2>
                <div class="flex flex-wrap justify-center gap-4">
                    <span class="px-6 py-3 bg-white/20 rounded-full text-xl font-bold backdrop-blur-sm hover:bg-white/30 transition cursor-pointer" @click="speakWord('cat')">🐱 cat</span>
                    <span class="px-6 py-3 bg-white/20 rounded-full text-xl font-bold backdrop-blur-sm hover:bg-white/30 transition cursor-pointer" @click="speakWord('dog')">🐕 dog</span>
                    <span class="px-6 py-3 bg-white/20 rounded-full text-xl font-bold backdrop-blur-sm hover:bg-white/30 transition cursor-pointer" @click="speakWord('sun')">☀️ sun</span>
                    <span class="px-6 py-3 bg-white/20 rounded-full text-xl font-bold backdrop-blur-sm hover:bg-white/30 transition cursor-pointer" @click="speakWord('bat')">🦇 bat</span>
                    <span class="px-6 py-3 bg-white/20 rounded-full text-xl font-bold backdrop-blur-sm hover:bg-white/30 transition cursor-pointer" @click="speakWord('fish')">🐟 fish</span>
                </div>
                <p class="mt-6 text-lg opacity-90">Click any word to hear it spoken!</p>
            </div>

            <!-- For Parents Section -->
            <div class="bg-white rounded-3xl shadow-xl p-8 md:p-12 mb-16">
                <div class="max-w-3xl mx-auto">
                    <h2 class="text-3xl font-bold text-center text-gray-800 mb-8">👨‍👩‍👧 For Parents & Teachers</h2>
                    <div class="grid md:grid-cols-2 gap-8">
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0 w-12 h-12 bg-green-100 rounded-full flex items-center justify-center text-2xl">✅</div>
                            <div>
                                <h4 class="font-bold text-gray-800 mb-1">Research-Based</h4>
                                <p class="text-gray-600">Uses proven phonics methods recommended by educators.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0 w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center text-2xl">🛡️</div>
                            <div>
                                <h4 class="font-bold text-gray-800 mb-1">Safe & Ad-Free</h4>
                                <p class="text-gray-600">No ads, no distractions. Just pure learning fun.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0 w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center text-2xl">📱</div>
                            <div>
                                <h4 class="font-bold text-gray-800 mb-1">Works Everywhere</h4>
                                <p class="text-gray-600">Use on tablets, phones, or computers. Learn anywhere!</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0 w-12 h-12 bg-amber-100 rounded-full flex items-center justify-center text-2xl">⭐</div>
                            <div>
                                <h4 class="font-bold text-gray-800 mb-1">Dolch Sight Words</h4>
                                <p class="text-gray-600">Focuses on the most common words for early readers.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Final CTA -->
            <div class="text-center pb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-6">Ready to Start the Adventure? 🎈</h2>
                @auth
                    <a href="{{ route('words.index') }}" class="inline-block px-10 py-5 bg-gradient-to-r from-green-400 to-emerald-500 text-white text-2xl font-bold rounded-full shadow-xl hover:shadow-2xl transition transform hover:scale-105">
                        Let's Go! →
                    </a>
                @else
                    <a href="{{ route('register') }}" class="inline-block px-10 py-5 bg-gradient-to-r from-green-400 to-emerald-500 text-white text-2xl font-bold rounded-full shadow-xl hover:shadow-2xl transition transform hover:scale-105">
                        Create Free Account →
                    </a>
                @endauth
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-indigo-900 text-white py-8">
            <div class="max-w-6xl mx-auto px-4 text-center">
                <div class="flex justify-center items-center gap-2 mb-4">
                    <span class="text-3xl">📚</span>
                    <span class="text-xl font-bold">Read With Me</span>
                </div>
                <p class="text-indigo-200">Making reading fun, one word at a time.</p>
                <p class="text-indigo-300 mt-4 text-sm">© {{ date('Y') }} Read With Me. Built with ❤️ for young readers.</p>
            </div>
        </footer>

        <script>
            function welcomePage() {
                return {
                    synth: window.speechSynthesis,
                    demoWord: ['c', 'a', 't'],
                    demoWords: [['c', 'a', 't'], ['d', 'o', 'g'], ['s', 'u', 'n'], ['b', 'a', 't'], ['f', 'i', 'sh']],
                    currentWordIndex: 0,
                    activeDemo: null,

                    speakLetter(letter) {
                        const utterance = new SpeechSynthesisUtterance(letter);
                        utterance.rate = 0.7;
                        utterance.pitch = 1.2;
                        this.synth.cancel();
                        this.synth.speak(utterance);
                    },

                    speakWord(word) {
                        const utterance = new SpeechSynthesisUtterance(word);
                        utterance.rate = 0.8;
                        this.synth.cancel();
                        this.synth.speak(utterance);
                    },

                    playDemoLetter(letter, index) {
                        this.activeDemo = index;
                        const utterance = new SpeechSynthesisUtterance(letter);
                        utterance.rate = 0.5;
                        utterance.pitch = 1.2;
                        utterance.onend = () => { this.activeDemo = null; };
                        this.synth.cancel();
                        this.synth.speak(utterance);
                    },

                    playFullDemo() {
                        const word = this.demoWord.join('');
                        const utterance = new SpeechSynthesisUtterance(word);
                        utterance.rate = 0.8;
                        this.synth.cancel();
                        this.synth.speak(utterance);
                    },

                    changeDemoWord() {
                        this.currentWordIndex = (this.currentWordIndex + 1) % this.demoWords.length;
                        this.demoWord = this.demoWords[this.currentWordIndex];
                    }
                }
            }
        </script>
    </body>
</html>
