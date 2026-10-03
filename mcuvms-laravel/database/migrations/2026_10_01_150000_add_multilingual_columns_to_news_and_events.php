<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations to add English title, content, location for multilingual portal display.
     */
    public function up(): void
    {
        // 1. news_articles
        Schema::table('news_articles', function (Blueprint $table) {
            if (!Schema::hasColumn('news_articles', 'title_en')) {
                $table->string('title_en', 255)->nullable()->after('title');
            }
            if (!Schema::hasColumn('news_articles', 'content_en')) {
                $table->text('content_en')->nullable()->after('content');
            }
        });

        // 2. ug_batches
        Schema::table('ug_batches', function (Blueprint $table) {
            if (!Schema::hasColumn('ug_batches', 'title_en')) {
                $table->string('title_en', 255)->nullable()->after('title');
            }
            if (!Schema::hasColumn('ug_batches', 'location_en')) {
                $table->string('location_en', 255)->nullable()->after('location');
            }
        });

        // 3. public_events
        Schema::table('public_events', function (Blueprint $table) {
            if (!Schema::hasColumn('public_events', 'title_en')) {
                $table->string('title_en', 255)->nullable()->after('title');
            }
            if (!Schema::hasColumn('public_events', 'location_name_en')) {
                $table->string('location_name_en', 255)->nullable()->after('location_name');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('news_articles', function (Blueprint $table) {
            $table->dropColumn(['title_en', 'content_en']);
        });

        Schema::table('ug_batches', function (Blueprint $table) {
            $table->dropColumn(['title_en', 'location_en']);
        });

        Schema::table('public_events', function (Blueprint $table) {
            $table->dropColumn(['title_en', 'location_name_en']);
        });
    }
};
