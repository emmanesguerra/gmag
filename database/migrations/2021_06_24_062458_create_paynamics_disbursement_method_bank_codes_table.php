<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaynamicsDisbursementMethodBankCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paynamics_disbursement_method_bank_codes', function (Blueprint $table) {
            $table->id();
            $table->string('method', 20);
            $table->string('code', 5);
            $table->string('name', 40);
            $table->unsignedTinyInteger('sequence');
            $table->string('legnth', 10);
            $table->boolean('leading_zeroes')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['method']);
            $table->unique(['method', 'code']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paynamics_disbursement_method_bank_codes');
    }
}
