<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionBonusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_bonuses', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_no', 15);
            $table->unsignedBigInteger('member_id')->comment('the member to recieve the bonus');
            $table->unsignedBigInteger('class_id')->comment('acquired from object id ');
            $table->string('class_type')->comment('acquired from object class ');
            $table->string('field1', 50);
            $table->string('field2', 50)->nullable();
            $table->char('type', 3)->comment('bonus type: MP - Matching Pair, FP - Flushed Pair, EB - Encoding bonus, DR - Dirrect Referral');
            $table->float('acquired_amt');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('member_id')->references('id')->on('members');
            $table->index(['transaction_no']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction_bonuses');
    }
}
