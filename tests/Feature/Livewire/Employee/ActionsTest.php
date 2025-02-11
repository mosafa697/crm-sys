<?php

namespace Tests\Feature\Livewire\Employee;

use App\Models\User;
use Database\Seeders\RoleSeeder;
use Livewire\Livewire;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ActionsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RoleSeeder::class);
    }

    public function test_log_action()
    {
        $employee = User::factory()->create();
        $employee->assignRole('employee');

        $customer = User::factory()->create();
        $customer->assignRole('customer');

        $this->actingAs($employee);

        Livewire::test('employee.actions')
            ->set('customer_id', $customer->id)
            ->set('type', 'call')
            ->set('result', 'Successful call')
            ->call('logAction')
            ->assertSessionHas('success', 'Action logged successfully.');

        $this->assertDatabaseHas('actions', [
            'employee_id' => $employee->id,
            'customer_id' => $customer->id,
            'type'        => 'call',
            'result'      => 'Successful call',
        ]);
    }

    public function test_log_action_validation_error()
    {
        $employee = User::factory()->create();

        $this->actingAs($employee);

        Livewire::test('employee.actions')
            ->set('customer_id', '')
            ->set('type', '')
            ->set('result', '')
            ->call('logAction')
            ->assertHasErrors(['customer_id' => 'required', 'type' => 'required', 'result' => 'required']);
    }
}