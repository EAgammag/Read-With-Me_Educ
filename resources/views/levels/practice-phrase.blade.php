<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                � Practice: "{{ $phrase->phrase }}"
            </h2>
            <a href="{{ route('levels.phrases') }}" class="text-orange-600 hover:text-orange-800 font-bold">
                ← Back to Phrases
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-orange-50 via-amber-50 to-yellow-50 min-h-screen" 
         x-data="phrasePractice()" x-init="init()">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Progress Indicator -->
            <div class="bg-white rounded-xl shadow p-4 mb-6">
                <div class="flex items-center justify-between text-sm">
                    <span class="text-gray-600">Level 2 Progress</span>
                    <span class="font-bold text-orange-600">{{ $completedCount }}/{{ $totalPhrases }} Phrases</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                    <div class="h-full bg-gradient-to-r from-orange-400 to-amber-500 rounded-full transition-all"
                         style="width: {{ $totalPhrases > 0 ? ($completedCount / $totalPhrases) * 100 : 0 }}%"></div>
                </div>
            </div>

            <!-- Main Phrase Card -->
            <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">
                <!-- Header -->
                <div class="bg-gradient-to-r from-orange-400 to-amber-500 p-8 text-white text-center">
                    <p class="text-lg mb-2">🎤 Say this phrase with natural flow!</p>
                    <div class="text-4xl md:text-6xl font-bold tracking-wider cursor-pointer hover:scale-105 transition-transform"
                         @click="speakPhrase()">
                        "{{ $phrase->phrase }}"
                    </div>
                    <p class="mt-4 text-orange-100">👆 Click to hear it!</p>
                </div>

                <!-- Content Section -->
                <div class="p-8">
                    <!-- Meaning -->
                    <div class="bg-yellow-50 rounded-2xl p-6 mb-6">
                        <h4 class="text-lg font-bold text-yellow-800 mb-2">💡 What it means:</h4>
                        <p class="text-2xl text-gray-800">{{ $phrase->meaning }}</p>
                    </div>

                    <!-- Word by Word -->
                    <div class="mb-8">
                        <h3 class="text-2xl font-bold text-center text-gray-800 mb-6">
                            🔤 Click each word to hear it:
                        </h3>
                        
                        <div class="flex justify-center flex-wrap gap-4">
                            @foreach(explode(' ', $phrase->phrase) as $index => $word)
                                <button @click="speakWord('{{ $word }}', {{ $index }})"
                                        :class="activeWord === {{ $index }} ? 'scale-110 ring-4 ring-yellow-400' : ''"
                                        class="text-3xl md:text-4xl font-bold px-6 py-4 rounded-2xl bg-gradient-to-br from-amber-200 to-orange-200 text-gray-800 shadow-lg hover:shadow-xl transform transition-all duration-200 hover:scale-105">
                                    {{ $word }}
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <!-- Voice Recognition Section -->
                    <div class="bg-blue-50 rounded-2xl p-6 mb-8" x-show="!completed">
                        <h4 class="text-xl font-bold text-blue-800 mb-4 text-center">🎤 Voice Recognition</h4>
                        <p class="text-center text-gray-600 mb-4">Focus on smooth transitions between words</p>
                        
                        <!-- Microphone Button -->
                        <div class="flex flex-col items-center">
                            <button @click="startRecording()"
                                    :disabled="!speechSupported || isRecording"
                                    :class="{
                                        'bg-red-500 animate-pulse': isRecording,
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
                                <span x-show="!isRecording && !transcript">Click 🎤 and say "<strong>{{ $phrase->phrase }}</strong>"</span>
                                <span x-show="isRecording" class="text-red-600 font-bold">🎙️ Listening... Speak naturally!</span>
                            </p>

                            <!-- Transcript Display -->
                            <div x-show="transcript" class="mt-4 p-4 bg-white rounded-xl shadow w-full max-w-md">
                                <p class="text-sm text-gray-500 mb-1">You said:</p>
                                <p class="text-2xl font-bold text-center" :class="isCorrect ? 'text-green-600' : 'text-red-600'" x-text="transcript"></p>
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
                        <h4 class="text-lg font-bold text-purple-800 mb-2">📖 Example:</h4>
                        <p class="text-2xl text-gray-800 cursor-pointer hover:text-purple-600"
                           @click="speakSentence()">
                            "{{ $phrase->example_sentence }}"
                        </p>
                        <p class="text-sm text-purple-600 mt-2">👆 Click to hear the example!</p>
                    </div>

                    <!-- Completion Section -->
                    <div x-show="completed" class="text-center">
                        <div class="bg-gradient-to-r from-yellow-100 to-green-100 rounded-2xl p-8 mb-6">
                            <div class="text-6xl mb-4">🎉</div>
                            <h3 class="text-3xl font-bold text-green-600 mb-2">Excellent Flow!</h3>
                            <p class="text-xl text-gray-600">You've mastered "{{ $phrase->phrase }}"!</p>
                            <div class="text-4xl mt-4">⭐⭐⭐</div>
                        </div>
                        
                        <div class="flex justify-center gap-4">
                            @if($nextPhrase)
                                <a href="{{ route('levels.phrases.practice', $nextPhrase->id) }}" 
                                   class="inline-block px-8 py-4 bg-gradient-to-r from-orange-500 to-amber-500 text-white text-xl font-bold rounded-2xl shadow-lg hover:shadow-xl transform transition-all hover:scale-105">
                                    Next Phrase →
                                </a>
                            @else
                                <a href="{{ route('levels.phrases') }}" 
                                   class="inline-block px-8 py-4 bg-gradient-to-r from-green-500 to-emerald-500 text-white text-xl font-bold rounded-2xl shadow-lg hover:shadow-xl transform transition-all hover:scale-105">
                                    ✓ View All Phrases
                                </a>
                            @endif
                        </div>

                        <!-- Level Complete Check -->
                        <div x-show="levelCompleted" class="mt-6 p-4 bg-green-100 rounded-xl">
                            <p class="text-xl font-bold text-green-700">🏆 Level 2 Complete!</p>
                            <p class="text-green-600 mb-2">You've unlocked Level 3: Sentence Mastery!</p>
                            <p class="text-2xl font-bold text-green-800">Your Score: <span x-text="score"></span>/{{ $totalPhrases }} items</p>
                            <p class="text-sm text-green-600 mt-1">Redirecting to Level 3 in <span x-text="countdown"></span> seconds...</p>
                            <a :href="nextLevelUrl" class="inline-block mt-2 px-6 py-2 bg-green-500 text-white rounded-lg font-bold hover:bg-green-600">
                                Go to Level 3 Now →
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function phrasePractice() {
            return {
                activeWord: null,
                transcript: '',
                feedback: '',
                isCorrect: false,
                completed: false,
                levelCompleted: false,
                isRecording: false,
                speechSupported: true,
                phrase: '{{ strtolower($phrase->phrase) }}',
                sentence: '{{ addslashes($phrase->example_sentence) }}',
                score: 0,
                nextLevelUrl: '',
                countdown: 5,
                mediaRecorder: null,
                audioChunks: [],
                recognition: null,

                init() {
                    // Check for browser speech recognition support
                    if ('webkitSpeechRecognition' in window || 'SpeechRecognition' in window) {
                        this.speechSupported = true;
                    }
                    setTimeout(() => this.speakPhrase(), 500);
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

                speak(text, rate = 0.85) {
                    if ('speechSynthesis' in window) {
                        window.speechSynthesis.cancel();
                        const utterance = new SpeechSynthesisUtterance(text);
                        utterance.rate = rate;
                        utterance.pitch = 1.1;
                        window.speechSynthesis.speak(utterance);
                    }
                },

                speakPhrase() {
                    this.speak(this.phrase, 0.75);
                },

                speakWord(word, index) {
                    this.activeWord = index;
                    this.speak(word, 0.7);
                    setTimeout(() => this.activeWord = null, 500);
                },

                speakSentence() {
                    this.speak(this.sentence, 0.85);
                },

                checkPronunciation(spoken) {
                    const cleanSpoken = spoken.replace(/[^a-z\s]/g, '').toLowerCase().trim();
                    const targetPhrase = this.phrase.replace(/[^a-z\s]/g, '').toLowerCase().trim();

                    // Check for exact match or close match
                    if (cleanSpoken === targetPhrase || this.calculateSimilarity(cleanSpoken, targetPhrase) > 0.85) {
                        this.isCorrect = true;
                        this.feedback = '🎉 Perfect flow! Great articulation!';
                        this.speak('Perfect! Great articulation!');
                        
                        fetch(`/levels/phrases/{{ $phrase->id }}/complete`, {
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
                        this.feedback = `❌ You said "${spoken}". Focus on smooth transitions!`;
                        this.speak('Try again. Focus on smooth transitions.');
                        setTimeout(() => this.speakPhrase(), 1000);
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

                calculateSimilarity(str1, str2) {
                    const longer = str1.length > str2.length ? str1 : str2;
                    const shorter = str1.length > str2.length ? str2 : str1;
                    if (longer.length === 0) return 1.0;
                    return (longer.length - this.editDistance(longer, shorter)) / longer.length;
                },

                editDistance(str1, str2) {
                    const matrix = [];
                    for (let i = 0; i <= str2.length; i++) {
                        matrix[i] = [i];
                    }
                    for (let j = 0; j <= str1.length; j++) {
                        matrix[0][j] = j;
                    }
                    for (let i = 1; i <= str2.length; i++) {
                        for (let j = 1; j <= str1.length; j++) {
                            if (str2.charAt(i - 1) === str1.charAt(j - 1)) {
                                matrix[i][j] = matrix[i - 1][j - 1];
                            } else {
                                matrix[i][j] = Math.min(
                                    matrix[i - 1][j - 1] + 1,
                                    matrix[i][j - 1] + 1,
                                    matrix[i - 1][j] + 1
                                );
                            }
                        }
                    }
                    return matrix[str2.length][str1.length];
                },

                resetAttempt() {
                    this.transcript = '';
                    this.feedback = '';
                    this.isCorrect = false;
                    this.manualInput = '';
                    this.recordingTime = 0;
                    this.speakPhrase();
                }
            }
        }
    </script>
</x-app-layout>
