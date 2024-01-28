<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIndentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('indents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('station_id')->constrained('stations')->onDelete('cascade');
            $table->foreignId('manufacture_id')->constrained('manufactures');
            $table->enum('product_type',['instrument','part']);
            $table->date('date');
            $table->string('economic_code');
            $table->string('name')->nullable();
            $table->enum('form',['A','B','C']);
            $table->text('note')->nullable();
            $table->boolean('status')->default(false);
            $table->timestamp('approved_for_cen_ind')->nullable();
            $table->timestamp('approved_by_si_at')->nullable();
            $table->timestamp('approved_by_sh_at')->nullable();
            $table->timestamp('approved_by_ce_at')->nullable();
            $table->timestamp('approved_by_me_at')->nullable();
            $table->timestamp('approved_by_dg_at')->nullable();
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
        Schema::dropIfExists('indents');
    }
}
