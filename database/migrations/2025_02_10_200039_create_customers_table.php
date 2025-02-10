<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained('users', 'id')->cascadeOnDelete()->cascadeOnUpdate()
                ->comment('Customer user id to store its data');

            $table->foreignId('assigned_to')->nullable()->constrained('users', 'id')->cascadeOnDelete()->cascadeOnUpdate()
                ->comment('Employee Id who assigned this customer');

            $table->foreignId('created_by')->constrained('users', 'id')->cascadeOnDelete()->cascadeOnUpdate()
                ->comment('User Id who created this customer (Admin or Employee)');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
