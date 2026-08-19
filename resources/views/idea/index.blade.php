<x-layout>
    <div>
        <header class="py-8 md:py-12">
            <h1 class="text-3xl font-bold">Ideas</h1>
            <p class="text-muted-foreground text-sm mt-2">Manage your ideas and share them with the world.</p>

            <x-card 
                x-data
                @click="$dispatch('open-modal','create-idea')"
                is="button" 
                type="button"
                data-test="create-idea-button"
                class="mt-10 cursor-pointer h-32 w-full text-left">
                <p>What's your idea</p>
            </x-card>
        </header>

        <div>
            
            <a href="/ideas" class="btn {{ request()->has('status') ? 'btn-outlined' : '' }}">
                All 
                <span class="text-sm pl-3">
                        {{ $statusCounts->get('all') }}
                </span>
            </a>

            @foreach (App\IdeaStatus::cases() as $status)
                <a href="/ideas?status={{ $status->value }}" class="btn {{ request('status') === $status->value ? '' : 'btn-outlined' }}">
                    {{ $status->label() }} 
                    <span class="text-sm pl-3">
                        {{ $statusCounts->get($status->value) }}
                    </span>
                </a>
            @endforeach

        </div>

        <div class="mt-10 text-muted-foreground">
            <div class="grid md:grid-cols-2 gap-6">
                @forelse ($ideas as $idea)
                    <x-card href="{{ route('ideas.show', $idea) }}" class="hover:bg-accent hover:text-foreground transition-colors">
                        <h3 class="text-foreground text-lg">{{ $idea->title }}</h3>

                        <div class="mt-1">
                            <x-idea.status-label status="{{ $idea->status }}">
                                {{ $idea->status->label() }}
                            </x-idea.status-label>
                        </div>

                        <div class="mt-5 line-clamp-3">{{ $idea->description }}</div>
                        <div class="text-sm text-muted-foreground mt-4">
                            {{ $idea->created_at->diffForHumans() }}
                        </div>
                    </x-card>
                @empty
                    <x-card>
                        <p class="text-muted-foreground">You have no ideas yet. Start by creating a new idea.</p>
                    </x-card>
                @endforelse
            </div>
        </div>

        <x-modal name="create-idea" title="New Idea">
            <form 
                x-data="{
                    status:'pending',
                    newLink:'',
                    links:[]
                    }" 
                method="POST" 
                action="{{ route('ideas.store') }}">
                @csrf
                <div class="space-y-6">
                    <x-form.field
                        label="Title"
                        name="title"
                        placeholder="Enter an idea for your title "
                        required
                        autofocus
                    />

                    <div class="space-y-2">
                        <label for="status" class="label">Status</label>

                        <div class="flex gap-x-3">
                            @foreach (App\IdeaStatus::cases() as $status)
                                <button 
                                    type="button"
                                    @click="status = @js($status->value)"
                                    class="btn flex-1 h-10"
                                    data-test="button-status-{{ $status->value }}"
                                    :class="{'btn-outlined' : status !== @js(($status->value))}"
                                    >
                                        {{$status->label()}}
                                </button>
                            @endforeach

                            <input type="hidden" name="status" :value="status" class="input">

                        </div>
                        <x-form.error name="status" />
                    </div>

                    <x-form.field
                        label="Description"
                        name="description"
                        type="textarea"
                        placeholder="Describe your idea..."
                        autofocus
                    />

                    <div>
                        <fieldset class="space-y-3">
                            <legend class="label">Links</legend>

                            <template x-for="(link,index) in links">
                                <div class="flex gap-x-2 items-center"> 
                                    <input class="input flex-1" type="text" name="links[]" x-model="link" disabled>
                                    <button
                                        type="button"
                                        @click="links.splice(index,1)"
                                        aria-label="Remove this link"
                                        class="form-muted-icon"
                                    >
                                        <span class="text-xl">X</span>
                                    </button>
                                <div>
                            </template>

                            <div class="flex gap-x-2 items-center"> 
                                <input 
                                    x-model="newLink"
                                    type="url" 
                                    id="new-link"
                                    data-test="new-link"
                                    placeholder="https://example.com"
                                    autocomplete="url"
                                    class="input flex-1"
                                    spellcheck="false"
                                >
                                <button
                                    type="button"
                                    @click="links.push(newLink.trim()); newLink='';"
                                    :disabled="newLink.trim().length === 0"
                                    aria-label="Add new link"
                                    class="form-muted-icon"
                                    data-test="submit-new-link-button"
                                >
                                    <span class="text-4xl">+</span>
                                </button>
                            </div>
                        </fieldset>
                    </div>

                    <div class="flex justify-end gap-x-5">
                        <button type="button" @click="$dispatch('close-modal')">Cancel</button>
                        <button type="submit" class="btn">Create</button>
                    </div>
                    
                </div>
            </form>
        </x-modal>
    </div>
</x-layout>