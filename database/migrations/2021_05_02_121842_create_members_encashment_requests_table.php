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
            $table->string('req_type', 20);
            $table->string('name', 150);
            $table->string('mobile', 50);
            $table->string('tracking_no', 150)->nullable();
            $table->string('remarks', 200)->nullable();
            $table->string('status', 2)->default('WA')->comment('WA - Waiting for Approval, C - Confirmed, X - Cancelled');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            
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
