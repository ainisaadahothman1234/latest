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
        Schema::create('training', function (Blueprint $table) {
            $table->id();
            $table->text('title');
            $table->string('code', 50)->unique();
            $table->string('type', 255)->default('');
            $table->string('category', 255)->default('');
            $table->string('speaker', 255)->default('');
            $table->string('location', 255)->default('');
            $table->string('price', 255)->default('');
            $table->decimal('duration', 20, 6);
            $table->string('status', 255)->default('Upcoming');
            $table->string('detail', 255)->default('');
            $table->string('remark', 255)->default('');
            $table->string('quantity', 255)->default('');
            $table->integer('enrolled')->default(0);
            $table->date('date_start');
            $table->date('date_end');
            $table->time('time_start');
            $table->time('time_end');
            $table->string('sponsor', 255)->default('0');
            $table->string('organizer', 255)->default('');
            $table->string('food', 255)->default('');
            $table->string('approve_ceo', 255)->default('Pending');
            $table->string('approve_cno', 255)->default('Pending');
            $table->string('req_id', 50);
            $table->string('submit_date', 50)->nullable()->default('');
            $table->timestamps();
            $table->softDeletes(); // Adds 'deleted_at' column for soft deletes

            // Set collation for the entire table
            $table->collation('utf8mb4_unicode_ci');

            // Define foreign key constraint
            $table->foreign('req_id')->references('staff_id')->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training');
    }
};