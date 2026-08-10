<x-layout>
    <div class="py-8 max-w-4xl mx-auto">

        <div class="flex justify-between items-center">
            <a href="{{ route('ideas.index') }}" class="flex items-center text-sm font-medium">
                Back to ideas
            </a>

            <div class="gap-x-3 flex items-center">
                <button class="btn btn-outlined"> Edit </button>

                <form action="{{ route('ideas.destroy', $idea) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this idea?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outlined text-red-500"> Delete </button>
                </form>
            </div>
            
        </div>

        <div class="mt-8 space-y-6 ">

            <h1 class="text-4xl font-bold mt-6">{{ $idea->title }}</h1>

            <div class="flex gap-x-3 items-center">
                <x-idea.status-label :status="$idea->status->value">
                    {{ $idea->status->label() }}
                </x-idea.status-label>
                <div class="text-sm text-muted-foreground">
                    Created {{ $idea->created_at->diffForHumans() }}
                </div>
            </div>  

            <x-card class="mt-6">
                <div class="text-foreground  max-w-none cursor-pointer">
                    {{ $idea->description }}
                </div>
                <p class="text-sm text-muted-foreground mt-4">By {{ $idea->user->name }}</p>
            </x-card>

            @if($idea->links->count())
                <div>
                    <h3 class="font-bold text-xl mt-6">Links</h3>

                    <div class="mt-3 space-y-2">
                        @foreach ($idea->links as $link)
                            <x-card :href="$link" class="text-primary font-medium hover:underline flex gap-x-3 items-center">
                                {{ $link }}
                            </x-card>
                            
                        @endforeach
                    </div>
                </div>  
            @endif
        </div>
    </div>
</x-layout>