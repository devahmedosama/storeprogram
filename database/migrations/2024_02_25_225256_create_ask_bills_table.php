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
        Schema::create('ask_bills', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')
                    ->on('users') ->onDelete('cascade');
            $table->unsignedBigInteger('sales_man_id')->nullable();
            $table->foreign('sales_man_id')->references('id')
                        ->on('sales_men') ->onDelete('cascade');
            $table->unsignedBigInteger('store_id');
            $table->foreign('store_id')->references('id')
                    ->on('stores') ->onDelete('cascade');
            $table->text('signature')->nullable();
            $table->text('store_signature')->nullable();
            $table->integer('state')->default(0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ask_bills');
    }
};
