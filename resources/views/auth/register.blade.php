<x-guest-layout>
    <!-- Registration Header with Animation -->
    <div class="mb-8 text-center animate-fade-in">
        <div class="inline-flex items-center justify-center w-16 h-16 mb-4 rounded-full bg-gradient-to-r from-purple-500 to-pink-600 shadow-lg transform hover:scale-110 transition-transform duration-300">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
            </svg>
        </div>
        <h2 class="text-3xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">Create Your Account</h2>
        <p class="mt-2 text-sm text-gray-600">Join Read With Me and start your learning journey</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <!-- Account Information Section -->
        <div class="pb-6 border-b-2 border-gradient-to-r from-indigo-100 to-purple-100">
            <div class="flex items-center mb-4">
                <div class="flex items-center justify-center w-8 h-8 rounded-full bg-indigo-100 text-indigo-600 font-bold mr-3">
                    1
                </div>
                <h3 class="text-lg font-bold text-gray-800">Account Information</h3>
            </div>
            
            <!-- Name with Icon -->
            <div class="group">
                <x-input-label for="name" :value="__('Full Name')" class="font-semibold" />
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400 group-focus-within:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <x-text-input id="name" class="block w-full pl-10 pr-3 py-2.5 border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 rounded-lg transition-all duration-200 hover:border-indigo-300" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Juan Dela Cruz" />
                </div>
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email with Icon -->
            <div class="mt-4 group">
                <x-input-label for="email" :value="__('Email')" class="font-semibold" />
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400 group-focus-within:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                        </svg>
                    </div>
                    <x-text-input id="email" class="block w-full pl-10 pr-3 py-2.5 border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 rounded-lg transition-all duration-200 hover:border-indigo-300" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="your@email.com" />
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
        </div>

        <!-- Personal Information Section -->
        <div class="pb-6 border-b-2 border-gradient-to-r from-purple-100 to-pink-100">
            <div class="flex items-center mb-4">
                <div class="flex items-center justify-center w-8 h-8 rounded-full bg-purple-100 text-purple-600 font-bold mr-3">
                    2
                </div>
                <h3 class="text-lg font-bold text-gray-800">Personal Information</h3>
            </div>
            
            <!-- Birthdate and Age -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="group">
                    <x-input-label for="birthdate" :value="__('Birthdate')" class="font-semibold" />
                    <div class="relative mt-1">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400 group-focus-within:text-purple-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <x-text-input id="birthdate" class="block w-full pl-10 pr-3 py-2.5 border-gray-300 focus:border-purple-500 focus:ring-2 focus:ring-purple-500 rounded-lg transition-all duration-200 hover:border-purple-300" type="date" name="birthdate" :value="old('birthdate')" required />
                    </div>
                    <x-input-error :messages="$errors->get('birthdate')" class="mt-2" />
                </div>
                <div class="group">
                    <x-input-label for="age" :value="__('Age')" class="font-semibold" />
                    <div class="relative mt-1">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                            </svg>
                        </div>
                        <x-text-input id="age" class="block w-full pl-10 pr-3 py-2.5 bg-gray-50 border-gray-300 rounded-lg" type="number" name="age" :value="old('age')" required min="1" max="100" readonly />
                    </div>
                    <x-input-error :messages="$errors->get('age')" class="mt-2" />
                </div>
            </div>

            <!-- Sex -->
            <div class="mt-4 group">
                <x-input-label for="sex" :value="__('Sex')" class="font-semibold" />
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400 group-focus-within:text-purple-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <select id="sex" name="sex" class="block w-full pl-10 pr-3 py-2.5 border-gray-300 focus:border-purple-500 focus:ring-2 focus:ring-purple-500 rounded-lg transition-all duration-200 hover:border-purple-300 cursor-pointer" required>
                        <option value="">{{ __('Select Sex') }}</option>
                        <option value="male" {{ old('sex') == 'male' ? 'selected' : '' }}>{{ __('Male') }}</option>
                        <option value="female" {{ old('sex') == 'female' ? 'selected' : '' }}>{{ __('Female') }}</option>
                    </select>
                </div>
                <x-input-error :messages="$errors->get('sex')" class="mt-2" />
            </div>
        </div>

        <!-- Academic Information Section -->
        <div class="pb-6 border-b-2 border-gradient-to-r from-pink-100 to-red-100">
            <div class="flex items-center mb-4">
                <div class="flex items-center justify-center w-8 h-8 rounded-full bg-pink-100 text-pink-600 font-bold mr-3">
                    3
                </div>
                <h3 class="text-lg font-bold text-gray-800">Academic Information</h3>
            </div>
            
            <!-- Year Level and Section -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="group">
                    <x-input-label for="year_level" :value="__('Year Level')" class="font-semibold" />
                    <div class="relative mt-1">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400 group-focus-within:text-pink-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <select id="year_level" name="year_level" class="block w-full pl-10 pr-3 py-2.5 border-gray-300 focus:border-pink-500 focus:ring-2 focus:ring-pink-500 rounded-lg transition-all duration-200 hover:border-pink-300 cursor-pointer" required>
                            <option value="">{{ __('Select Year Level') }}</option>
                            <option value="Grade 7" {{ old('year_level') == 'Grade 7' ? 'selected' : '' }}>{{ __('Grade 7') }}</option>
                            <option value="Grade 8" {{ old('year_level') == 'Grade 8' ? 'selected' : '' }}>{{ __('Grade 8') }}</option>
                            <option value="Grade 9" {{ old('year_level') == 'Grade 9' ? 'selected' : '' }}>{{ __('Grade 9') }}</option>
                            <option value="Grade 10" {{ old('year_level') == 'Grade 10' ? 'selected' : '' }}>{{ __('Grade 10') }}</option>
                            <option value="Grade 11" {{ old('year_level') == 'Grade 11' ? 'selected' : '' }}>{{ __('Grade 11') }}</option>
                            <option value="Grade 12" {{ old('year_level') == 'Grade 12' ? 'selected' : '' }}>{{ __('Grade 12') }}</option>
                        </select>
                    </div>
                    <x-input-error :messages="$errors->get('year_level')" class="mt-2" />
                </div>
                <div class="group">
                    <x-input-label for="section" :value="__('Section')" class="font-semibold" />
                    <div class="relative mt-1">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400 group-focus-within:text-pink-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                        <x-text-input id="section" class="block w-full pl-10 pr-3 py-2.5 border-gray-300 focus:border-pink-500 focus:ring-2 focus:ring-pink-500 rounded-lg transition-all duration-200 hover:border-pink-300" type="text" name="section" :value="old('section')" required placeholder="e.g., Section A" />
                    </div>
                    <x-input-error :messages="$errors->get('section')" class="mt-2" />
                </div>
            </div>
        </div>

        <!-- Security Section -->
        <div>
            <div class="flex items-center mb-4">
                <div class="flex items-center justify-center w-8 h-8 rounded-full bg-red-100 text-red-600 font-bold mr-3">
                    4
                </div>
                <h3 class="text-lg font-bold text-gray-800">Security</h3>
            </div>
            
            <!-- Password -->
            <div class="group">
                <x-input-label for="password" :value="__('Password')" class="font-semibold" />
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400 group-focus-within:text-red-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <x-text-input id="password" class="block w-full pl-10 pr-10 py-2.5 border-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-500 rounded-lg transition-all duration-200 hover:border-red-300"
                                    type="password"
                                    name="password"
                                    required autocomplete="new-password" 
                                    placeholder="Create a strong password" />
                    <button type="button" onclick="togglePasswordReg('password')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-red-600 transition-colors">
                        <svg id="eye-icon-pass" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4 group">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="font-semibold" />
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400 group-focus-within:text-red-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <x-text-input id="password_confirmation" class="block w-full pl-10 pr-10 py-2.5 border-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-500 rounded-lg transition-all duration-200 hover:border-red-300"
                                    type="password"
                                    name="password_confirmation" 
                                    required autocomplete="new-password" 
                                    placeholder="Confirm your password" />
                    <button type="button" onclick="togglePasswordReg('password_confirmation')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-red-600 transition-colors">
                        <svg id="eye-icon-confirm" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
        </div>

        <div class="flex flex-col sm:flex-row items-center justify-between pt-4 space-y-3 sm:space-y-0">
            <a class="text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                {{ __('Already registered?') }}
                <span class=\"font-medium text-indigo-600 hover:text-indigo-800\">{{ __('Sign in') }}</span>
            </a>

            <x-primary-button class="w-full sm:w-auto px-8 py-3">
                {{ __('Create Account') }}
            </x-primary-button>
        </div>
    </form>

    <script>
        document.getElementById('birthdate').addEventListener('change', function() {
            const birthdate = new Date(this.value);
            const today = new Date();
            let age = today.getFullYear() - birthdate.getFullYear();
            const monthDiff = today.getMonth() - birthdate.getMonth();
            
            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthdate.getDate())) {
                age--;
            }
            
            document.getElementById('age').value = age > 0 ? age : '';
        });
    </script>
</x-guest-layout>
