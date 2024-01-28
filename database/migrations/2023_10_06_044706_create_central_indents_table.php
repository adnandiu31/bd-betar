<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCentralIndentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('central_indents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('manufacture_id')->nullable()->constrained();
            $table->date('date');
            $table->boolean('status')->default(false);
            $table->boolean('final_approval')->default(false);
            $table->foreignId('final_approval_by')->nullable()->constrained('users');
            $table->timestamp('approved_by_se_at')->nullable();
            // $table->timestamp('approved_by_sem_at')->nullable();
            $table->timestamp('approved_by_me_at')->nullable();
            $table->timestamp('approved_by_ce_at')->nullable();
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
        Schema::dropIfExists('central_indents');
    }
}
