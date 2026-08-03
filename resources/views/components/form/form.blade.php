@props(['title','description'])

<div class="flex min-h-[calc(100vh-4rem)] items-center justify-center px-4">
    <div class="w-full max-w-md">
        <div class="text-center">
            {{-- <img class="mx-auto h-12 w-auto" src="{{ asset('images/logo.svg') }}" alt="Idea Logo"> --}}
            <h1 class="text-3xl font-bold tracking-tight">{{ $title }}</h1>
            <p class="mt-1 text-muted-foreground">{{ $description }}</p>
        </div>

        {{ $slot }}
    </div>
</div>