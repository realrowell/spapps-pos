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
            $table->id();
            $table->unsignedBigInteger('trans_id')->index();
            $table->unsignedBigInteger('pr_id')->nullable()->index();
            $table->string('pr_name');
            $table->string('uom');
            $table->string('qty');
            $table->string('price_type');
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
