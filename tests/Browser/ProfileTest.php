<?php

use App\Models\User;
use App\Notifications\EmailChanged;
use Illuminate\Support\Facades\Notification;

it('requires authentication to edit a profile', function () {
    $this->get(route('profile.edit'))->assertRedirect(route('login'));
});

it('edits a profile', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    visit(route('profile.edit'))
        ->assertValue('name', $user->name)
        ->fill('name', 'New Name')
        ->assertValue('email', $user->email)
        ->fill('email', 'newemail@example.com')
        ->click('Update Profile')
        ->assertSee('Profile updated successfully.');

    expect($user->fresh())
        ->toMatchArray([
            'name' => 'New Name',
            'email' => 'newemail@example.com',
        ]);
});

it('notifies the original email if changed', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    $originalEmail = $user->email;

    Notification::fake();

    visit(route('profile.edit'))
        ->assertValue('email', $user->email)
        ->fill('email', 'newemail@example.com')
        ->click('Update Profile')
        ->assertSee('Profile updated successfully.');

    Notification::assertSentOnDemand(EmailChanged::class, fn (EmailChanged $notification, $routes, $notifiable) => $notifiable->routes['mail'] === $originalEmail);
});
