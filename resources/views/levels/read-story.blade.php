<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                📖 {{ $story->title }}
            </h2>
            <a href="{{ route('levels.stories') }}" class="text-purple-600 hover:text-purple-800 font-bold">
                ← Back to Stories
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-purple-50 via-violet-50 to-indigo-50 min-h-screen" 
         x-data="storyReader()" x-init="init()">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Reading Mode Info -->
            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg mb-6" x-show="!showQuestions">
                <div class="flex items-center">
                    <div class="text-2xl mr-3">📚</div>
                    <div>
                        <p class="font-bold text-blue-800">Silent or Guided Reading Mode</p>
                        <p class="text-blue-600 text-sm">No voice detection required. Read at your own pace, then answer comprehension questions.</p>
                    </div>
                </div>
            </div>

            <!-- Story Section -->
            <div x-show="!showQuestions" class="bg-white rounded-3xl shadow-2xl overflow-hidden">
                <!-- Header -->
                <div class="bg-gradient-to-r from-purple-400 to-violet-500 p-8 text-white text-center">
                    <div class="text-8xl mb-4">{{ $story->image_emoji }}</div>
                    <h1 class="text-4xl font-bold">{{ $story->title }}</h1>
                </div>

                <!-- Story Content -->
                <div class="p-8">
                    <!-- Optional: Read Aloud Button (for assisted reading) -->
                    <div class="text-center mb-6">
                        <button @click="readStory()"
                                :disabled="isReading"
                                class="px-6 py-3 bg-gradient-to-r from-blue-500 to-indigo-500 text-white font-bold rounded-xl hover:shadow-lg transition-all"
                                :class="isReading ? 'opacity-50' : ''">
                            <span x-show="!isReading">🔊 Read Story Aloud (Optional)</span>
                            <span x-show="isReading">📖 Reading...</span>
                        </button>
                        <button @click="stopReading()" x-show="isReading"
                                class="ml-2 px-6 py-3 bg-red-500 text-white font-bold rounded-xl hover:bg-red-600 transition-all">
                            ⏹️ Stop
                        </button>
                    </div>

                    <!-- Story Text -->
                    <div class="prose prose-lg max-w-none">
                        @foreach(explode("\n\n", $story->content) as $paragraph)
                            <p class="text-xl leading-relaxed text-gray-800 mb-6 p-4 rounded-xl hover:bg-purple-50 transition-colors">
                                {{ $paragraph }}
                            </p>
                        @endforeach
                    </div>

                    <!-- Ready for Questions Button -->
                    <div class="text-center mt-8 space-y-4">
                        <p class="text-gray-600">When you've finished reading, test your understanding:</p>
                        <button @click="startQuestions()"
                                class="px-8 py-4 bg-gradient-to-r from-green-500 to-emerald-500 text-white text-xl font-bold rounded-2xl shadow-lg hover:shadow-xl transform transition-all hover:scale-105">
                            📝 Start Comprehension Test
                        </button>
                        <p class="text-sm text-gray-500">You will type your answers to multiple-choice questions</p>
                    </div>
                </div>
            </div>

            <!-- Questions Section -->
            <div x-show="showQuestions" x-cloak>
                <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">
                    <!-- Header -->
                    <div class="bg-gradient-to-r from-green-400 to-emerald-500 p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="text-2xl font-bold">📝 Comprehension Test</h2>
                                <p class="text-green-100 text-sm">Select the best answer for each question</p>
                            </div>
                            <span class="text-xl bg-white/20 px-4 py-2 rounded-full">
                                Question <span x-text="currentQuestion + 1"></span> of {{ count($story->questions) }}
                            </span>
                        </div>
                        <!-- Progress Bar -->
                        <div class="mt-4 bg-white/30 rounded-full h-3">
                            <div class="bg-white rounded-full h-3 transition-all duration-500"
                                 :style="'width: ' + ((currentQuestion + 1) / {{ count($story->questions) }} * 100) + '%'"></div>
                        </div>
                    </div>

                    <!-- Question Content -->
                    <div class="p-8">
                        @foreach($story->questions as $index => $question)
                            <div x-show="currentQuestion === {{ $index }}" class="question-slide">
                                <h3 class="text-2xl font-bold text-gray-800 mb-6">
                                    {{ $question->question }}
                                </h3>

                                <div class="space-y-4">
                                    @foreach($question->options as $optionIndex => $option)
                                        <button @click="selectAnswer({{ $index }}, '{{ addslashes($option) }}', '{{ addslashes($question->correct_answer) }}')"
                                                :disabled="answered[{{ $index }}]"
                                                :class="{
                                                    'ring-4 ring-green-500 bg-green-100': answered[{{ $index }}] && '{{ addslashes($option) }}' === '{{ addslashes($question->correct_answer) }}',
                                                    'ring-4 ring-red-500 bg-red-100': answered[{{ $index }}] && selectedAnswers[{{ $index }}] === '{{ addslashes($option) }}' && '{{ addslashes($option) }}' !== '{{ addslashes($question->correct_answer) }}',
                                                    'hover:bg-purple-50 hover:border-purple-400': !answered[{{ $index }}]
                                                }"
                                                class="w-full p-4 text-left text-lg border-2 border-gray-200 rounded-xl transition-all disabled:cursor-not-allowed">
                                            <span class="font-bold text-purple-600 mr-2">{{ chr(65 + $optionIndex) }}.</span>
                                            {{ $option }}
                                        </button>
                                    @endforeach
                                </div>

                                <!-- Feedback -->
                                <div x-show="answered[{{ $index }}]" class="mt-6 p-4 rounded-xl"
                                     :class="selectedAnswers[{{ $index }}] === '{{ addslashes($question->correct_answer) }}' ? 'bg-green-100' : 'bg-orange-100'">
                                    <p class="text-xl font-bold"
                                       :class="selectedAnswers[{{ $index }}] === '{{ addslashes($question->correct_answer) }}' ? 'text-green-600' : 'text-orange-600'">
                                        <span x-show="selectedAnswers[{{ $index }}] === '{{ addslashes($question->correct_answer) }}'">
                                            ✅ Correct! Great comprehension!
                                        </span>
                                        <span x-show="selectedAnswers[{{ $index }}] !== '{{ addslashes($question->correct_answer) }}'">
                                            ❌ Not quite. The correct answer is: {{ $question->correct_answer }}
                                        </span>
                                    </p>
                                </div>

                                <!-- Next/Complete Button -->
                                <div x-show="answered[{{ $index }}]" class="mt-6 text-center">
                                    @if($index < count($story->questions) - 1)
                                        <button @click="nextQuestion()"
                                                class="px-8 py-3 bg-gradient-to-r from-purple-500 to-violet-500 text-white text-xl font-bold rounded-xl hover:shadow-lg transition-all">
                                            Next Question →
                                        </button>
                                    @else
                                        <button @click="completeStory()"
                                                class="px-8 py-3 bg-gradient-to-r from-green-500 to-emerald-500 text-white text-xl font-bold rounded-xl hover:shadow-lg transition-all">
                                            Complete Story! 🎉
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Back to Story Button -->
                <div class="mt-4 text-center">
                    <button @click="showQuestions = false"
                            class="text-purple-600 hover:text-purple-800 font-bold">
                        ← Read the story again
                    </button>
                </div>
            </div>

            <!-- Completion Modal -->
            <div x-show="showCompletion" x-cloak
                 class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
                <div class="bg-white rounded-3xl shadow-2xl p-8 max-w-md mx-4 text-center transform scale-100 animate-bounce-once">
                    <div class="text-8xl mb-4">🏆</div>
                    <h2 class="text-3xl font-bold text-gray-800 mb-2">Story Complete!</h2>
                    <p class="text-xl text-gray-600 mb-4">
                        You got <span x-text="correctCount" class="font-bold text-green-600"></span> out of {{ count($story->questions) }} correct!
                    </p>
                    <div class="text-4xl mb-6">
                        <template x-for="i in 3">
                            <span :class="correctCount >= i ? '' : 'opacity-30'">⭐</span>
                        </template>
                    </div>
                    
                    <div class="bg-purple-50 rounded-xl p-4 mb-6">
                        <p class="text-purple-800 font-medium">
                            <span x-show="correctCount === {{ count($story->questions) }}">🎉 Perfect score! Outstanding comprehension!</span>
                            <span x-show="correctCount >= {{ count($story->questions) / 2 }} && correctCount < {{ count($story->questions) }}">👍 Good job! Keep reading to improve!</span>
                            <span x-show="correctCount < {{ count($story->questions) / 2 }}">📚 Try reading more carefully next time!</span>
                        </p>
                    </div>

                    <a href="{{ route('levels.stories') }}"
                       class="inline-block px-8 py-4 bg-gradient-to-r from-purple-500 to-violet-500 text-white text-xl font-bold rounded-2xl shadow-lg hover:shadow-xl transition-all">
                        Continue →
                    </a>
                </div>
            </div>
        </div>
    </div>

    <style>
        [x-cloak] { display: none !important; }
        @keyframes bounce-once {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        .animate-bounce-once {
            animation: bounce-once 0.5s ease-in-out;
        }
    </style>

    <script>
        function storyReader() {
            return {
                showQuestions: false,
                showCompletion: false,
                currentQuestion: 0,
                selectedAnswers: {},
                answered: {},
                correctCount: 0,
                isReading: false,
                storyContent: @json($story->content),

                init() {
                    // No auto-reading - user reads at their own pace
                },

                speakText(text, rate = 0.9) {
                    if ('speechSynthesis' in window) {
                        window.speechSynthesis.cancel();
                        const utterance = new SpeechSynthesisUtterance(text);
                        utterance.rate = rate;
                        utterance.pitch = 1.0;
                        window.speechSynthesis.speak(utterance);
                    }
                },

                readStory() {
                    this.isReading = true;
                    if ('speechSynthesis' in window) {
                        window.speechSynthesis.cancel();
                        const utterance = new SpeechSynthesisUtterance(this.storyContent);
                        utterance.rate = 0.85;
                        utterance.pitch = 1.0;
                        utterance.onend = () => this.isReading = false;
                        window.speechSynthesis.speak(utterance);
                    }
                },

                stopReading() {
                    if ('speechSynthesis' in window) {
                        window.speechSynthesis.cancel();
                    }
                    this.isReading = false;
                },

                startQuestions() {
                    this.stopReading();
                    this.showQuestions = true;
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                },

                selectAnswer(questionIndex, selected, correct) {
                    if (this.answered[questionIndex]) return;
                    
                    this.selectedAnswers[questionIndex] = selected;
                    this.answered[questionIndex] = true;
                    
                    if (selected === correct) {
                        this.correctCount++;
                    }
                },

                nextQuestion() {
                    this.currentQuestion++;
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                },

                completeStory() {
                    const totalQuestions = {{ count($story->questions) }};
                    const score = Math.round((this.correctCount / totalQuestions) * 100);
                    
                    fetch(`/levels/stories/{{ $story->id }}/complete`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ score: score })
                    }).then(() => {
                        this.showCompletion = true;
                    });
                }
            }
        }
    </script>
</x-app-layout>
