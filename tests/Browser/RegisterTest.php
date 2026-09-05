<?php

it('registers a user', function (): void {
    visit('/register')
        ->fill('name', 'John Doe')
        ->fill('email', 'john@email.com')
        ->fill('password', 'password')
        ->click('Create Account')
        ->assertRoute('idea.index');

    $this->assertAuthenticated();

    $this->assertDatabaseHas('users', [
        'name' => 'John Doe',
        'email' => 'john@email.com',
    ]);
});

it('require a valid email to register', function (): void {
    visit('/register')
        ->fill('name', 'John Doe')
        ->fill('email', 'invalid-email')
        ->fill('password', 'password')
        ->click('Create Account')
        ->assertPathIs('/register');

    $this->assertGuest();
});
