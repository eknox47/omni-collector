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

            $table->string('isbn')->unique();
            $table->unsignedBigInteger('work_id')->nullable();
            $table->string('asin')->nullable();

            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->string('author')->nullable();
            $table->text('description')->nullable();
            $table->string('publisher')->nullable();
            $table->string('language')->nullable();
            $table->date('published_date')->nullable();

            $table->integer('page_count')->nullable();

            $table->string('format_code')->nullable();
            $table->string('format_description')->nullable();

            $table->decimal('price_amount', 8, 2)->nullable();
            $table->string('price_currency', 3)->nullable();

            $table->decimal('length', 6, 3)->nullable();
            $table->decimal('width', 6, 3)->nullable();
            $table->decimal('depth', 6, 3)->nullable();
            $table->decimal('gross_weight', 6, 3)->nullable();

            $table->string('cover_url')->nullable();

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