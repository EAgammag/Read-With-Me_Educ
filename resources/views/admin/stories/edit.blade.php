<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.stories.index') }}" class="text-gray-400 hover:text-gray-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                ✏️ {{ __('Edit Story:') }} <span class="text-indigo-600">{{ $story->title }}</span>
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Story Details Form -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">📝 Story Details</h3>
                </div>
                <form action="{{ route('admin.stories.update', $story) }}" method="POST" class="p-6 space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <div class="md:col-span-3">
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Title *</label>
                            <input type="text" name="title" id="title" value="{{ old('title', $story->title) }}" required
                                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-lg">
                            @error('title')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="image_emoji" class="block text-sm font-medium text-gray-700 mb-2">Emoji Icon</label>
                            <input type="text" name="image_emoji" id="image_emoji" value="{{ old('image_emoji', $story->image_emoji ?? '📖') }}"
                                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-2xl text-center">
                            @error('image_emoji')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Story Content *</label>
                        <textarea name="content" id="content" rows="8" required
                                  class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('content', $story->content) }}</textarea>
                        @error('content')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="difficulty" class="block text-sm font-medium text-gray-700 mb-2">Difficulty Level *</label>
                        <select name="difficulty" id="difficulty" required
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @for($i = 1; $i <= 10; $i++)
                                <option value="{{ $i }}" {{ old('difficulty', $story->difficulty) == $i ? 'selected' : '' }}>
                                    Level {{ $i }} {{ $i <= 3 ? '(Easy)' : ($i <= 6 ? '(Medium)' : '(Hard)') }}
                                </option>
                            @endfor
                        </select>
                        @error('difficulty')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-end gap-4 pt-4 border-t">
                        <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                            Update Story
                        </button>
                    </div>
                </form>
            </div>

            <!-- Questions Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-800">❓ Comprehension Questions ({{ $story->questions->count() }})</h3>
                </div>

                <!-- Existing Questions -->
                @if($story->questions->count() > 0)
                    <div class="divide-y divide-gray-200">
                        @foreach($story->questions as $index => $question)
                            <div class="p-6" x-data="{ editing: false }">
                                <div x-show="!editing">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <p class="font-medium text-gray-800 mb-3">
                                                <span class="text-indigo-600 mr-2">Q{{ $index + 1 }}.</span>
                                                {{ $question->question }}
                                            </p>
                                            <div class="grid grid-cols-2 gap-2 text-sm">
                                                @foreach($question->options as $optIndex => $option)
                                                    <div class="flex items-center gap-2 p-2 rounded {{ $optIndex == $question->correct_answer ? 'bg-green-100 text-green-800' : 'bg-gray-50' }}">
                                                        <span class="font-medium">{{ chr(65 + $optIndex) }}.</span>
                                                        {{ $option }}
                                                        @if($optIndex == $question->correct_answer)
                                                            <span class="ml-auto text-green-600">✓</span>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="flex gap-2 ml-4">
                                            <button @click="editing = true" class="text-indigo-600 hover:text-indigo-800 text-sm">Edit</button>
                                            <form action="{{ route('admin.stories.questions.destroy', [$story, $question]) }}" method="POST" class="inline" onsubmit="return confirm('Delete this question?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800 text-sm">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Edit Form -->
                                <form x-show="editing" action="{{ route('admin.stories.questions.update', [$story, $question]) }}" method="POST" class="space-y-4">
                                    @csrf
                                    @method('PUT')
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Question</label>
                                        <input type="text" name="question" value="{{ $question->question }}" required
                                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        @foreach($question->options as $optIndex => $option)
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Option {{ chr(65 + $optIndex) }}</label>
                                                <input type="text" name="options[]" value="{{ $option }}" required
                                                       class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            </div>
                                        @endforeach
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Correct Answer</label>
                                        <select name="correct_answer" required class="rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            @foreach($question->options as $optIndex => $option)
                                                <option value="{{ $optIndex }}" {{ $question->correct_answer == $optIndex ? 'selected' : '' }}>
                                                    {{ chr(65 + $optIndex) }}. {{ Str::limit($option, 30) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="flex gap-2">
                                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 text-sm">Save</button>
                                        <button type="button" @click="editing = false" class="px-4 py-2 text-gray-600 hover:text-gray-800 text-sm">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Add New Question Form -->
                <div class="p-6 bg-gray-50 border-t border-gray-200">
                    <h4 class="font-medium text-gray-800 mb-4">➕ Add New Question</h4>
                    <form action="{{ route('admin.stories.questions.store', $story) }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Question *</label>
                            <input type="text" name="question" required
                                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                   placeholder="e.g., What did the little red hen find?">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Option A *</label>
                                <input type="text" name="options[]" required
                                       class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                       placeholder="First option">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Option B *</label>
                                <input type="text" name="options[]" required
                                       class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                       placeholder="Second option">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Option C</label>
                                <input type="text" name="options[]"
                                       class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                       placeholder="Third option (optional)">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Option D</label>
                                <input type="text" name="options[]"
                                       class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                       placeholder="Fourth option (optional)">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Correct Answer *</label>
                            <select name="correct_answer" required class="rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="0">A (First option)</option>
                                <option value="1">B (Second option)</option>
                                <option value="2">C (Third option)</option>
                                <option value="3">D (Fourth option)</option>
                            </select>
                        </div>
                        <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                            Add Question
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
