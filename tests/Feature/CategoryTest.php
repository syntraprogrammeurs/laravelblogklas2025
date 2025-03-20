<?php

use App\Models\Category;
use App\Models\Role;
use App\Models\User;

it('kan een categorie aanmaken', function () {
    $user = User::factory()->create();
    $adminRole = Role::create(['name' => 'admin']);
    $user->roles()->attach($adminRole);
    $this->actingAs($user);
    $data = ['name' => 'Test Category', 'slug' => 'test-category', 'description' => 'Test Description'];
    $response = $this->post(route('categories.store'), $data);
    $response->assertRedirect(route('categories.index'));
    $this->assertDatabaseHas('categories', $data);
});
it('kan een categorie updaten', function () {
    $user = User::factory()->create();
    $adminRole = Role::create(['name' => 'admin']);
    $user->roles()->attach($adminRole);
    $this->actingAs($user);
    $category = Category::factory()->create();
    $data = ['name' => 'Updated Category', 'slug' => 'updated-category', 'description' => 'Updated Description'];
    $response = $this->put(route('categories.update', $category), $data);
    $response->assertRedirect(route('categories.index'));
    $this->assertDatabaseHas('categories', $data);
});
it('kan een categorie soft deleten', function () {
    $user = User::factory()->create();
    $adminRole = Role::create(['name' => 'admin']);
    $user->roles()->attach($adminRole);
    $this->actingAs($user);
    $category = Category::factory()->create();
    $response = $this->delete(route('categories.destroy', $category));
    $response->assertRedirect(route('categories.index'));
    $this->assertSoftDeleted($category);
});
