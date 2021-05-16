<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionSeqsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_seqs', function (Blueprint $table) {
            $table->id();
            $table->char('code', 2);
            $table->date('current_date');
            $table->unsignedSmallInteger('sequence');
            
            $table->index(['code', 'current_date']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction_seqs');
    }
}
