<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersPairCyclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members_pair_cycles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('member_id');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->unsignedBigInteger('product_id');
            $table->unsignedSmallInteger('max_pair');
            $table->timestamps();
            
            $table->foreign('member_id')->references('id')->on('members');
            $table->foreign('product_id')->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('members_pair_cycles');
    }
}
