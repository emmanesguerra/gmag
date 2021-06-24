<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionEncashmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_encashments', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_no', 15);
            $table->unsignedBigInteger('encashment_req_id');
            $table->string('account_name');
            $table->string('account_number');
            $table->string('transaction_number');
            $table->float('previous_amount');
            $table->float('amount_deducted');
            $table->float('new_amount');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['transaction_no']);
            $table->index(['encashment_req_id']);
            $table->foreign('encashment_req_id')->references('id')->on('members_encashment_requests');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction_encashments');
    }
}
