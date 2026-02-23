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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('sale_ref')->unique();
            $table->string('trans_type')->default('sale');
            $table->decimal('gross_amount', 12, 2);
            $table->decimal('total_discount_amount', 12, 2)->default(0);
            $table->decimal('tax_amount', 12, 2)->default(0);
            $table->decimal('net_amount', 12, 2);
            $table->string('status');
            $table->string('transacted_by');
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->unsignedBigInteger('store_id')->nullable()->index();
            $table->dateTime('completed_at')->nullable();
            $table->unsignedBigInteger('parent_sale_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
