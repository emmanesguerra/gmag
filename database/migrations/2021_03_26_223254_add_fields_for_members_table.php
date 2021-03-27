<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsForMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->boolean('must_change_password')->default(0);
            $table->timestamp('password_changed_date')->nullable();
            $table->unsignedSmallInteger('pair_ctr')->nullable();
            $table->date('pair_date')->nullable();
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
            $table->dropColumn('must_change_password');
            $table->dropColumn('password_changed_date');
            $table->dropColumn('pair_ctr');
            $table->dropColumn('pair_date');
        });
    }
}
