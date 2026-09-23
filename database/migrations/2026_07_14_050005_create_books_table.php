<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('book_code')->unique();
            $table->string('isbn')->unique()->nullable();
            $table->string('title');
            $table->foreignId('category_id')->constrained('categories')->restrictOnDelete();
            $table->string('author');
            $table->foreignId('publisher_id')->nullable()->constrained('publishers')->nullOnDelete();
            $table->year('publish_year')->nullable();
            $table->foreignId('rack_id')->nullable()->constrained('racks')->nullOnDelete();
            $table->integer('total_qty')->default(0);
            $table->integer('available_qty')->default(0);
            $table->string('cover')->nullable();
            $table->text('description')->nullable();
            $table->enum('status', ['available', 'unavailable'])->default('available');
            $table->string('qr_code')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
