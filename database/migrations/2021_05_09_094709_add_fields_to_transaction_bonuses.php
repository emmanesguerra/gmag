<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToTransactionBonuses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transaction_bonuses', function (Blueprint $table) {
            $table->string('field1', 50)->after('class_type');
            $table->string('field2', 50)->after('field1')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transaction_bonuses', function (Blueprint $table) {
            $table->dropColumn('field1');
            $table->dropColumn('field2');
        });
    }
}
