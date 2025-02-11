<?php

namespace Tests\Feature\Livewire\Admin;

use App\Models\User;
use Database\Seeders\RoleSeeder;
use Livewire\Livewire;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CustomersTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RoleSeeder::class);
    }

    public function test_add_customer()
    {
        $this->actingAs(User::factory()->create());

        Livewire::test('admin.customers')
            ->set('name', 'John Doe')
            ->set('email', 'john@example.com')
            ->call('addCustomer')
            ->assertSessionHas('success', 'Customer added successfully.');
    }

    public function test_add_customer_validation_error()
    {
        $this->actingAs(User::factory()->create());

        Livewire::test('admin.customers')
            ->set('name', '')
            ->set('email', 'invalid-email')
            ->call('addCustomer')
            ->assertHasErrors(['name' => 'required', 'email' => 'email']);
    }

    public function test_add_customer_duplicate_email()
    {
        User::factory()->create(['email' => 'john@example.com']);

        $this->actingAs(User::factory()->create());

        Livewire::test('admin.customers')
            ->set('name', 'John Doe')
            ->set('email', 'john@example.com')
            ->call('addCustomer')
            ->assertHasErrors(['email' => 'unique']);
    }
}