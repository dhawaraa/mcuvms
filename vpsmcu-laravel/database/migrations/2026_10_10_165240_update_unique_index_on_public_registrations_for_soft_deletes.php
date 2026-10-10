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
        Schema::table('public_registrations', function (Blueprint $table) {
            $table->index('event_id', 'idx_public_reg_event_id');
            $table->dropUnique('unique_public_event');
            $table->unique(['event_id', 'citizen_id', 'deleted_at'], 'unique_public_event');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('public_registrations', function (Blueprint $table) {
            $table->dropUnique('unique_public_event');
            $table->unique(['event_id', 'citizen_id'], 'unique_public_event');
            $table->dropIndex('idx_public_reg_event_id');
        });
    }
};
