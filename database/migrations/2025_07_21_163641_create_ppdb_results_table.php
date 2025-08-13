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
    Schema::create('ppdb_results', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->string('file_path')->nullable(); // Jika hasil dalam PDF
        $table->text('content')->nullable(); // Jika hasil langsung di halaman
        $table->timestamp('published_at');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ppdb_results');
    }
};
