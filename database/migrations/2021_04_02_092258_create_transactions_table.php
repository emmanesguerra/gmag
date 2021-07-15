<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {        
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_no', 15);
            $table->unsignedBigInteger('member_id');
            $table->unsignedBigInteger('product_id')->nullable();
            $table->string('firstname', 50);
            $table->string('lastname', 50);
            $table->string('email');
            $table->string('product_code', 50)->nullable();
            $table->float('product_price')->nullable();
            $table->unsignedSmallInteger('quantity')->nullable();
            $table->float('total_amount');
            $table->string('transaction_type', 12)->comment('Purchase, Credit Adj, Activation');
            $table->timestamp('transaction_date');
            $table->string('payment_method', 9)->comment('site_reg = website registration; e_wallet = Ewallet; paynamics = Paynamics');
            $table->string('payment_source', 20)->nullable();
            $table->boolean('package_claimed')->default(0);
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['member_id']);
            $table->index(['transaction_no']);
            $table->foreign('member_id')->references('id')->on('members');
            $table->foreign('product_id')->references('id')->on('products');
        });
        
        
        Schema::table('registration_codes', function (Blueprint $table) {
            $table->foreign('transaction_id')->references('id')->on('transactions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('registration_codes', function (Blueprint $table) {
            $table->dropForeign(['transaction_id']);
        });
        
        Schema::dropIfExists('transactions');
    }
}
