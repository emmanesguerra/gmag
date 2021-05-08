<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsOnTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->float('total_amount')->after('product_price');
            $table->unsignedSmallInteger('quantity')->after('product_price');
        });
        
        Schema::table('registration_codes', function (Blueprint $table) {
            $table->unsignedBigInteger('transaction_id')->nullable()->after('product_id');
            
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
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('quantity');
            $table->dropColumn('total_amount');
        });
        
        Schema::table('registration_codes', function (Blueprint $table) {
            $table->dropForeign(['transaction_id']);
            $table->dropColumn('transaction_id');
        });
    }
}
