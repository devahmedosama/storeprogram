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
        Schema::create('product_movements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')
                        ->on('products') ->onDelete('cascade');
            $table->unsignedBigInteger('store_id');
            $table->foreign('store_id')->references('id')
                        ->on('stores') ->onDelete('cascade');
            $table->integer('in')->default(1)->nullable();
            $table->integer('out')->default(1)->nullable();
            $table->integer('store_total')->default(1)->nullable();
            $table->integer('total')->default(1)->nullable();
            $table->char('note',255)->nullable();
            $table->char('note_en',255)->nullable();
            $table->char('link',255)->nullable();
            $table->unsignedBigInteger('recive_item_id')->nullable();
            $table->foreign('recive_item_id')->references('id')
                        ->on('recive_items') ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_movements');
    }
};
