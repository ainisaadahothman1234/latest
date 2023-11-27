<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('histories', function (Blueprint $table) {
            $table->string('staff_id');
            $table->string('title');
            $table->string('position');
            $table->string('action');
            $table->date('date');
            $table->text('details');

            $table->foreign('staff_id')
                ->references('staff_id')
                ->on('users')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    public function down(): void
    {
        Schema::table('histories', function (Blueprint $table) {
            $table->dropForeign(['staff_id']);
        });

        Schema::dropIfExists('histories');
    }
};