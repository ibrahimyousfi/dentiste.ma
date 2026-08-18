<?php

use App\Models\Organization;
use App\Models\User;

test('authenticated users can access listing pages', function () {
    $org = Organization::create([
        'name' => 'Test Dental Clinic',
        'email' => 'clinic@test.com',
    ]);

    $user = User::factory()->create([
        'organization_id' => $org->id,
    ]);

    $this->actingAs($user)
        ->get('/patients')
        ->assertOk();

    $this->actingAs($user)
        ->get('/treatment-plans')
        ->assertOk();

    $this->actingAs($user)
        ->get('/prescriptions')
        ->assertOk();

    $this->actingAs($user)
        ->get('/inventory')
        ->assertOk();

    $this->actingAs($user)
        ->get('/lab-cases')
        ->assertOk();
});
