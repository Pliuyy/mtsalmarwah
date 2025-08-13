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
        Schema::table('ppdb_applicants', function (Blueprint $table) {
            $table->string('father_income')->nullable()->after('parent_email');
            $table->string('mother_income')->nullable()->after('father_income');
            $table->string('pas_foto_path')->nullable()->after('ijazah_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ppdb_applicants', function (Blueprint $table) {
            $table->dropColumn(['father_income', 'mother_income', 'pas_foto_path']);
        });
    }
};
