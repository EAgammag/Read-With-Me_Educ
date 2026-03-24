<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Admin - {{ config('app.name', 'Read With Me') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 flex">
            <!-- Admin Sidebar -->
            <aside class="hidden lg:flex lg:flex-shrink-0">
                <div class="flex flex-col w-64 bg-slate-800">
                    <!-- Sidebar Header -->
                    <div class="flex items-center justify-center h-16 bg-slate-900">
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2">
                            <span class="text-2xl">⚙️</span>
                            <span class="text-xl font-bold text-white">Admin Panel</span>
                        </a>
                    </div>

                    <!-- Navigation -->
                    <nav class="flex-1 overflow-y-auto py-4">
                        <div class="px-4 space-y-1">
                            <!-- Dashboard -->
                            <a href="{{ route('admin.dashboard') }}" 
                               class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition-all
                                      {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-600 text-white' : 'text-gray-300 hover:bg-slate-700 hover:text-white' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                                Dashboard
                            </a>

                            <div class="pt-4 pb-2">
                                <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Content</p>
                            </div>

                            <!-- Words Management -->
                            <a href="{{ route('admin.words.index') }}" 
                               class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition-all
                                      {{ request()->routeIs('admin.words.*') ? 'bg-indigo-600 text-white' : 'text-gray-300 hover:bg-slate-700 hover:text-white' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                                Words
                            </a>

                            <!-- Phrases -->
                            <a href="{{ route('admin.phrases.index') }}" 
                               class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition-all
                                      {{ request()->routeIs('admin.phrases.*') ? 'bg-indigo-600 text-white' : 'text-gray-300 hover:bg-slate-700 hover:text-white' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                </svg>
                                Phrases
                            </a>

                            <!-- Sentences -->
                            <a href="{{ route('admin.sentences.index') }}" 
                               class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition-all
                                      {{ request()->routeIs('admin.sentences.*') ? 'bg-indigo-600 text-white' : 'text-gray-300 hover:bg-slate-700 hover:text-white' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                                </svg>
                                Sentences
                            </a>

                            <!-- Stories -->
                            <a href="{{ route('admin.stories.index') }}" 
                               class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition-all
                                      {{ request()->routeIs('admin.stories.*') ? 'bg-indigo-600 text-white' : 'text-gray-300 hover:bg-slate-700 hover:text-white' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2 2 0 00-2-2h-2" />
                                </svg>
                                Stories
                            </a>
                        </div>
                    </nav>

                    <!-- User Section at Bottom -->
                    <div class="flex-shrink-0 p-4 border-t border-slate-700">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-indigo-600 flex items-center justify-center text-white font-bold">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-white truncate">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-400 truncate">Administrator</p>
                            </div>
                        </div>
                        <div class="mt-3 space-y-1">
                            <a href="{{ route('dashboard') }}" class="flex items-center gap-2 px-3 py-2 text-sm text-gray-300 hover:bg-slate-700 rounded-lg transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
                                </svg>
                                Back to App
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-2 px-3 py-2 text-sm text-red-400 hover:bg-red-900/30 rounded-lg transition-all">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </aside>

            <!-- Main Content Area -->
            <div class="flex-1 flex flex-col min-w-0">
                <!-- Top Header Bar -->
                <header class="bg-white shadow-sm border-b border-gray-200" x-data="{ mobileMenuOpen: false }">
                    <div class="flex items-center justify-between h-16 px-4 sm:px-6 lg:px-8">
                        <!-- Mobile Menu Button -->
                        <button @click="mobileMenuOpen = !mobileMenuOpen" class="lg:hidden p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>

                        <!-- Page Title -->
                        <div class="flex-1 flex items-center">
                            @isset($header)
                                <div class="flex-1">
                                    {{ $header }}
                                </div>
                            @endisset
                        </div>

                        <!-- Right Side Actions -->
                        <div class="flex items-center gap-4">
                            <span class="hidden sm:inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                Admin Mode
                            </span>
                            <a href="{{ route('dashboard') }}" class="text-sm text-gray-500 hover:text-gray-700">
                                ← Back to App
                            </a>
                        </div>
                    </div>

                    <!-- Mobile Menu -->
                    <div x-show="mobileMenuOpen" x-cloak class="lg:hidden border-t border-gray-200 bg-white">
                        <div class="px-4 py-4 space-y-2">
                            <a href="{{ route('admin.dashboard') }}" 
                               class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium
                                      {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                                📊 Dashboard
                            </a>
                            <hr class="my-2">
                            <p class="px-4 text-xs font-semibold text-gray-400 uppercase">Content</p>
                            <a href="{{ route('admin.words.index') }}" 
                               class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium
                                      {{ request()->routeIs('admin.words.*') ? 'bg-indigo-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                                📚 Words
                            </a>
                            <a href="{{ route('admin.phrases.index') }}" 
                               class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium
                                      {{ request()->routeIs('admin.phrases.*') ? 'bg-indigo-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                                💬 Phrases
                            </a>
                            <a href="{{ route('admin.sentences.index') }}" 
                               class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium
                                      {{ request()->routeIs('admin.sentences.*') ? 'bg-indigo-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                                ✍️ Sentences
                            </a>
                            <a href="{{ route('admin.stories.index') }}" 
                               class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium
                                      {{ request()->routeIs('admin.stories.*') ? 'bg-indigo-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                                📖 Stories
                            </a>
                            <hr class="my-2">
                            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-100">
                                ← Back to App
                            </a>
                        </div>
                    </div>
                </header>

                <!-- Page Content -->
                <main class="flex-1 overflow-y-auto bg-gray-100">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
