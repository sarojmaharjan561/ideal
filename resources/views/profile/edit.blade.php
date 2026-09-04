<x-layout>
    <x-form title="Edit Profile" description="Update your profile information.">
        <form class="mt-10 space-y-4" action="{{ route('profile.update') }}" method="POST">
            @csrf
            @method('PATCH')    
            <div class="space-y-4">
                <x-form.field label="Name" name="name" :value="$user->name"/>
                <x-form.field label="Email" name="email" type="email" :value="$user->email"/>
                <x-form.field label="Password" name="password" type="password" />
            </div>

            <div>
                <button type="submit" class="btn h-10 w-full"> Update Profile </button>
            </div>
        </form>
    </x-form>
</x-layout>