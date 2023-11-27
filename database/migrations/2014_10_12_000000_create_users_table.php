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
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Add an auto-incrementing primary key 'id'
            $table->string('staff_id', 50)->unique(); // Optionally, you can keep staff_id as a unique field
            $table->string('name');
            $table->string('position', 255)->default('0');
            $table->string('no');
            $table->string('password');
            $table->string('service');
            $table->string('service2');
            $table->string('division');
            $table->string('category');
            $table->string('email')->nullable();
            $table->string('remember_token', 100)->nullable(); // If you need 'remember_token'
            $table->timestamp('updated_at')->nullable();
            $table->timestamps(); // This includes 'created_at'
            $table->softDeletes(); // Adds 'deleted_at' column for soft deletes
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};