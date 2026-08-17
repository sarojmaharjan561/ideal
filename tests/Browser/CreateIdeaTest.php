<?php

use App\Models\User;

it('create a idea', function () {
    $this->actingAs($user = User::factory()->create());

    visit('/ideas')
        ->click('@create-idea-button')
        ->fill('title', 'Some Example Title')
        ->click('@button-status-completed')
        ->fill('description', 'Some Example Description')
        ->click('Create')
        ->assertPathIs('/ideas');

    expect($user->ideas()->first())->toMatchArray([
        'title' => 'Some Example Title',
        'status' => 'completed',
        'description' => 'Some Example Description',
    ]);
});
