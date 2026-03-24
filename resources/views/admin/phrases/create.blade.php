<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.phrases.index') }}" class="text-gray-400 hover:text-gray-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                ➕ {{ __('Add New Phrase') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <form action="{{ route('admin.phrases.store') }}" method="POST" class="p-6 space-y-6">
                    @csrf

                    <div>
                        <label for="phrase" class="block text-sm font-medium text-gray-700 mb-2">Phrase *</label>
                        <input type="text" name="phrase" id="phrase" value="{{ old('phrase') }}" required
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-lg"
                               placeholder="e.g., Good morning">
                        @error('phrase')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="meaning" class="block text-sm font-medium text-gray-700 mb-2">Meaning</label>
                        <textarea name="meaning" id="meaning" rows="2"
                                  class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                  placeholder="e.g., A greeting used in the morning">{{ old('meaning') }}</textarea>
                        @error('meaning')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="example_sentence" class="block text-sm font-medium text-gray-700 mb-2">Example Sentence</label>
                        <textarea name="example_sentence" id="example_sentence" rows="2"
                                  class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                  placeholder="e.g., Good morning! How are you today?">{{ old('example_sentence') }}</textarea>
                        @error('example_sentence')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="difficulty" class="block text-sm font-medium text-gray-700 mb-2">Difficulty Level *</label>
                        <select name="difficulty" id="difficulty" required
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @for($i = 1; $i <= 10; $i++)
                                <option value="{{ $i }}" {{ old('difficulty', 1) == $i ? 'selected' : '' }}>
                                    Level {{ $i }} {{ $i <= 3 ? '(Easy)' : ($i <= 6 ? '(Medium)' : '(Hard)') }}
                                </option>
                            @endfor
                        </select>
                        @error('difficulty')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-end gap-4 pt-4 border-t">
                        <a href="{{ route('admin.phrases.index') }}" class="px-4 py-2 text-gray-600 hover:text-gray-800">
                            Cancel
                        </a>
                        <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                            Create Phrase
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
