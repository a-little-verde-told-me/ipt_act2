<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('carts') && ! Schema::hasTable('cart_items')) {
            Schema::rename('carts', 'cart_items');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('cart_items') && ! Schema::hasTable('carts')) {
            Schema::rename('cart_items', 'carts');
        }
    }
};
