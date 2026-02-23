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
        Schema::table('pr_inventories', function (Blueprint $table) {
            $table->foreign('loc_id')->references('id')->on('locations')->nullOnDelete();
            $table->foreign('pr_id')->references('id')->on('products')->onDelete('cascade');
        });
        Schema::table('pr_prices', function (Blueprint $table) {
            $table->foreign('pr_id')->references('id')->on('products')->onDelete('cascade');
        });
        Schema::table('products', function (Blueprint $table) {
            $table->foreign('brand_id')->references('id')->on('pr_brands')->nullOnDelete();
            $table->foreign('cat_id')->references('id')->on('pr_categories')->nullOnDelete();
        });
        Schema::table('inv_logs', function (Blueprint $table) {
            $table->foreign('pr_id')->references('id')->on('products')->nullOnDelete();
            $table->foreign('loc_id')->references('id')->on('locations')->nullOnDelete();
        });
        Schema::table('usr_module_checks', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
        Schema::table('sale_payments', function (Blueprint $table) {
            $table->foreign('sale_id')->references('id')->on('sales')->onDelete('restrict');
            $table->foreign('mop_id')->references('id')->on('mode_of_payments')->nullOnDelete();
        });
        Schema::table('sales', function (Blueprint $table) {
            $table->foreign('store_id')->references('id')->on('stores')->nullOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
            $table->foreign('parent_sale_id')->references('id')->on('sales')->onDelete('restrict');
        });
        Schema::table('sale_items', function (Blueprint $table) {
            $table->foreign('sale_id')->references('id')->on('sales')->onDelete('restrict');
            $table->foreign('pr_id')->references('id')->on('products')->nullOnDelete();
        });
        Schema::table('sale_discounts', function (Blueprint $table) {
            $table->foreign('sale_id')->references('id')->on('sales')->onDelete('restrict');
            $table->foreign('disc_id')->references('id')->on('discounts')->nullOnDelete();
        });
        Schema::table('sale_notes', function (Blueprint $table) {
            $table->foreign('sale_id')->references('id')->on('sales')->onDelete('restrict');
        });
        Schema::table('purchases', function (Blueprint $table) {
            $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('restrict');
            $table->foreign('parent_purchase_id')->references('id')->on('purchases')->onDelete('restrict');
        });
        Schema::table('purchase_payments', function (Blueprint $table) {
            $table->foreign('purchase_id')->references('id')->on('purchases')->onDelete('restrict');
            $table->foreign('mop_id')->references('id')->on('mode_of_payments')->nullOnDelete();
        });
        Schema::table('purchase_items', function (Blueprint $table) {
            $table->foreign('purchase_id')->references('id')->on('purchases')->onDelete('restrict');
            $table->foreign('pr_id')->references('id')->on('products')->nullOnDelete();
        });
        Schema::table('purchase_logs', function (Blueprint $table) {
            $table->foreign('purchase_id')->references('id')->on('purchases')->onDelete('restrict');
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('purchase_logs', function (Blueprint $table) {
            $table->dropForeign(['pruchase_id']);
            $table->dropForeign(['user_id']);
        });

        Schema::table('purchase_items', function (Blueprint $table) {
            $table->dropForeign(['pruchase_id']);
            $table->dropForeign(['pr_id']);
        });

        Schema::table('purchase_payments', function (Blueprint $table) {
            $table->dropForeign(['pruchase_id']);
            $table->dropForeign(['mop_id']);
        });

        Schema::table('purchases', function (Blueprint $table) {
            $table->dropForeign(['vendor_id']);
            $table->dropForeign(['user_id']);
            $table->dropForeign(['parent_purchase_id']);
        });

        Schema::table('sales_notes', function (Blueprint $table) {
            $table->dropForeign(['sale_id']);
        });

        Schema::table('sales_discounts', function (Blueprint $table) {
            $table->dropForeign(['sale_id']);
            $table->dropForeign(['disc_id']);
        });

        Schema::table('sales_items', function (Blueprint $table) {
            $table->dropForeign(['sale_id']);
            $table->dropForeign(['pr_id']);
        });

        Schema::table('sales', function (Blueprint $table) {
            $table->dropForeign(['store_id']);
            $table->dropForeign(['user_id']);
            $table->dropForeign(['parent_sale_id']);
        });

        Schema::table('sales_payments', function (Blueprint $table) {
            $table->dropForeign(['sale_id']);
            $table->dropForeign(['mop_id']);
        });

        Schema::table('usr_module_checks', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        Schema::table('inv_logs', function (Blueprint $table) {
            $table->dropForeign(['pr_id']);
            $table->dropForeign(['loc_id']);
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['brand_id']);
            $table->dropForeign(['cat_id']);
        });

        Schema::table('pr_prices', function (Blueprint $table) {
            $table->dropForeign(['pr_id']);
        });

        Schema::table('pr_inventories', function (Blueprint $table) {
            $table->dropForeign(['loc_id']);
            $table->dropForeign(['pr_id']);
        });
    }
};
