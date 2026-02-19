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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('pr_code')->unique();
            $table->string('sku')->nullable()->index();
            $table->string('barcode')->nullable()->index();
            $table->string('pr_name');
            $table->string('pr_short_desc')->nullable();
            $table->text('pr_desc')->nullable();
            $table->unsignedBigInteger('cat_id')->index()->nullable();
            $table->unsignedBigInteger('brand_id')->index()->nullable();
            $table->string('pr_thumbnail')->nullable();
            $table->decimal('avg_cost', 12, 2)->default(0.00);
            $table->string('uom')->nullable();
            $table->integer('alert_threshold')->nullable();
            $table->string('status')->default('active');
            $table->boolean('is_track_inventory')->default(true);  //Some items might be services (e.g., "PC Cleaning")
            $table->string('serial_number')->nullable();
            $table->string('warranty_info')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
