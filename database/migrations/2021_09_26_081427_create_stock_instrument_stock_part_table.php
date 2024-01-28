<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockInstrumentStockPartTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_instrument_stock_part', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('stock_instrument_id');
            $table->unsignedBigInteger('stock_part_id');
            $table->timestamps();
            $table->foreign('stock_instrument_id')
                ->references('id')
                ->on('stock_instruments')
                ->onDelete('cascade');
            $table->foreign('stock_part_id')
                ->references('id')
                ->on('stock_parts')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stock_instrument_stock_part');
    }
}
