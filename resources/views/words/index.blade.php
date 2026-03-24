<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Sight Words') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                        @foreach($words as $word)
                            <a href="{{ route('words.show', $word) }}" 
                               class="flex items-center justify-center p-8 bg-blue-100 border-2 border-blue-200 rounded-xl hover:bg-blue-200 hover:scale-105 transition-transform text-2xl font-bold text-blue-800 shadow-sm">
                                {{ $word->word }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
