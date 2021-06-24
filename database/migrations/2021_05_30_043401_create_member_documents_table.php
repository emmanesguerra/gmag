<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('member_id');
            $table->char('type', 1)->comment('1 = primary, 2 secondary1, 3 = secondary2');
            $table->string('doc_type', 7);
            $table->string('doc_id', 100);
            $table->date('expiry_date');
            $table->string('proof', 255);
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['member_id', 'type', 'deleted_at']);
            $table->foreign('member_id')->references('id')->on('members');
            $table->foreign('doc_type')->references('code')->on('document_options');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('member_documents');
    }
}
