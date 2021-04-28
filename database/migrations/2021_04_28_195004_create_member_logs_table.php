<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_logs', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->dateTime('log_in');
            $table->dateTime('log_out')->nullable();
            $table->string('ip_address', 45)->nullable();
        });
        
        Schema::table('members', function (Blueprint $table) {
            $table->string('ip_address', 45)->after('updated_at')->nullable();
            $table->unsignedBigInteger('curr_login_id')->after('updated_at')->nullable();
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
            $table->dropColumn('curr_login_id');
            $table->dropColumn('ip_address');
        });
        
        Schema::dropIfExists('member_logs');
    }
}
