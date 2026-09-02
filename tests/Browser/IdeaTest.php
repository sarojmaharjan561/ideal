<?php

use App\Models\Idea;
use App\Models\User;

it('create a idea', function () {
    $this->actingAs($user = User::factory()->create());

    visit('/ideas')
        ->click('@create-idea-button')
        ->fill('title', 'Some Example Title')
        ->click('@button-status-completed')
        ->fill('description', 'Some Example Description')
        ->fill('@new-link', 'https://laracast.com')
        ->click('@submit-new-link-button')
        ->fill('@new-link', 'https://laravel.com')
        ->click('@submit-new-link-button')
        ->fill('@new-step', 'Do a thing')
        ->click('@submit-new-step-button')
        ->fill('@new-step', 'Do another thing')
        ->click('@submit-new-step-button')
        ->click('Create')
        ->assertPathIs('/ideas');

    expect($idea = $user->ideas()->first())->toMatchArray([
        'title' => 'Some Example Title',
        'status' => 'completed',
        'description' => 'Some Example Description',
        'links' => ['https://laracast.com', 'https://laravel.com'],
    ]);

    expect($idea->steps)->toHaveCount(2);
});

it('Edit an idea', function () {
    $this->actingAs($user = User::factory()->create());

    $idea = Idea::factory()->for($user)->create();

    visit(route('idea.show', $idea))
        ->click('@edit-idea-button')
        ->fill('title', 'Some Example Title')
        ->click('@button-status-completed')
        ->fill('description', 'Some Example Description')
        ->fill('@new-link', 'https://laracast.com')
        ->click('@submit-new-link-button')
        ->fill('@new-link', 'https://laravel.com')
        ->click('@submit-new-link-button')
        ->fill('@new-step', 'Do a thing')
        ->click('@submit-new-step-button')
        ->fill('@new-step', 'Do another thing')
        ->click('@submit-new-step-button')
        ->click('Create')
        ->assertPathIs('/ideas');

    expect($idea = $user->ideas()->first())->toMatchArray([
        'title' => 'Some Example Title',
        'status' => 'completed',
        'description' => 'Some Example Description',
        'links' => ['https://laracast.com', 'https://laravel.com'],
    ]);

    expect($idea->steps)->toHaveCount(2);
});
