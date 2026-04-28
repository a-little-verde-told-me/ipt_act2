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
        Schema::table('product_ratings', function (Blueprint $table) {
            $table->index('user_id', 'product_ratings_user_id_index');
            $table->foreignId('order_item_id')->nullable()->constrained('order_items')->onDelete('cascade')->after('product_id');
            $table->dropUnique(['user_id', 'product_id']);
            $table->unique(['order_item_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_ratings', function (Blueprint $table) {
            $table->dropUnique(['order_item_id']);
            $table->dropForeign(['order_item_id']);
            $table->dropColumn('order_item_id');
            $table->dropIndex('product_ratings_user_id_index');
            $table->unique(['user_id', 'product_id']);
        });
    }
};
