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
        });
        Schema::table('trans_payments', function (Blueprint $table) {
            $table->foreign('trans_id')->references('id')->on('transactions')->onDelete('cascade');
            $table->foreign('mop_id')->references('id')->on('mode_of_payments')->nullOnDelete();
        });
        Schema::table('transactions', function (Blueprint $table) {
            $table->foreign('store_id')->references('id')->on('store_details')->nullOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
        });
        Schema::table('trans_items', function (Blueprint $table) {
            $table->foreign('trans_id')->references('id')->on('transactions')->onDelete('cascade');
            $table->foreign('pr_id')->references('id')->on('products')->nullOnDelete();
        });
        Schema::table('trans_discounts', function (Blueprint $table) {
            $table->foreign('trans_id')->references('id')->on('transactions')->onDelete('cascade');
            $table->foreign('disc_id')->references('id')->on('discounts')->nullOnDelete();
        });
        Schema::table('trans_notes', function (Blueprint $table) {
            $table->foreign('trans_id')->references('id')->on('transactions')->onDelete('cascade');
        });
        Schema::table('usr_module_checks', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::table('usr_module_checks', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        Schema::table('trans_notes', function (Blueprint $table) {
            $table->dropForeign(['trans_id']);
        });

        Schema::table('trans_discounts', function (Blueprint $table) {
            $table->dropForeign(['trans_id']);
            $table->dropForeign(['disc_id']);
        });

        Schema::table('trans_items', function (Blueprint $table) {
            $table->dropForeign(['trans_id']);
            $table->dropForeign(['pr_id']);
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['store_id']);
            $table->dropForeign(['user_id']);
        });

        Schema::table('trans_payments', function (Blueprint $table) {
            $table->dropForeign(['trans_id']);
            $table->dropForeign(['mop_id']);
        });

        Schema::table('inv_logs', function (Blueprint $table) {
            $table->dropForeign(['pr_id']);
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
