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
        Schema::create('recive_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('recive_id');
            $table->foreign('recive_id')->references('id')
                            ->on('recives') ->onDelete('cascade');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')
                            ->on('products') ->onDelete('cascade');
            $table->integer('amount')->default(0)->nullable();
            $table->integer('recived_amount')->default(0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recive_items');
    }
};
