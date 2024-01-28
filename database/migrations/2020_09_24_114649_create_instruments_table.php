<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstrumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instruments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instrument_type_id')
                ->constrained()
                ->onDelete('cascade');
            $table->string('instrument_id')->nullable();
            $table->string('name')->nullable();
            $table->foreignId('station_id')->constrained()->onDelete('cascade');
            $table->text('description')->nullable();
            $table->string('model')->nullable();
            $table->string('serial_no')->nullable();
            $table->integer('quantity')->nullable();
            $table->foreignId('manufacture_id')->nullable()->constrained();
           $table->date('installation_date')->nullable();
            $table->string('attachment_path')->nullable();
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
        Schema::dropIfExists('instruments');
    }
}
