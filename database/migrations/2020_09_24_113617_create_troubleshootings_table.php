<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTroubleshootingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('troubleshootings', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('repair_id');
            $table->string('product_name');
            $table->string('fault');
            $table->string('fault_location');
            $table->string('fault_image')->nullable(true);
            $table->string('symptom');
            $table->string('solution');
            $table->string('station_name');
            $table->string('author');
            $table->string('designation');
            $table->string('mobile_number');
            $table->string('email');
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
        Schema::dropIfExists('troubleshootings');
    }
}
