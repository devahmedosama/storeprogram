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
        Schema::create('stock_movement_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('stock_movement_id');
            $table->foreign('stock_movement_id')->references('id')
                        ->on('stock_movements') ->onDelete('cascade');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')
                            ->on('products') ->onDelete('cascade');
            $table->integer('amount')->default(1)->nullable();
            $table->integer('recived_amount')->default(0)->nullable();
            $table->char('no',255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_movement_items');
    }
};
