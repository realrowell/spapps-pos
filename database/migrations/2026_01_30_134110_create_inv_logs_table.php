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
        Schema::create('inv_logs', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('pr_id')->nullable();
            $table->string('pr_name');
            $table->decimal('qty_change', 10, 3);
            $table->string('loc_id')->nullable();
            $table->decimal('stock_br', 10, 3);
            $table->decimal('stock_af', 10, 3);
            $table->string('ref_type')->nullable();
            $table->string('ref_id')->nullable();
            $table->decimal('unit_cost', 12, 2)->nullable();
            $table->decimal('total_cost', 14, 2)->nullable();
            $table->string('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inv_logs');
    }
};
