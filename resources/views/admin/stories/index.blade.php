<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                📖 {{ __('Manage Stories') }}
            </h2>
            <a href="{{ route('admin.stories.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add Story
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <!-- Search & Filter -->
                <div class="p-6 border-b border-gray-200">
                    <form method="GET" action="{{ route('admin.stories.index') }}" class="flex flex-col md:flex-row gap-4">
                        <div class="flex-1">
                            <input type="text" name="search" value="{{ request('search') }}" 
                                   placeholder="Search stories by title..." 
                                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div>
                            <select name="difficulty" class="rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">All Difficulties</option>
                                @for($i = 1; $i <= 10; $i++)
                                    <option value="{{ $i }}" {{ request('difficulty') == $i ? 'selected' : '' }}>Level {{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <button type="submit" class="px-6 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-700 transition">
                            Filter
                        </button>
                        @if(request('search') || request('difficulty'))
                            <a href="{{ route('admin.stories.index') }}" class="px-4 py-2 text-gray-600 hover:text-gray-800">
                                Clear
                            </a>
                        @endif
                    </form>
                </div>

                <!-- Stories Grid -->
                <div class="p-6">
                    @if($stories->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($stories as $story)
                                <div class="bg-gray-50 rounded-xl p-6 hover:shadow-lg transition">
                                    <div class="flex items-start justify-between mb-4">
                                        <div class="text-4xl">{{ $story->image_emoji ?? '📖' }}</div>
                                        <span class="px-3 py-1 rounded-full text-sm font-medium
                                            {{ $story->difficulty >= 7 ? 'bg-red-100 text-red-800' : ($story->difficulty >= 4 ? 'bg-amber-100 text-amber-800' : 'bg-green-100 text-green-800') }}">
                                            Level {{ $story->difficulty }}
                                        </span>
                                    </div>
                                    <h3 class="text-lg font-bold text-gray-800 mb-2">{{ $story->title }}</h3>
                                    <p class="text-gray-600 text-sm mb-4 line-clamp-3">{{ Str::limit($story->content, 100) }}</p>
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-500">
                                            {{ $story->questions_count }} {{ Str::plural('question', $story->questions_count) }}
                                        </span>
                                        <div class="flex gap-2">
                                            <a href="{{ route('admin.stories.edit', $story) }}" class="px-3 py-1 bg-indigo-100 text-indigo-700 rounded-lg text-sm hover:bg-indigo-200 transition">
                                                Edit
                                            </a>
                                            <form action="{{ route('admin.stories.destroy', $story) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this story and all its questions?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-3 py-1 bg-red-100 text-red-700 rounded-lg text-sm hover:bg-red-200 transition">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2 2 0 00-2-2h-2" />
                            </svg>
                            <p class="text-gray-500 mb-4">No stories found.</p>
                            <a href="{{ route('admin.stories.create') }}" class="text-indigo-600 hover:text-indigo-800">Create your first story →</a>
                        </div>
                    @endif
                </div>

                <!-- Pagination -->
                @if($stories->hasPages())
                    <div class="p-6 border-t border-gray-200">
                        {{ $stories->withQueryString()->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-admin-layout>
