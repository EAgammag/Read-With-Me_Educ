<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.users.index') }}" class="text-gray-400 hover:text-gray-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                👤 Student: {{ $user->name }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Student Info Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                        <div class="flex items-center mb-4 md:mb-0">
                            <div class="w-16 h-16 rounded-full bg-indigo-100 flex items-center justify-center text-2xl font-bold text-indigo-600">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div class="ml-4">
                                <h3 class="text-2xl font-bold text-gray-800">{{ $user->name }}</h3>
                                <p class="text-gray-500">{{ $user->email }}</p>
                                <p class="text-sm text-gray-400">Member since {{ $user->created_at->format('F d, Y') }}</p>
                            </div>
                        </div>
                        
                        <!-- Level Adjustment -->
                        <div class="flex items-center gap-4">
                            <form action="{{ route('admin.users.updateLevel', $user) }}" method="POST" class="flex items-center gap-2">
                                @csrf
                                @method('PATCH')
                                <label class="text-sm font-medium text-gray-600">Level:</label>
                                <select name="level" class="rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @for($i = 1; $i <= 10; $i++)
                                        <option value="{{ $i }}" {{ $user->level == $i ? 'selected' : '' }}>{{ $i }}</option>
                                    @endfor
                                </select>
                                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition text-sm">
                                    Update
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Progress Stats -->
            <div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                    <p class="text-3xl font-bold text-indigo-600">{{ $user->level }}</p>
                    <p class="text-sm text-gray-500">Current Level</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                    <p class="text-3xl font-bold text-blue-600">{{ $progressStats['words_practiced'] }}</p>
                    <p class="text-sm text-gray-500">Words Practiced</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                    <p class="text-3xl font-bold text-green-600">{{ $progressStats['words_mastered'] }}</p>
                    <p class="text-sm text-gray-500">Words Mastered</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                    <p class="text-3xl font-bold text-purple-600">{{ $progressStats['total_attempts'] }}</p>
                    <p class="text-sm text-gray-500">Total Attempts</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                    <p class="text-3xl font-bold {{ $progressStats['accuracy'] >= 80 ? 'text-green-600' : ($progressStats['accuracy'] >= 50 ? 'text-amber-600' : 'text-red-600') }}">
                        {{ $progressStats['accuracy'] }}%
                    </p>
                    <p class="text-sm text-gray-500">Overall Accuracy</p>
                </div>
            </div>

            <!-- Word Progress Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">📚 Word Progress Details</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Word</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Attempts</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Correct</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Accuracy</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Last Practiced</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($wordProgress as $progress)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-bold">
                                            {{ $progress->word->word }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $progress->attempts }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $progress->correct_attempts }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="w-16 bg-gray-200 rounded-full h-2 mr-2">
                                                <div class="h-2 rounded-full {{ $progress->accuracy >= 80 ? 'bg-green-500' : ($progress->accuracy >= 50 ? 'bg-amber-500' : 'bg-red-500') }}" 
                                                     style="width: {{ $progress->accuracy }}%"></div>
                                            </div>
                                            <span class="text-sm font-medium {{ $progress->accuracy >= 80 ? 'text-green-600' : ($progress->accuracy >= 50 ? 'text-amber-600' : 'text-red-600') }}">
                                                {{ $progress->accuracy }}%
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($progress->mastered)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                ✓ Mastered
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                ⏳ In Progress
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $progress->updated_at->diffForHumans() }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                        <div class="flex flex-col items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                            </svg>
                                            <p>This student hasn't practiced any words yet.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
