<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaynamicsEncashmentRespsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paynamics_encashment_resps', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('encashment_id');
            $table->string('request_id', 25);
            $table->string('hed_response_id', 25);
            $table->string('hed_response_code', 25);
            $table->string('hed_response_message', 100);
            $table->string('det_response_id', 25);
            $table->string('det_response_code', 25);
            $table->string('det_response_message', 100);
            $table->string('det_processor_response_id', 60)->nullable();
            $table->timestamps();
            
            $table->index(['encashment_id']);
            $table->foreign('encashment_id')->references('id')->on('members_encashment_requests');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paynamics_encashment_resps');
    }
}
