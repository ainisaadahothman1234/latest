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
        Schema::create('staff_apply', function (Blueprint $table) {
            $table->id();
            $table->string('training_code', 50)->collation('utf8mb4_unicode_ci');
            $table->string('staff_id', 50)->collation('utf8mb4_unicode_ci');
            $table->decimal('training_hrs', 20, 2);
            $table->string('apply_status', 50)->default('Pending')->collation('utf8mb4_unicode_ci');
            $table->timestamps();

            $table->index('training_code');
            $table->index('staff_id');

            $table->foreign('training_code')
                ->references('code')
                ->on('training')
                ->onUpdate('NO ACTION')
                ->onDelete('NO ACTION');

            $table->foreign('staff_id')
                ->references('staff_id')
                ->on('users')
                ->onUpdate('NO ACTION')
                ->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('staff_apply', function (Blueprint $table) {
            $table->dropForeign('staff_apply_training_code_foreign');
            $table->dropForeign('staff_apply_staff_id_foreign');
        });

        Schema::dropIfExists('staff_apply');
    }
};