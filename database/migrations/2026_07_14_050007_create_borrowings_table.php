<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('borrowings', function (Blueprint $table) {
            $table->id();
            $table->string('borrowing_code')->unique();
            $table->foreignId('member_id')->constrained('members')->restrictOnDelete();
            $table->date('borrow_date');
            $table->date('due_date');
            $table->foreignId('user_id')->constrained('users')->restrictOnDelete()->comment('Petugas');
            $table->enum('status', ['borrowed', 'returned', 'overdue', 'partial'])->default('borrowed');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('borrowing_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('borrowing_id')->constrained('borrowings')->cascadeOnDelete();
            $table->foreignId('book_id')->constrained('books')->restrictOnDelete();
            $table->integer('qty')->default(1);
            $table->enum('status', ['borrowed', 'returned'])->default('borrowed');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('borrowing_details');
        Schema::dropIfExists('borrowings');
    }
};
