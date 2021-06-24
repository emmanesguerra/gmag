<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaynamicsPayinMethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paynamics_payin_methods', function (Blueprint $table) {
            $table->string('method', 11)->primary();
            $table->string('type', 20);
            $table->string('type_name', 20);
            $table->string('description', 100);
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['method']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paynamics_payin_methods');
    }
}
