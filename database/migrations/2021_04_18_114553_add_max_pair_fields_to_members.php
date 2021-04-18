<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMaxPairFieldsToMembers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->unsignedSmallInteger('pair_cycle_ctr')->after('pair_date')->nullable();
            $table->unsignedBigInteger('pair_cycle_id')->after('pair_cycle_ctr')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn('pair_cycle_ctr');
            $table->dropColumn('pair_cycle_id');
        });
    }
}
