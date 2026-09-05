<?php

use App\Models\Idea;
use App\Models\User;

test('it belongs to a user', function () {
    $idea = Idea::factory()->create();

    expect($idea->user)->toBeInstanceOf(User::class);
});

test('it can have steps', function () {
    $idea = Idea::factory()->create();

    expect($idea->steps)->toBeEmpty();

    $idea->steps()->create([
        'description' => 'To do something',
    ]);

    expect($idea->fresh()->steps)->toHaveCount(1);
});

test('it can format the description as markdown', function () {
    $idea = Idea::factory()->create([
        'description' => 'Hello *World*',
    ]);

    expect($idea->formatedDescription)->toEqual("<p>Hello <em>World</em></p>\n");
});
