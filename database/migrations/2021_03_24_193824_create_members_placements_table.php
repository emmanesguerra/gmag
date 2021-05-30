<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersPlacementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members_placements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('member_id');
            $table->unsignedBigInteger('placement_id');
            $table->unsignedBigInteger('lft');
            $table->unsignedBigInteger('rgt');
            $table->unsignedBigInteger('lvl');
            $table->char('position', 1);
            $table->unsignedBigInteger('product_id');
            $table->timestamps();
            
            $table->foreign('member_id')->references('id')->on('members');
            $table->foreign('product_id')->references('id')->on('products');
            $table->index(['lft', 'position']);
            $table->index(['rgt', 'position']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('members_placements');
    }
}
