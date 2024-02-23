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
        Schema::create('shop_movement_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shop_movement_id');
            $table->foreign('shop_movement_id')->references('id')
                        ->on('shop_movements') ->onDelete('cascade');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')
                            ->on('products') ->onDelete('cascade');
            $table->integer('amount')->default(1)->nullable();
            $table->integer('recived_amount')->default(0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shop_movement_items');
    }
};
