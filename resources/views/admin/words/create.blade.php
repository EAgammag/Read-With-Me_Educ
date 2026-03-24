<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.words.index') }}" class="text-gray-400 hover:text-gray-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                ➕ {{ __('Add New Word') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <form action="{{ route('admin.words.store') }}" method="POST" class="p-6 space-y-6">
                    @csrf

                    <div>
                        <label for="word" class="block text-sm font-medium text-gray-700 mb-2">Word *</label>
                        <input type="text" name="word" id="word" value="{{ old('word') }}" required
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-lg"
                               placeholder="e.g., cat">
                        @error('word')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="phonetic_spelling" class="block text-sm font-medium text-gray-700 mb-2">Phonetic Spelling</label>
                        <input type="text" name="phonetic_spelling" id="phonetic_spelling" value="{{ old('phonetic_spelling') }}"
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                               placeholder="e.g., kat">
                        <p class="mt-1 text-sm text-gray-500">How the word sounds when pronounced</p>
                        @error('phonetic_spelling')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="phonemes" class="block text-sm font-medium text-gray-700 mb-2">Phonemes</label>
                        <input type="text" name="phonemes" id="phonemes" value="{{ old('phonemes') }}"
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                               placeholder="e.g., k, a, t">
                        <p class="mt-1 text-sm text-gray-500">Comma-separated sounds that make up the word</p>
                        @error('phonemes')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="example_sentence" class="block text-sm font-medium text-gray-700 mb-2">Example Sentence</label>
                        <textarea name="example_sentence" id="example_sentence" rows="3"
                                  class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                  placeholder="e.g., The cat sat on the mat.">{{ old('example_sentence') }}</textarea>
                        @error('example_sentence')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-end gap-4 pt-4 border-t">
                        <a href="{{ route('admin.words.index') }}" class="px-4 py-2 text-gray-600 hover:text-gray-800">
                            Cancel
                        </a>
                        <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                            Create Word
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
