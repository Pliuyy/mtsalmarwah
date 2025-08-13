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
        Schema::create('carousels', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->string('image_path')->nullable(); // Path gambar carousel
            $table->string('video_url')->nullable(); // URL video (misal: YouTube embed link)
            $table->enum('type', ['image', 'video']); // Tipe slide: gambar atau video
            $table->string('button_text')->nullable(); // Teks tombol (misal: "Daftar Sekarang")
            $table->string('button_link')->nullable(); // Link tombol
            $table->integer('order')->default(0); // Urutan tampilan
            $table->boolean('is_active')->default(true); // Aktif/Tidak aktif
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carousels');
    }
};