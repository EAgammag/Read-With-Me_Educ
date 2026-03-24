<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Let\'s Read!') }}
            </h2>
            <a href="{{ route('words.index') }}" class="text-blue-600 hover:underline">Back to List</a>
        </div>
    </x-slot>

    <div class="py-12" x-data="wordPractice({ 
        word: '{{ $word->word }}', 
        phonemes: {{ json_encode($word->phonemes) }}, 
        sentence: '{{ $word->example_sentence }}' 
    })">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-3xl p-8 md:p-12 text-center">
                
                <!-- Word Display -->
                <div class="mb-12">
                    <p class="text-gray-500 uppercase tracking-widest mb-4">Click each sound:</p>
                    <div class="inline-flex gap-4">
                        @foreach($word->phonemes as $index => $phoneme)
                            <button 
                                @click="playPhoneme('{{ $phoneme }}', {{ $index }})"
                                :class="{ 'scale-110 bg-yellow-300 ring-4 ring-yellow-400': activePhoneme === {{ $index }}, 'bg-blue-100 hover:bg-blue-200': activePhoneme !== {{ $index }} }"
                                class="w-24 h-24 md:w-32 md:h-32 flex items-center justify-center rounded-2xl text-5xl md:text-7xl font-bold text-blue-900 shadow-md transition-all duration-200 active:translate-y-1">
                                {{ $phoneme }}
                            </button>
                        @endforeach
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-wrap justify-center gap-6 mb-12">
                    <button @click="readFullWord" 
                            class="px-8 py-4 bg-green-500 hover:bg-green-600 text-white rounded-full text-2xl font-bold shadow-lg transform transition active:scale-95 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z" />
                        </svg>
                        Play Full Word
                    </button>
                </div>

                <!-- Contextual Sentence -->
                <div class="bg-gray-50 rounded-2xl p-6 md:p-10 border-2 border-dashed border-gray-200">
                    <p class="text-sm text-gray-500 mb-6 uppercase tracking-widest">Listen to the word in a sentence:</p>
                    <div class="text-3xl md:text-5xl font-medium leading-tight text-gray-800 mb-8">
                        <template x-for="(segment, index) in sentenceSegments" :key="index">
                            <span 
                                :id="'word-' + index"
                                :class="{ 'bg-yellow-200 rounded px-1 transition-colors duration-200': activeWordIndex === index }"
                                class="inline-block mx-1 cursor-pointer hover:text-blue-600 transition"
                                @click="playSpecificWord(segment, index)"
                                x-text="segment"
                            ></span>
                        </template>
                    </div>
                    <button @click="readFullSentence" 
                            class="px-6 py-3 bg-indigo-500 hover:bg-indigo-600 text-white rounded-xl font-bold shadow flex items-center gap-2 mx-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Read Sentence
                    </button>
                </div>
            </div>
        </div>

        <script>
            function wordPractice(data) {
                return {
                    word: data.word,
                    phonemes: data.phonemes,
                    sentence: data.sentence,
                    sentenceSegments: data.sentence.split(' '),
                    activePhoneme: null,
                    activeWordIndex: -1,
                    synth: window.speechSynthesis,

                    playPhoneme(phoneme, index) {
                        this.activePhoneme = index;
                        const utterance = new SpeechSynthesisUtterance(phoneme);
                        // Adjust pitch/rate for clearer phoneme sounds if needed
                        utterance.rate = 0.5; 
                        utterance.pitch = 1.2;
                        utterance.onend = () => { this.activePhoneme = null; };
                        this.synth.cancel();
                        this.synth.speak(utterance);
                    },

                    readFullWord() {
                        const utterance = new SpeechSynthesisUtterance(this.word);
                        utterance.rate = 0.8;
                        this.synth.cancel();
                        this.synth.speak(utterance);
                    },

                    playSpecificWord(word, index) {
                        this.activeWordIndex = index;
                        const utterance = new SpeechSynthesisUtterance(word.replace(/[^a-zA-Z\s]/g, ''));
                        utterance.onend = () => { this.activeWordIndex = -1; };
                        this.synth.cancel();
                        this.synth.speak(utterance);
                    },

                    readFullSentence() {
                        this.synth.cancel();
                        const utterance = new SpeechSynthesisUtterance(this.sentence);
                        utterance.rate = 0.8;
                        
                        // Basic visual tracking using boundary event
                        utterance.onboundary = (event) => {
                            if (event.name === 'word') {
                                // Calculate which word index is being read
                                const charIndex = event.charIndex;
                                const textBefore = this.sentence.substring(0, charIndex).trim();
                                this.activeWordIndex = textBefore ? textBefore.split(' ').length : 0;
                            }
                        };

                        utterance.onend = () => {
                            this.activeWordIndex = -1;
                        };

                        this.synth.speak(utterance);
                    }
                }
            }
        </script>
    </div>
</x-app-layout>
