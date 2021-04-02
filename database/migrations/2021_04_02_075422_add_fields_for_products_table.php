<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsForProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('upv');
            $table->dropColumn('pv');
            $table->string('display_icon', 15)->after('price')->nullable();
            $table->unsignedTinyInteger('flush_bonus')->after('price');
            $table->unsignedMediumInteger('product_value')->after('price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->float('upv')->after('slug');
            $table->float('pv')->after('slug');
            $table->dropColumn('product_value');
            $table->dropColumn('flush_bonus');
            $table->dropColumn('display_icon');
        });
    }
}
