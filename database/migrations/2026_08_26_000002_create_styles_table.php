<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('styles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('buyer_id')->constrained('buyers')->onDelete('cascade');
            $table->string('style_no', 100);
            $table->timestamps();
            $table->unique(['buyer_id', 'style_no']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('styles');
    }
};
