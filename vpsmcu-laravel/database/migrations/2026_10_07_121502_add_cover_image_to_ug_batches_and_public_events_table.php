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
        if (Schema::hasTable('ug_batches') && !Schema::hasColumn('ug_batches', 'cover_image')) {
            Schema::table('ug_batches', function (Blueprint $table) {
                $table->string('cover_image', 500)->nullable()->after('location_en');
            });
        }

        if (Schema::hasTable('public_events') && !Schema::hasColumn('public_events', 'cover_image')) {
            Schema::table('public_events', function (Blueprint $table) {
                $table->string('cover_image', 500)->nullable()->after('location_name_en');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('ug_batches') && Schema::hasColumn('ug_batches', 'cover_image')) {
            Schema::table('ug_batches', function (Blueprint $table) {
                $table->dropColumn('cover_image');
            });
        }

        if (Schema::hasTable('public_events') && Schema::hasColumn('public_events', 'cover_image')) {
            Schema::table('public_events', function (Blueprint $table) {
                $table->dropColumn('cover_image');
            });
        }
    }
};
