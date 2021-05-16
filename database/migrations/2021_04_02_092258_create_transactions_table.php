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
        Schema::table('members_placements', function (Blueprint $table) {
            $table->dropColumn('product_claimed');
        });
        
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('member_id');
            $table->unsignedBigInteger('product_id')->nullable();
            $table->string('firstname', 50);
            $table->string('lastname', 50);
            $table->string('email');
            $table->string('product_code', 50)->nullable();
            $table->float('product_price')->nullable();
            $table->date('transaction_date');
            $table->boolean('package_claimed')->default(0);
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            
            $table->index(['member_id']);
            $table->foreign('member_id')->references('id')->on('members');
            $table->foreign('product_id')->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('members_placements', function (Blueprint $table) {
            $table->boolean('product_claimed')->after('product_id')->default(0);
        });
        Schema::dropIfExists('transactions');
    }
}
