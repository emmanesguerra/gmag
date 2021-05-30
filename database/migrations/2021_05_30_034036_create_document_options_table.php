<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_options', function (Blueprint $table) {
            $table->char('code', 7)->primary();
            $table->string('description', 150);
            $table->boolean('is_primary');
            $table->unsignedTinyInteger('sequence');
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['code']);
            $table->index(['deleted_at', 'is_primary']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('document_options');
    }
}
