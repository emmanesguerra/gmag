<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistrationCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registration_codes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('assigned_to_member_id')->nullable();
            $table->string('pincode1', 8)->nullable()->comment('use to be registration code');
            $table->string('pincode2', 8)->nullable()->comment('use to be password code');
            $table->unsignedBigInteger('product_id');
            $table->boolean('is_used')->comment('1 = used, 0 = still available')->default(0);
            $table->unsignedBigInteger('used_by_member_id')->nullable();
            $table->date('date_used')->nullable();
            $table->string('remarks', 500)->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            
            $table->index(['pincode1', 'pincode2']);
            $table->unique(['pincode1', 'pincode2']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('registration_codes');
    }
}
