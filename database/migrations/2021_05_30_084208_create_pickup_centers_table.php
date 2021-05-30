<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePickupCentersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pickup_centers', function (Blueprint $table) {
            $table->char('code', 3)->primary();
            $table->char('type', 4);
            $table->string('description', 50);
            $table->unsignedTinyInteger('sequence');
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['code']);
            $table->index(['deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pickup_centers');
    }
}
