<?php

use App\Models\User;

it ('admin user can access admin dashboard', function () {
    $adminUser = User::factory()->create([
        'role' => User::ROLE_ADMIN,
    ]);

    $response = $this->actingAs($adminUser)->get('/admin/dashboard');
    $response->assertStatus(200);
});

it ('customer user cannot access admin dashboard', function () {
    $customerUser = User::factory()->create([
        'role' => User::ROLE_CUSTOMER,
    ]);

    $response = $this->actingAs($customerUser)->get('/admin/dashboard');
    $response->assertRedirect('/');
});

it ('customer user can access customer dashboard', function () {
    $customerUser = User::factory()->create([
        'role' => User::ROLE_CUSTOMER,
    ]);

    $response = $this->actingAs($customerUser)->get('/customer/dashboard');
    $response->assertStatus(200);
});

it ('admin user cannot access customer dashboard', function () {
    $adminUser = User::factory()->create([
        'role' => User::ROLE_ADMIN,
    ]);

    $response = $this->actingAs($adminUser)->get('/customer/dashboard');
    $response->assertRedirect('/');
});

