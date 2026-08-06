<x-layout>
    <x-slot name="title">Ideas</x-slot>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="bg-white p-4 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold mb-2">{{ $idea->title }}</h2>
            <p class="text-gray-600 mb-4">{{ $idea->description }}</p>
            <p class="text-sm text-gray-500">By {{ $idea->user->name }}</p>
            <p class="text-sm text-gray-500">Steps: {{ $idea->steps->count() }}</p>
        </div>

    </div>
</x-layout>