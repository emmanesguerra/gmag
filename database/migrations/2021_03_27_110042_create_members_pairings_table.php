<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersPairingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members_pairings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('member_id');
            $table->unsignedBigInteger('lft_mid');
            $table->unsignedBigInteger('rgt_mid');
            $table->unsignedBigInteger('product_id');
            $table->unsignedMediumInteger('product_value');
            $table->string('type', 2)->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            
            $table->index(['deleted_at']);
            $table->foreign('member_id')->references('id')->on('members');
            $table->foreign('lft_mid')->references('id')->on('members');
            $table->foreign('rgt_mid')->references('id')->on('members');
            $table->foreign('product_id')->references('id')->on('products');
            $table->index(['member_id']);
            $table->index(['type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('members_pairings');
    }
}
