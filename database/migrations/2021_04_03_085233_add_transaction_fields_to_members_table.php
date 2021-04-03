<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTransactionFieldsToMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->float('matching_pairs')->nullable();
            $table->float('direct_referral')->nullable();
            $table->float('encoding_bonus')->nullable();
            $table->float('purchased')->nullable();
            $table->float('total_amt')->nullable()->comment('total_amt = (matching_pairs + direct_referral + encoding_bonus) - purchased');
            $table->unsignedMediumInteger('flush_pts')->nullable();
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
            $table->dropColumn('matching_pairs');
            $table->dropColumn('direct_referral');
            $table->dropColumn('encoding_bonus');
            $table->dropColumn('purchased');
            $table->dropColumn('total_amt');
            $table->dropColumn('flush_pts');
        });
    }
}
