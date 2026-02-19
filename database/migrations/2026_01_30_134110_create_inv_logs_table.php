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
            $table->id();
            $table->string('public_id')->unique();
            $table->unsignedBigInteger('pr_id')->index()->nullable();
            $table->string('pr_name');
            $table->decimal('qty_change', 10, 3);
            $table->unsignedBigInteger('loc_id')->index()->nullable();
            $table->decimal('stock_br', 10, 3);
            $table->decimal('stock_af', 10, 3);
            $table->string('ref_type')->nullable();
            $table->unsignedBigInteger('ref_id')->nullable();
            $table->decimal('unit_cost', 12, 2)->nullable();
            $table->decimal('unit_price', 12, 2)->nullable();
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
