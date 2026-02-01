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
        Schema::create('pr_inventories', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('pr_id')->index();
            $table->decimal('stock_qty', 10, 3)->default(0);
            $table->string('loc_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pr_inventories');
    }
};
