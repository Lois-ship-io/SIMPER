<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('returns', function (Blueprint $table) {
            $table->id();
            $table->string('return_code')->unique();
            $table->foreignId('borrowing_id')->constrained('borrowings')->restrictOnDelete();
            $table->date('return_date');
            $table->integer('late_days')->default(0);
            $table->decimal('total_fine', 12, 2)->default(0);
            $table->enum('fine_status', ['no_fine', 'unpaid', 'paid', 'partial'])->default('no_fine');
            $table->decimal('paid_amount', 12, 2)->default(0);
            $table->foreignId('user_id')->constrained('users')->restrictOnDelete()->comment('Petugas');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('return_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('return_id')->constrained('returns')->cascadeOnDelete();
            $table->foreignId('borrowing_detail_id')->constrained('borrowing_details')->restrictOnDelete();
            $table->foreignId('book_id')->constrained('books')->restrictOnDelete();
            $table->integer('qty')->default(1);
            $table->enum('condition', ['good', 'damaged', 'lost'])->default('good');
            $table->integer('late_days')->default(0);
            $table->decimal('fine_amount', 12, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('return_details');
        Schema::dropIfExists('returns');
    }
};
