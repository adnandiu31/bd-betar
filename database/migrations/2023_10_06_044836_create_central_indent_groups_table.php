<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCentralIndentGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('central_indent_groups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('central_indent_id')->constrained('central_indents')->onDelete('cascade');
            $table->foreignId('part_id')->constrained('parts')->onDelete('cascade');
            $table->integer('quantity')->default(0);
            $table->integer('remaining')->default(0);
            $table->integer('unit_price')->default(0);
            $table->json('station_quantity')->nullable();
            $table->json('st_id')->nullable();
            $table->json('st_name')->nullable();
            $table->json('st_quantity')->nullable();
            $table->date('date');
            // $table->foreignId('indent_id')->nullable()->constrained();
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
        Schema::dropIfExists('central_indent_groups');
    }
}
