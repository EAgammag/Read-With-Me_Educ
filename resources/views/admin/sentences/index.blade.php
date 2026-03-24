<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                ✍️ {{ __('Manage Sentences') }}
            </h2>
            <a href="{{ route('admin.sentences.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add Sentence
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
                    <form method="GET" action="{{ route('admin.sentences.index') }}" class="flex flex-col md:flex-row gap-4">
                        <div class="flex-1">
                            <input type="text" name="search" value="{{ request('search') }}" 
                                   placeholder="Search sentences..." 
                                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div>
                            <select name="category" class="rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>{{ $category }}</option>
                                @endforeach
                            </select>
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
                        @if(request('search') || request('difficulty') || request('category'))
                            <a href="{{ route('admin.sentences.index') }}" class="px-4 py-2 text-gray-600 hover:text-gray-800">
                                Clear
                            </a>
                        @endif
                    </form>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sentence</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Difficulty</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($sentences as $sentence)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <span class="text-gray-800">{{ $sentence->sentence }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($sentence->category)
                                            <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-sm">{{ $sentence->category }}</span>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 inline-flex items-center rounded-full text-sm font-medium
                                            {{ $sentence->difficulty >= 7 ? 'bg-red-100 text-red-800' : ($sentence->difficulty >= 4 ? 'bg-amber-100 text-amber-800' : 'bg-green-100 text-green-800') }}">
                                            Level {{ $sentence->difficulty }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('admin.sentences.edit', $sentence) }}" class="text-indigo-600 hover:text-indigo-900 mr-4">Edit</a>
                                        <form action="{{ route('admin.sentences.destroy', $sentence) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this sentence?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                        <div class="flex flex-col items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                                            </svg>
                                            <p>No sentences found.</p>
                                            <a href="{{ route('admin.sentences.create') }}" class="mt-4 text-indigo-600 hover:text-indigo-800">Add your first sentence →</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($sentences->hasPages())
                    <div class="p-6 border-t border-gray-200">
                        {{ $sentences->withQueryString()->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-admin-layout>
