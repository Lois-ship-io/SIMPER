<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('visitors', function (Blueprint $table) {
            $table->string('visitor_code')->nullable()->change();
            $table->string('name')->nullable()->change();
            $table->date('visit_date')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('visitors', function (Blueprint $table) {
            $table->string('visitor_code')->nullable(false)->change();
            $table->string('name')->nullable(false)->change();
            $table->date('visit_date')->nullable(false)->change();
        });
    }
};
