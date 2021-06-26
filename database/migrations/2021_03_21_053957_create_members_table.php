<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('username', 50);
            $table->string('password');
            $table->string('referral_code', 16)->nullable();
            $table->unsignedBigInteger('sponsor_id');
            $table->string('firstname', 35);
            $table->string('middlename', 35);
            $table->string('lastname', 50);
            $table->string('address1', 50);
            $table->string('address2', 50)->nullable();
            $table->string('address3', 50)->nullable();
            $table->string('city', 20)->nullable();
            $table->string('state', 20)->nullable();
            $table->string('country', 2)->nullable();
            $table->string('zip', 10)->nullable();
            $table->string('email');
            $table->string('mobile', 25);
            $table->date('birthdate')->nullable();
            $table->string('nationality', 50)->nullable();
            $table->string('nature_of_work', 50)->nullable();
            $table->unsignedBigInteger('registration_code_id');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('curr_login_id')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->boolean('must_change_password')->default(0);
            $table->timestamp('password_changed_date')->nullable();
            $table->unsignedSmallInteger('pair_ctr')->nullable();
            $table->date('pair_date')->nullable();
            $table->unsignedSmallInteger('pair_cycle_ctr')->nullable();
            $table->unsignedBigInteger('pair_cycle_id')->nullable();
            $table->float('matching_pairs')->nullable();
            $table->float('matching_pairs_x')->nullable()->comment('amount to be cashout, if not empty means there is a pending transaction in paynamics');
            $table->float('direct_referral')->nullable();
            $table->float('direct_referral_x')->nullable()->comment('amount to be cashout, if not empty means there is a pending transaction in paynamics');
            $table->float('encoding_bonus')->nullable();
            $table->float('encoding_bonus_x')->nullable()->comment('amount to be cashout, if not empty means there is a pending transaction in paynamics');
            $table->float('purchased')->nullable();
            $table->float('total_amt')->nullable()->comment('total_amt = (matching_pairs + direct_referral + encoding_bonus) - purchased');
            $table->unsignedMediumInteger('flush_pts')->nullable();
            $table->boolean('has_credits')->default(0);
            $table->string('timezone', 32)->default('Asia/Manila');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('members');
    }
}
