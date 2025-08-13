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
    Schema::create('galleries', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->enum('type', ['photo', 'video']); // Hanya bisa 'photo' atau 'video'
        $table->string('file_path'); // Path file gambar atau URL video YouTube
        $table->string('thumbnail_path')->nullable(); // Untuk video, thumbnail
        $table->foreignId('gallery_category_id')->nullable()->constrained('gallery_categories')->onDelete('set null');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('galleries');
    }
};
