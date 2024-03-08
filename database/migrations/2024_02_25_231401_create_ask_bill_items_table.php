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
        Schema::create('ask_bill_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ask_bill_id');
            $table->foreign('ask_bill_id')->references('id')
                    ->on('ask_bills') ->onDelete('cascade');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')
                    ->on('products') ->onDelete('cascade');
            $table->integer('amount')->default(1)->nullable();
            $table->integer('available_amount')->default(0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ask_bill_items');
    }
};
