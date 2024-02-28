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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('main_category_id')->constrained('main_categories')->onDelete('cascade');
            $table->string('name', 90);
            $table->text('description')->nullable();
            $table->string('title')->nullable();
            $table->foreignId('image_id')->nullable()->constrained('images')->onDelete('cascade');
            $table->string('slug', 90)->unique();
            $table->timestamps();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
