<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersDisbursementDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members_disbursement_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('member_id');
            $table->string('disbursement_method', 20);
            $table->float('disbursement_amount');
            $table->string('sender_fname', 35);
            $table->string('sender_lname', 50);
            $table->string('sender_mname', 35)->nullable();
            $table->string('sender_address1', 50);
            $table->string('sender_address2', 50)->nullable();
            $table->string('sender_city', 20);
            $table->string('sender_state', 20)->nullable();
            $table->string('sender_country', 2);
            $table->unsignedTinyInteger('sender_zip')->nullable();
            $table->string('sender_email', 254);
            $table->string('sender_phone', 25);
            $table->date('dob');
            $table->string('birthplace', 50);
            $table->string('sender_nature_of_work', 50);
            $table->string('sender_nationality', 50);
            $table->string('primary_kyc_doc', 50)->nullable();
            $table->string('primary_kyc_proof', 255)->nullable();
            $table->string('primary_kyc_id', 100)->nullable();
            $table->date('primary_kyc_expiry')->nullable();
            $table->string('secondary_kyc_doc1', 50)->nullable();
            $table->string('secondary_kyc_proof1', 255)->nullable();
            $table->string('secondary_kyc_id1', 100)->nullable();
            $table->date('secondary_kyc_expiry1')->nullable();
            $table->string('secondary_kyc_doc2', 50)->nullable();
            $table->string('secondary_kyc_proof2', 255)->nullable();
            $table->string('secondary_kyc_id2', 100)->nullable();
            $table->date('secondary_kyc_expiry2')->nullable();
            $table->string('ben_fname', 35);
            $table->string('ben_lname', 50);
            $table->string('ben_mname', 35)->nullable();
            $table->string('ben_address1', 50);
            $table->string('ben_address2', 50)->nullable();
            $table->string('ben_city', 20)->nullable();
            $table->string('ben_state', 20)->nullable();
            $table->string('ben_country', 2);
            $table->unsignedTinyInteger('ben_zip')->nullable();
            $table->string('ben_email', 254);
            $table->string('ben_phone', 25);
            $table->string('currency', 3);
            $table->string('fund_source', 30);
            $table->string('reason_for_transfer', 255);
            $table->unsignedTinyInteger('gcash_account_no')->nullable();
            $table->string('wallet_id', 30)->nullable();
            $table->string('wallet_account_no', 150)->nullable();
            $table->string('destination_bid', 25)->nullable();
            $table->string('ibrt_bank_code', 5)->nullable();
            $table->string('ubp_bank_code', 5)->nullable();
            $table->string('ibbt_bank_code', 5)->nullable();
            $table->string('instapay_bank_code', 5)->nullable();
            $table->string('bank_account_no', 16)->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['member_id']);
            $table->index(['member_id', 'disbursement_method']);
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
        Schema::dropIfExists('members_disbursement_details');
    }
}
