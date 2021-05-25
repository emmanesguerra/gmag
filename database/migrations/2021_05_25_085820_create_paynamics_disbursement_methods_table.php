<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaynamicsDisbursementMethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paynamics_disbursement_methods', function (Blueprint $table) {
            $table->string('method', 20)->primary();
            $table->string('name', 100);
            $table->unsignedTinyInteger('sequence');
            $table->unsignedMediumInteger('transaction_limit');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paynamics_disbursement_methods');
    }
}
