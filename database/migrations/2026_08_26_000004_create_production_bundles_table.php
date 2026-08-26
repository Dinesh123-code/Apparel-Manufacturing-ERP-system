<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('production_bundles', function (Blueprint $table) {
            $table->id();
            $table->string('bundle_no', 50)->unique();
            $table->foreignId('buyer_id')->constrained('buyers')->onDelete('restrict');
            $table->foreignId('style_id')->constrained('styles')->onDelete('restrict');
            $table->string('color', 100)->nullable();
            $table->string('size', 50)->nullable();
            $table->foreignId('line_id')->constrained('sewing_lines')->onDelete('restrict');
            $table->unsignedInteger('quantity')->default(0);
            $table->unsignedInteger('completed_qty')->default(0);
            $table->unsignedInteger('rejected_qty')->default(0);
            $table->string('operator_name', 150)->nullable();
            $table->date('production_date');
            $table->text('remarks')->nullable();
            $table->softDeletes();
            $table->timestamps();

            // Performance indexes
            $table->index('bundle_no');
            $table->index('buyer_id');
            $table->index('style_id');
            $table->index('line_id');
            $table->index('production_date');
            $table->index('operator_name');
            $table->index('color');
            $table->index(['buyer_id', 'style_id', 'production_date']);
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('production_bundles');
    }
};
