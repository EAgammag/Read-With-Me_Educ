<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                🎯 Practice: "{{ $word->word }}"
            </h2>
            <a href="{{ route('levels.words') }}" class="text-pink-600 hover:text-pink-800 font-bold">
                ← Back to Words
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-pink-50 via-rose-50 to-red-50 min-h-screen" 
         x-data="wordPractice()" x-init="init()">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Progress Indicator -->
            <div class="bg-white rounded-xl shadow p-4 mb-6">
                <div class="flex items-center justify-between text-sm">
                    <span class="text-gray-600">Level 1 Progress</span>
                    <span class="font-bold text-pink-600">{{ $completedCount }}/{{ $totalWords }} Words</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                    <div class="h-full bg-gradient-to-r from-pink-400 to-rose-500 rounded-full transition-all"
                         style="width: {{ $totalWords > 0 ? ($completedCount / $totalWords) * 100 : 0 }}%"></div>
                </div>
            </div>

            <!-- Main Word Card -->
            <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">
                <!-- Header -->
                <div class="bg-gradient-to-r from-pink-400 to-rose-500 p-8 text-white text-center">
                    <p class="text-lg mb-2">🎤 Say this word out loud!</p>
                    <div class="text-7xl md:text-9xl font-bold tracking-wider cursor-pointer hover:scale-110 transition-transform"
                         @click="speakWord()">
                        {{ $word->word }}
                    </div>
                    <p class="mt-4 text-pink-100">👆 Click the word to hear it!</p>
                </div>

                <!-- Content Section -->
                <div class="p-8">
                    <!-- Phonics Section -->
                    <h3 class="text-2xl font-bold text-center text-gray-800 mb-6">
                        🔤 Sound it out! Click each part:
                    </h3>
                    
                    <div class="flex justify-center flex-wrap gap-4 mb-8">
                        @foreach($word->phonemes as $index => $phoneme)
                            <button @click="speakPhoneme('{{ $phoneme }}', {{ $index }})"
                                    :class="activePhoneme === {{ $index }} ? 'scale-125 ring-4 ring-yellow-400' : ''"
                                    class="text-4xl md:text-6xl font-bold px-6 py-4 rounded-2xl bg-gradient-to-br from-yellow-200 to-orange-200 text-gray-800 shadow-lg hover:shadow-xl transform transition-all duration-200 hover:scale-110">
                                {{ $phoneme }}
                            </button>
                        @endforeach
                    </div>

                    <!-- Voice Recognition Section -->
                    <div class="bg-blue-50 rounded-2xl p-6 mb-8" x-show="!completed">
                        <h4 class="text-xl font-bold text-blue-800 mb-4 text-center">🎤 Voice Recognition</h4>
                        
                        <!-- Microphone Button -->
                        <div class="flex flex-col items-center">
                            <button @click="startRecording()"
                                    :disabled="!speechSupported || isRecording"
                                    :class="{
                                        'bg-red-500 animate-pulse ring-4 ring-red-300': isRecording,
                                        'bg-blue-500 hover:bg-blue-600': !isRecording && speechSupported,
                                        'bg-gray-400 cursor-not-allowed': !speechSupported
                                    }"
                                    class="w-24 h-24 rounded-full text-white text-4xl shadow-lg transform transition-all hover:scale-110 flex items-center justify-center">
                                <span x-show="!isRecording">🎤</span>
                                <span x-show="isRecording" class="flex items-end gap-1 h-8">
                                    <span class="w-1 bg-white rounded-full animate-sound-bar-1" style="height: 100%"></span>
                                    <span class="w-1 bg-white rounded-full animate-sound-bar-2" style="height: 60%"></span>
                                    <span class="w-1 bg-white rounded-full animate-sound-bar-3" style="height: 80%"></span>
                                    <span class="w-1 bg-white rounded-full animate-sound-bar-4" style="height: 40%"></span>
                                    <span class="w-1 bg-white rounded-full animate-sound-bar-5" style="height: 90%"></span>
                                </span>
                            </button>
                            
                            <p class="mt-4 text-center text-lg" x-show="speechSupported">
                                <span x-show="!isRecording && !transcript">Click 🎤 and say "<strong>{{ $word->word }}</strong>"</span>
                                <span x-show="isRecording" class="text-red-600 font-bold">🎙️ Listening... Speak now!</span>
                            </p>

                            <!-- Transcript Display -->
                            <div x-show="transcript" class="mt-4 p-4 bg-white rounded-xl shadow w-full max-w-md">
                                <p class="text-sm text-gray-500 mb-1">You said:</p>
                                <p class="text-3xl font-bold text-center" :class="isCorrect ? 'text-green-600' : 'text-red-600'" x-text="transcript"></p>
                            </div>

                            <!-- Voice Not Supported Message -->
                            <div x-show="!speechSupported" class="mt-4 p-4 bg-yellow-100 rounded-xl w-full max-w-md text-center">
                                <p class="text-yellow-800 font-medium">⚠️ Voice recognition is not supported in your browser.</p>
                                <p class="text-yellow-700 text-sm mt-1">Please use Google Chrome or Microsoft Edge for the best experience.</p>
                            </div>

                            <!-- Feedback -->
                            <div x-show="feedback" class="mt-4 p-4 rounded-xl w-full max-w-md text-center"
                                 :class="isCorrect ? 'bg-green-100' : 'bg-orange-100'">
                                <p class="text-xl font-bold" :class="isCorrect ? 'text-green-600' : 'text-orange-600'" x-text="feedback"></p>
                                <button x-show="!isCorrect" @click="resetAttempt()" 
                                        class="mt-2 px-4 py-2 bg-orange-500 text-white rounded-lg font-bold hover:bg-orange-600">
                                    🔄 Try Again
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Example Sentence -->
                    <div class="bg-purple-50 rounded-2xl p-6 mb-8">
                        <h4 class="text-lg font-bold text-purple-800 mb-2">📖 In a sentence:</h4>
                        <p class="text-2xl text-gray-800 cursor-pointer hover:text-purple-600"
                           @click="speakSentence()">
                            "{{ $word->example_sentence }}"
                        </p>
                        <p class="text-sm text-purple-600 mt-2">👆 Click to hear the sentence!</p>
                    </div>

                    <!-- Completion Section -->
                    <div x-show="completed" class="text-center">
                        <div class="bg-gradient-to-r from-yellow-100 to-green-100 rounded-2xl p-8 mb-6">
                            <div class="text-6xl mb-4">🎉</div>
                            <h3 class="text-3xl font-bold text-green-600 mb-2">Perfect Pronunciation!</h3>
                            <p class="text-xl text-gray-600">You've mastered "{{ $word->word }}" with 100% accuracy!</p>
                            <div class="text-4xl mt-4">⭐⭐⭐</div>
                        </div>
                        
                        <div class="flex justify-center gap-4">
                            @if($nextWord)
                                <a href="{{ route('levels.words.practice', $nextWord->id) }}" 
                                   class="inline-block px-8 py-4 bg-gradient-to-r from-pink-500 to-rose-500 text-white text-xl font-bold rounded-2xl shadow-lg hover:shadow-xl transform transition-all hover:scale-105">
                                    Next Word →
                                </a>
                            @else
                                <a href="{{ route('levels.words') }}" 
                                   class="inline-block px-8 py-4 bg-gradient-to-r from-green-500 to-emerald-500 text-white text-xl font-bold rounded-2xl shadow-lg hover:shadow-xl transform transition-all hover:scale-105">
                                    ✓ View All Words
                                </a>
                            @endif
                        </div>

                        <!-- Level Complete Check -->
                        <div x-show="levelCompleted" class="mt-6 p-4 bg-green-100 rounded-xl">
                            <p class="text-xl font-bold text-green-700">🏆 Level 1 Complete!</p>
                            <p class="text-green-600 mb-2">You've unlocked Level 2: Phrase Mastery!</p>
                            <p class="text-2xl font-bold text-green-800">Your Score: <span x-text="score"></span>/{{ $totalWords }} items</p>
                            <p class="text-sm text-green-600 mt-1">Redirecting to Level 2 in <span x-text="countdown"></span> seconds...</p>
                            <a :href="nextLevelUrl" class="inline-block mt-2 px-6 py-2 bg-green-500 text-white rounded-lg font-bold hover:bg-green-600">
                                Go to Level 2 Now →
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function wordPractice() {
            return {
                activePhoneme: null,
                transcript: '',
                feedback: '',
                isCorrect: false,
                completed: false,
                levelCompleted: false,
                isRecording: false,
                speechSupported: false,
                mediaRecorder: null,
                audioChunks: [],
                word: '{{ strtolower($word->word) }}',
                phonemes: @json($word->phonemes),
                sentence: '{{ addslashes($word->example_sentence) }}',
                score: 0,
                nextLevelUrl: '',
                countdown: 5,
                recognition: null,

                init() {
                    // Check for browser speech recognition support
                    if ('webkitSpeechRecognition' in window || 'SpeechRecognition' in window) {
                        this.speechSupported = true;
                    }
                    // Auto-speak the word on load
                    setTimeout(() => this.speakWord(), 500);
                },

                startRecording() {
                    if (!this.speechSupported) {
                        this.feedback = "❌ Speech recognition not supported. Use Chrome or Edge.";
                        return;
                    }
                    
                    this.transcript = '';
                    this.feedback = '';
                    this.isRecording = true;
                    
                    const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
                    this.recognition = new SpeechRecognition();
                    this.recognition.lang = 'en-US';
                    this.recognition.continuous = false;
                    this.recognition.interimResults = false;
                    
                    this.recognition.onresult = (event) => {
                        const result = event.results[0][0].transcript.toLowerCase().trim();
                        this.transcript = result;
                        this.isRecording = false;
                        this.checkPronunciation(result);
                    };
                    
                    this.recognition.onerror = (event) => {
                        console.error('Speech error:', event.error);
                        this.isRecording = false;
                        
                        if (event.error === 'no-speech') {
                            this.feedback = "❌ No speech detected. Please speak clearly.";
                        } else if (event.error === 'audio-capture') {
                            this.feedback = "❌ No microphone found. Check your mic settings.";
                        } else if (event.error === 'not-allowed') {
                            this.feedback = "❌ Microphone access denied. Please allow access.";
                        } else {
                            this.feedback = "❌ Error occurred. Please try again.";
                        }
                    };
                    
                    this.recognition.onend = () => {
                        this.isRecording = false;
                    };
                    
                    this.recognition.start();
                },

                stopRecording() {
                    if (this.recognition) {
                        this.recognition.stop();
                    }
                },

                speak(text, rate = 0.8) {
                    if ('speechSynthesis' in window) {
                        window.speechSynthesis.cancel();
                        const utterance = new SpeechSynthesisUtterance(text);
                        utterance.rate = rate;
                        utterance.pitch = 1.1;
                        window.speechSynthesis.speak(utterance);
                    }
                },

                speakWord() {
                    this.speak(this.word, 0.7);
                },

                speakPhoneme(phoneme, index) {
                    this.activePhoneme = index;
                    this.speak(phoneme, 0.6);
                    setTimeout(() => this.activePhoneme = null, 500);
                },

                speakSentence() {
                    this.speak(this.sentence, 0.85);
                },

                checkPronunciation(spoken) {
                    // Clean up the spoken text
                    const cleanSpoken = spoken.replace(/[^a-z]/g, '').toLowerCase();
                    const targetWord = this.word.replace(/[^a-z]/g, '').toLowerCase();

                    if (cleanSpoken === targetWord) {
                        this.isCorrect = true;
                        this.feedback = '🎉 Perfect! Excellent pronunciation!';
                        this.speak('Perfect! Excellent pronunciation!');
                        
                        // Mark as complete
                        fetch(`/levels/words/{{ $word->id }}/complete`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ score: 100 })
                        }).then(response => response.json())
                        .then(data => {
                            this.levelCompleted = data.level_completed;
                            this.score = data.completed_count;
                            this.nextLevelUrl = data.next_level_url;
                            
                            setTimeout(() => {
                                this.completed = true;
                                
                                // Auto-redirect to next level if completed
                                if (this.levelCompleted && this.nextLevelUrl) {
                                    this.startCountdown();
                                }
                            }, 1500);
                        });
                    } else {
                        this.isCorrect = false;
                        this.feedback = `❌ You said "${spoken}". Try again! Listen carefully.`;
                        this.speak('Try again. Listen carefully.');
                        setTimeout(() => this.speakWord(), 1000);
                    }
                },

                startCountdown() {
                    const interval = setInterval(() => {
                        this.countdown--;
                        if (this.countdown <= 0) {
                            clearInterval(interval);
                            window.location.href = this.nextLevelUrl;
                        }
                    }, 1000);
                },

                resetAttempt() {
                    this.transcript = '';
                    this.feedback = '';
                    this.isCorrect = false;
                    this.speakWord();
                }
            }
        }
    </script>
</x-app-layout>
