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
        Schema::create('ppdb_applicants', function (Blueprint $table) {
            $table->id();
            $table->string('registration_number')->unique()->nullable(); // Nomor pendaftaran unik
            $table->string('full_name');
            $table->string('birth_place');
            $table->date('birth_date');
            $table->string('gender');
            $table->text('address');
            $table->string('previous_school');
            $table->string('nisn')->nullable();

            // Data Orang Tua/Wali
            $table->string('father_name');
            $table->string('father_job');
            $table->string('mother_name');
            $table->string('mother_job');
            $table->string('parent_phone');
            $table->string('parent_email')->nullable();

            // Path Dokumen (akan disimpan di storage/app/public)
            $table->string('akta_kelahiran_path')->nullable();
            $table->string('kk_path')->nullable();
            $table->string('ijazah_path')->nullable();

            $table->string('status')->default('pending'); // pending, accepted, rejected
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ppdb_applicants');
    }
};