<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parts', function (Blueprint $table) {
            $table->id();
            $table->string('part_id');
            $table->string('name')->nullable();
            $table->foreignId('instrument_id')->nullable()->constrained('instruments');
            $table->foreignId('station_id')->constrained('stations')->onDelete('cascade');
            $table->foreignId('part_type_id')->constrained('part_types');
            $table->text('description')->nullable();
            $table->text('specification')->nullable();
            $table->text('designation')->nullable();
            $table->text('parts_no')->nullable();
            $table->date('purchase_date')->nullable();
            $table->string('parts_pos')->nullable();
            $table->foreignId('manufacture_id')->nullable()->constrained('manufactures');
            $table->integer('quantity')->nullable();
            $table->integer('in_use')->nullable();
            $table->integer('present_stock')->nullable();
            $table->string('comments')->nullable();
            $table->string('ledger_information')->nullable();
            $table->string('parts_attached_file')->nullable();
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
        Schema::dropIfExists('parts');
    }
}
