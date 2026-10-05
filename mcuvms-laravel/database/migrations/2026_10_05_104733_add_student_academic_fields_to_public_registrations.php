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
            if (!Schema::hasColumn('public_registrations', 'degree_level')) {
                $table->string('degree_level', 50)->nullable()->after('student_id')->comment('ระดับการศึกษา เช่น ปริญญาตรี ปริญญาโท ปริญญาเอก ประกาศนียบัตร');
            }
            if (!Schema::hasColumn('public_registrations', 'faculty')) {
                $table->string('faculty', 150)->nullable()->after('degree_level')->comment('คณะ');
            }
            if (!Schema::hasColumn('public_registrations', 'org_unit_id')) {
                $table->unsignedBigInteger('org_unit_id')->nullable()->after('faculty')->comment('ส่วนจัดการศึกษาภายใน มจร (ID)');
            }
            if (!Schema::hasColumn('public_registrations', 'program_name')) {
                $table->string('program_name', 200)->nullable()->after('org_unit_id')->comment('หลักสูตร/สาขาวิชา');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('public_registrations', function (Blueprint $table) {
            $table->dropColumn(['degree_level', 'faculty', 'org_unit_id', 'program_name']);
        });
    }
};
