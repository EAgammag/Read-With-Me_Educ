<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.stories.index') }}" class="text-gray-400 hover:text-gray-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                ➕ {{ __('Add New Story') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <form action="{{ route('admin.stories.store') }}" method="POST" class="p-6 space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <div class="md:col-span-3">
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Title *</label>
                            <input type="text" name="title" id="title" value="{{ old('title') }}" required
                                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-lg"
                                   placeholder="e.g., The Little Red Hen">
                            @error('title')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="image_emoji" class="block text-sm font-medium text-gray-700 mb-2">Emoji Icon</label>
                            <input type="text" name="image_emoji" id="image_emoji" value="{{ old('image_emoji', '📖') }}"
                                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-2xl text-center"
                                   placeholder="📖">
                            @error('image_emoji')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Story Content *</label>
                        <textarea name="content" id="content" rows="10" required
                                  class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                  placeholder="Once upon a time...">{{ old('content') }}</textarea>
                        <p class="mt-1 text-sm text-gray-500">Write the full story content here. Use simple sentences for younger readers.</p>
                        @error('content')
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

                    <div class="bg-blue-50 rounded-lg p-4">
                        <p class="text-sm text-blue-800">
                            💡 <strong>Tip:</strong> After creating the story, you'll be able to add comprehension questions.
                        </p>
                    </div>

                    <div class="flex items-center justify-end gap-4 pt-4 border-t">
                        <a href="{{ route('admin.stories.index') }}" class="px-4 py-2 text-gray-600 hover:text-gray-800">
                            Cancel
                        </a>
                        <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                            Create Story
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
