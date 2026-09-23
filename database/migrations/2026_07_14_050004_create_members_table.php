<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('member_code')->unique();
            $table->string('nis')->unique();
            $table->string('name');
            $table->enum('gender', ['L', 'P'])->comment('L=Laki-laki, P=Perempuan');
            $table->string('class')->nullable();
            $table->string('major')->nullable();
            $table->string('phone', 20)->nullable();
            $table->text('address')->nullable();
            $table->string('photo')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
