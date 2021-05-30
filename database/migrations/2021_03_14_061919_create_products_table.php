<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique();
            $table->string('code', 50)->unique();
            $table->string('slug', 60)->unique();
            $table->float('price');
            $table->string('display_icon', 15)->nullable();
            $table->unsignedTinyInteger('flush_bonus');
            $table->unsignedMediumInteger('product_value');
            $table->string('type', 5);
            $table->char('registration_code_prefix', 2)->comment('used for registration codes (pincode1)');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
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
        Schema::dropIfExists('products');
    }
}
