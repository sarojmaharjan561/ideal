<x-layout>
    <x-form title="Log In" description="Sign in to access your ideas.">
        <form class="mt-8 space-y-8" action="/login" method="POST">
            @csrf
            <div class="space-y-4">
                <x-form.field label="Email" name="email" type="email" />
                <x-form.field label="Password" name="password" type="password" />
            </div>

            <div>
                <button type="submit" class="btn h-10 w-full" data-test="login-button"> Sign In </button>
            </div>
        </form>
    </x-form>
</x-layout>