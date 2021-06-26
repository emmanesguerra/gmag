<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersEncashmentRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members_encashment_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('member_id');
            $table->string('source', 20);
            $table->float('amount');
            $table->string('disbursement_method', 20);
            $table->string('reference1', 25)->nullable();
            $table->string('reference2', 25)->nullable();
            $table->string('firstname', 35);
            $table->string('middlename', 35);
            $table->string('lastname', 50);
            $table->string('address1', 50);
            $table->string('address2', 50)->nullable();
            $table->string('mobile', 50);
            $table->string('email');
            $table->string('city', 20)->nullable();
            $table->string('state', 20)->nullable();
            $table->string('country', 2)->nullable();
            $table->string('zip', 10)->nullable();
            $table->string('tracking_no', 150)->nullable();
            $table->text('remarks')->nullable();
            $table->string('status', 2)->default('WA')->comment('WA - Waiting for Approval, C - Confirmed by Admin, X - Cancelled, CX - Confirmed with Issue, CC - Transaction Completed, XX - Transaction Failed');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['member_id']);
            $table->foreign('member_id')->references('id')->on('members');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('members_encashment_requests');
    }
}
