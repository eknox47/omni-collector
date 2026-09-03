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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('google_book_id');
            $table->text('description')->nullable();
            $table->integer('page_count')->nullable();
            $table->string('publisher')->nullable();
            $table->string('etag')->nullable();
            $table->string('isbn_10')->nullable();
            $table->string('isbn_13')->nullable();
            $table->integer('average_rating')->nullable();
            $table->integer('ratings_count')->nullable();
            $table->string('language')->nullable();
            $table->date('published_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
