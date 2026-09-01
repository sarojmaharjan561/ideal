<x-modal name="create-idea" title="New Idea">
    <form 
        x-data="{
            status:'pending',
            newStep:'',
            steps:[],
            newLink:'',
            links:[]
            }" 
        method="POST" 
        action="{{ route('idea.store') }}"
        enctype="multipart/form-data"
    >
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

            <div class="space-y-2">
                <label for="image" class="label">Feature Image</label>
                <input type="file" name="image" accept="image/*">
                <x-form.error name="image" />
            </div>
            
            <div>
                <fieldset class="space-y-3">
                    <legend class="label">Actionable Steps</legend>

                    <template x-for="(step,index) in steps" :key="step">
                        <div class="flex gap-x-2 items-center"> 
                            <input class="input" type="text" name="steps[]" x-model="step" readonly>
                            <button
                                type="button"
                                @click="steps.splice(index,1)"
                                aria-label="Remove this step"
                                class="form-muted-icon"
                            >
                                <span class="text-xl">X</span>
                            </button>
                        <div>
                    </template>

                    <div class="flex gap-x-2 items-center"> 
                        <input 
                            x-model="newStep"
                            id="new-step"
                            data-test="new-step"
                            placeholder="Actionable steps"
                            class="input flex-1"
                            spellcheck="false"
                        >
                        <button
                            type="button"
                            @click="steps.push(newStep.trim()); newStep='';"
                            :disabled="newStep.trim().length === 0"
                            aria-label="Add new link"
                            class="form-muted-icon"
                            data-test="submit-new-step-button"
                        >
                            <span class="text-4xl">+</span>
                        </button>
                    </div>
                </fieldset>
            </div>

            <div>
                <fieldset class="space-y-3">
                    <legend class="label">Links</legend>

                    <template x-for="(link,index) in links" :key="link">
                        <div class="flex gap-x-2 items-center"> 
                            <input class="input" type="text" name="links[]" x-model="link" readonly>
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