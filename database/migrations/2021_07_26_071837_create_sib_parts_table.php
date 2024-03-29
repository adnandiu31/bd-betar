<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSibPartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sib_parts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sib_id')->constrained('sibs')->onDelete('cascade');
            $table->foreignId('part_id')->constrained('parts')->onDelete('cascade');
            $table->integer('quantity')->default(0);
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
        Schema::dropIfExists('sib_parts');
    }
}
