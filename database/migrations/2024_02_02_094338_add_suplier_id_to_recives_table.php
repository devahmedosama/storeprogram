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
        Schema::table('recives', function (Blueprint $table) {
            $table->unsignedBigInteger('suplier_id')->nullable();
            $table->foreign('suplier_id')->references('id')
                            ->on('supliers') ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('recives', function (Blueprint $table) {
            //
        });
    }
};
