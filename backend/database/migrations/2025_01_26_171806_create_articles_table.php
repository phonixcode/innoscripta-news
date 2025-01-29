<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->text('title');
            $table->text('description')->nullable();
            $table->text('content')->nullable();
            $table->text('url'); 
            $table->text('source'); // Source of the article (e.g. NewsAPI, BBC, The Guardian)
            $table->string('category')->nullable(); // Article category (e.g. Technology, Business)
            $table->string('author')->nullable(); // Author of the article
            $table->date('published_at'); // Published date
            $table->text('image_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
