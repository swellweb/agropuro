@extends('layouts.app')

@section('content')
<div class="container mx-auto py-12">
    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
        <div class="text-center">
            <h1 class="text-4xl font-bold text-gray-800 dark:text-white mb-4 animate-bounce">Grazie per la tua Donazione!</h1>
            <p class="text-lg text-gray-600 dark:text-gray-300 mb-4">La tua generosità ci aiuta a continuare il nostro lavoro e a supportare le nostre iniziative.</p>
            <p class="text-lg text-gray-600 dark:text-gray-300 mb-8">Abbiamo inviato una conferma al tuo indirizzo email.</p>
            <a href="{{ url('/') }}" class="inline-flex items-center px-6 py-3 bg-blue-500 text-white text-lg font-medium rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition ease-in-out duration-150 animate-pulse">
                Torna alla Home
            </a>
        </div>
    </div>
</div>


@endsection
