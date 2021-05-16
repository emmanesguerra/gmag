<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTransactionNoOnTransactionTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('transaction_no', 15)->after('id');
            
            $table->index(['transaction_no']);
        });
        
        Schema::table('transaction_bonuses', function (Blueprint $table) {
            $table->string('transaction_no', 15)->after('id');
            
            $table->index(['transaction_no']);
        });
        
        Schema::table('transaction_encashments', function (Blueprint $table) {
            $table->string('transaction_no', 15)->after('id');
            
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
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('transaction_no');
        });
        Schema::table('transaction_bonuses', function (Blueprint $table) {
            $table->dropColumn('transaction_no');
        });
        Schema::table('transaction_encashments', function (Blueprint $table) {
            $table->dropColumn('transaction_no');
        });
    }
}
