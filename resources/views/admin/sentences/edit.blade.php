<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.sentences.index') }}" class="text-gray-400 hover:text-gray-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                ✏️ {{ __('Edit Sentence') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <form action="{{ route('admin.sentences.update', $sentence) }}" method="POST" class="p-6 space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="sentence" class="block text-sm font-medium text-gray-700 mb-2">Sentence *</label>
                        <textarea name="sentence" id="sentence" rows="3" required
                                  class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                  placeholder="e.g., The quick brown fox jumps over the lazy dog.">{{ old('sentence', $sentence->sentence) }}</textarea>
                        @error('sentence')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                        <input type="text" name="category" id="category" value="{{ old('category', $sentence->category) }}"
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                               placeholder="e.g., Animals, Nature, Family"
                               list="category-suggestions">
                        <datalist id="category-suggestions">
                            @foreach($categories as $category)
                                <option value="{{ $category }}">
                            @endforeach
                        </datalist>
                        @error('category')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="difficulty" class="block text-sm font-medium text-gray-700 mb-2">Difficulty Level *</label>
                        <select name="difficulty" id="difficulty" required
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @for($i = 1; $i <= 10; $i++)
                                <option value="{{ $i }}" {{ old('difficulty', $sentence->difficulty) == $i ? 'selected' : '' }}>
                                    Level {{ $i }} {{ $i <= 3 ? '(Easy)' : ($i <= 6 ? '(Medium)' : '(Hard)') }}
                                </option>
                            @endfor
                        </select>
                        @error('difficulty')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-end gap-4 pt-4 border-t">
                        <a href="{{ route('admin.sentences.index') }}" class="px-4 py-2 text-gray-600 hover:text-gray-800">
                            Cancel
                        </a>
                        <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                            Update Sentence
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
