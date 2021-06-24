<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaynamicsTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paynamics_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_no', 15);
            $table->unsignedBigInteger('member_id');
            $table->unsignedBigInteger('product_id')->nullable();
            $table->unsignedSmallInteger('quantity')->nullable();
            $table->float('total_amount');
            $table->string('transaction_type', 12)->default('Purchased');
            $table->timestamp('transaction_date');
            $table->string('payment_method', 9)->default('paynamics');
            $table->string('payment_source', 20)->nullable();
            $table->string('status', 2)->default('WR')->comment('WR - Waiting for Dgate Response, S - Success, F - Failed');
            $table->text('remarks')->nullable()->comment('Paynamics Remarks');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            
            $table->index(['id', 'transaction_no']);
            $table->index(['member_id']);
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
        Schema::dropIfExists('paynamics_transactions');
    }
}
