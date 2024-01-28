<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSrbsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('srbs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('station_id')->constrained('stations')->onDelete('cascade');
            $table->foreignId('indent_id')->constrained('indents')->onDelete('cascade');
            $table->string('attempts')->default(null);
            $table->boolean('status')->default(false);
            $table->boolean('adjust')->default(false);
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
        Schema::dropIfExists('srbs');
    }
}
