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
        Schema::create('trans_discounts', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('trans_id');
            $table->string('disc_id')->nullable();
            $table->decimal('amount', 15, 2)->default(0);
            $table->string('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trans_discounts');
    }
};
