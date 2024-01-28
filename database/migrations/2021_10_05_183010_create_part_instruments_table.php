<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartInstrumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('part_instruments', function (Blueprint $table) {
            $table->id();
            // $table->unsignedBigInteger('stock_instruments_id');
            // $table->unsignedBigInteger('stock_parts_id');
            // $table->foreign('stock_instruments_id')
            //     ->references('id')
            //     ->on('stock_instruments')
            //     ->onDelete('cascade');
            // $table->foreign('stock_parts_id')
            //     ->references('id')
            //     ->on('stock_parts')
            //     ->onDelete('cascade');
            $table->foreignId('stock_instruments_id')->constrained('stock_instruments')->onDelete('cascade');
            $table->foreignId('stock_parts_id')->constrained('stock_parts')->onDelete('cascade');    
            $table->foreignId('sib_parts_id')->constrained('sib_parts')->onDelete('cascade');    
            $table->string('designation');        
            $table->string('part_no');        
            $table->string('part_pos');        
            $table->string('ledger_info');        
            $table->string('usage_name');        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('part_instruments');
    }
}
