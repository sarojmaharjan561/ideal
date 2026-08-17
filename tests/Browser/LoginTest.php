<?php

use App\Models\User;

it('login a user', function (): void {

    $user = User::factory()->create(['password' => 'password']);

    visit('/login')
        ->fill('email', $user->email)
        ->fill('password', 'password')
        ->click('@login-button')
        ->assertPathIs('/ideas');

    $this->assertAuthenticated();
});

it('logout a user', function (): void {

    $user = User::factory()->create();

    $this->actingAs($user);

    visit('/')
        ->click('@logout-button');

    $this->assertGuest();
});
