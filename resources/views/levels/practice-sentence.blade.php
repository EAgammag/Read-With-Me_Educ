<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                ✨ Practice Sentence
            </h2>
            <a href="{{ route('levels.sentences') }}" class="text-green-600 hover:text-green-800 font-bold">
                ← Back to Sentences
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-green-50 via-emerald-50 to-teal-50 min-h-screen" 
         x-data="sentencePractice()" x-init="init()">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Progress Indicator -->
            <div class="bg-white rounded-xl shadow p-4 mb-6">
                <div class="flex items-center justify-between text-sm">
                    <span class="text-gray-600">Level 3 Progress</span>
                    <span class="font-bold text-green-600">{{ $completedCount }}/{{ $totalSentences }} Sentences</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                    <div class="h-full bg-gradient-to-r from-green-400 to-emerald-500 rounded-full transition-all"
                         style="width: {{ $totalSentences > 0 ? ($completedCount / $totalSentences) * 100 : 0 }}%"></div>
                </div>
            </div>

            <!-- Main Sentence Card -->
            <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">
                <!-- Header -->
                <div class="bg-gradient-to-r from-green-400 to-emerald-500 p-8 text-white text-center">
                    <p class="text-lg mb-4">🎤 Read this sentence with proper intonation!</p>
                    <div class="text-2xl md:text-3xl font-bold leading-relaxed cursor-pointer hover:scale-105 transition-transform"
                         @click="speakSentence()">
                        "{{ $sentence->sentence }}"
                    </div>
                    <p class="mt-4 text-green-100">👆 Click to hear it read aloud!</p>
                </div>

                <!-- Content Section -->
                <div class="p-8">
                    <!-- Word by Word Reading -->
                    <div class="mb-8">
                        <h3 class="text-2xl font-bold text-center text-gray-800 mb-6">
                            🔤 Click each word to hear it:
                        </h3>
                        
                        <div class="flex justify-center flex-wrap gap-3">
                            @foreach(preg_split('/\s+/', $sentence->sentence) as $index => $word)
                                <button @click="speakWord('{{ preg_replace('/[^a-zA-Z]/', '', $word) }}', {{ $index }})"
                                        :class="{ 
                                            'bg-gradient-to-br from-yellow-300 to-orange-300 scale-110 ring-4 ring-yellow-400': activeWord === {{ $index }},
                                            'bg-gradient-to-br from-green-200 to-emerald-200': highlightedWords.includes({{ $index }})
                                        }"
                                        class="text-xl md:text-2xl font-bold px-4 py-3 rounded-xl bg-gradient-to-br from-emerald-100 to-green-100 text-gray-800 shadow-md hover:shadow-lg transform transition-all duration-200 hover:scale-105">
                                    {{ $word }}
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <!-- Follow Along Button -->
                    <div class="text-center mb-8">
                        <button @click="readAlongMode()"
                                :disabled="isReading"
                                :class="isReading ? 'opacity-50' : ''"
                                class="px-8 py-4 bg-gradient-to-r from-blue-500 to-indigo-500 text-white text-xl font-bold rounded-2xl shadow-lg hover:shadow-xl transform transition-all hover:scale-105">
                            <span x-show="!isReading">📖 Read Along (Word by Word)</span>
                            <span x-show="isReading">🎵 Reading...</span>
                        </button>
                    </div>

                    <!-- Category Badge -->
                    <div class="flex justify-center mb-8">
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
                            $emoji = $categoryEmojis[$sentence->category] ?? '📝';
                        @endphp
                        <span class="px-6 py-3 bg-emerald-100 text-emerald-800 rounded-full text-lg font-bold">
                            {{ $emoji }} {{ ucfirst($sentence->category) }}
                        </span>
                    </div>

                    <!-- Voice Recognition Section -->
                    <div class="bg-blue-50 rounded-2xl p-6 mb-8" x-show="!completed">
                        <h4 class="text-xl font-bold text-blue-800 mb-4 text-center">🎤 Voice Recognition</h4>
                        <p class="text-center text-gray-600 mb-4">Speak with natural pacing and intonation</p>
                        
                        <!-- Microphone Button -->
                        <div class="flex flex-col items-center">
                            <button @click="startRecording()"
                                    :disabled="!speechSupported || isRecording"
                                    :class="{
                                        'bg-red-500 animate-pulse ring-4 ring-red-300': isRecording,
                                        'bg-green-500 hover:bg-green-600': !isRecording && speechSupported,
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
                                <span x-show="!isRecording && !transcript">Click 🎤 and read the sentence aloud</span>
                                <span x-show="isRecording" class="text-red-600 font-bold">🎙️ Listening... Read the sentence now!</span>
                            </p>

                            <!-- Transcript Display -->
                            <div x-show="transcript" class="mt-4 p-4 bg-white rounded-xl shadow w-full">
                                <p class="text-sm text-gray-500 mb-1">You said:</p>
                                <p class="text-xl font-bold text-center" :class="isCorrect ? 'text-green-600' : 'text-red-600'" x-text="transcript"></p>
                            </div>

                            <!-- Voice Not Supported Message -->
                            <div x-show="!speechSupported" class="mt-4 p-4 bg-yellow-100 rounded-xl w-full text-center">
                                <p class="text-yellow-800 font-medium">⚠️ Voice recognition is not supported in your browser.</p>
                                <p class="text-yellow-700 text-sm mt-1">Please use Google Chrome or Microsoft Edge.</p>
                            </div>

                            <!-- Feedback -->
                            <div x-show="feedback" class="mt-4 p-4 rounded-xl w-full text-center"
                                 :class="isCorrect ? 'bg-green-100' : 'bg-orange-100'">
                                <p class="text-xl font-bold" :class="isCorrect ? 'text-green-600' : 'text-orange-600'" x-text="feedback"></p>
                                <button x-show="!isCorrect" @click="resetAttempt()" 
                                        class="mt-2 px-4 py-2 bg-orange-500 text-white rounded-lg font-bold hover:bg-orange-600">
                                    🔄 Try Again
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Completion Section -->
                    <div x-show="completed" class="text-center">
                        <div class="bg-gradient-to-r from-yellow-100 to-green-100 rounded-2xl p-8 mb-6">
                            <div class="text-6xl mb-4">🎉</div>
                            <h3 class="text-3xl font-bold text-green-600 mb-2">Excellent Reading!</h3>
                            <p class="text-xl text-gray-600">Perfect intonation and pacing!</p>
                            <div class="text-4xl mt-4">⭐⭐⭐</div>
                        </div>
                        
                        <div class="flex justify-center gap-4">
                            @if($nextSentence)
                                <a href="{{ route('levels.sentences.practice', $nextSentence->id) }}" 
                                   class="inline-block px-8 py-4 bg-gradient-to-r from-green-500 to-emerald-500 text-white text-xl font-bold rounded-2xl shadow-lg hover:shadow-xl transform transition-all hover:scale-105">
                                    Next Sentence →
                                </a>
                            @else
                                <a href="{{ route('levels.sentences') }}" 
                                   class="inline-block px-8 py-4 bg-gradient-to-r from-green-500 to-emerald-500 text-white text-xl font-bold rounded-2xl shadow-lg hover:shadow-xl transform transition-all hover:scale-105">
                                    ✓ View All Sentences
                                </a>
                            @endif
                        </div>

                        <!-- Level Complete Check -->
                        <div x-show="levelCompleted" class="mt-6 p-4 bg-green-100 rounded-xl">
                            <p class="text-xl font-bold text-green-700">🏆 Level 3 Complete!</p>
                            <p class="text-green-600 mb-2">You've unlocked Level 4: Reading Comprehension!</p>
                            <p class="text-2xl font-bold text-green-800">Your Score: <span x-text="score"></span>/{{ $totalSentences }} items</p>
                            <p class="text-sm text-green-600 mt-1">Redirecting to Level 4 in <span x-text="countdown"></span> seconds...</p>
                            <a :href="nextLevelUrl" class="inline-block mt-2 px-6 py-2 bg-green-500 text-white rounded-lg font-bold hover:bg-green-600">
                                Go to Level 4 Now →
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function sentencePractice() {
            return {
                activeWord: null,
                highlightedWords: [],
                transcript: '',
                feedback: '',
                isCorrect: false,
                completed: false,
                levelCompleted: false,
                isReading: false,
                isRecording: false,
                speechSupported: true,
                sentence: '{{ $sentence->sentence }}',
                words: @json(preg_split('/\s+/', $sentence->sentence)),
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
                    setTimeout(() => this.speakSentence(), 500);
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
                        return utterance;
                    }
                },

                speakSentence() {
                    this.speak(this.sentence, 0.8);
                },

                speakWord(word, index) {
                    this.activeWord = index;
                    this.speak(word, 0.7);
                    setTimeout(() => this.activeWord = null, 600);
                },

                async readAlongMode() {
                    this.isReading = true;
                    this.highlightedWords = [];
                    
                    for (let i = 0; i < this.words.length; i++) {
                        this.activeWord = i;
                        this.highlightedWords.push(i);
                        const word = this.words[i].replace(/[^a-zA-Z]/g, '');
                        this.speak(word, 0.65);
                        await new Promise(resolve => setTimeout(resolve, 700));
                    }
                    
                    this.activeWord = null;
                    this.isReading = false;
                    
                    setTimeout(() => this.speakSentence(), 300);
                },

                checkPronunciation(spoken) {
                    const cleanSpoken = spoken.replace(/[^a-z\s]/gi, '').toLowerCase().trim();
                    const targetSentence = this.sentence.replace(/[^a-z\s]/gi, '').toLowerCase().trim();

                    const similarity = this.calculateSimilarity(cleanSpoken, targetSentence);
                    
                    if (similarity > 0.80) {
                        this.isCorrect = true;
                        this.feedback = '🎉 Perfect! Excellent reading with great pacing!';
                        this.speak('Perfect! Excellent reading!');
                        
                        fetch(`/levels/sentences/{{ $sentence->id }}/complete`, {
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
                        this.feedback = `❌ Almost there! Focus on clear pronunciation. (${Math.round(similarity * 100)}% match)`;
                        this.speak('Almost there. Try again with clear pronunciation.');
                        setTimeout(() => this.speakSentence(), 1500);
                    }
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
                    this.highlightedWords = [];
                    this.manualInput = '';
                    this.recordingTime = 0;
                    this.speakSentence();
                },

                startCountdown() {
                    const interval = setInterval(() => {
                        this.countdown--;
                        if (this.countdown <= 0) {
                            clearInterval(interval);
                            window.location.href = this.nextLevelUrl;
                        }
                    }, 1000);
                }
            }
        }
    </script>
</x-app-layout>
