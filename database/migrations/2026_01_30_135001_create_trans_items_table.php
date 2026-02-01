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
        Schema::create('trans_items', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('trans_id');
            $table->string('pr_id')->nullable();
            $table->string('pr_name');
            $table->string('uom');
            $table->string('qty');
            $table->decimal('pr_price', 12, 2);
            $table->decimal('line_total', 12, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trans_items');
    }
};
