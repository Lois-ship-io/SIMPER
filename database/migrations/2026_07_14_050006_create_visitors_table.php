<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('visitors', function (Blueprint $table) {
            $table->id();
            $table->string('visitor_code');
            $table->foreignId('member_id')->nullable()->constrained('members')->nullOnDelete();
            $table->string('name');
            $table->enum('gender', ['L', 'P'])->nullable();
            $table->text('address')->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('purpose')->nullable();
            $table->date('visit_date');
            $table->time('check_in')->nullable();
            $table->time('check_out')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete()->comment('Petugas');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visitors');
    }
};
