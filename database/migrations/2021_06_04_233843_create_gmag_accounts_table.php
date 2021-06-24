<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGmagAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gmag_accounts', function (Blueprint $table) {
            $table->id();
            $table->boolean('should_use')->default(0);
            $table->string('firstname', 35);
            $table->string('middlename', 35);
            $table->string('lastname', 50);
            $table->string('address1', 50);
            $table->string('address2', 50)->nullable();
            $table->string('address3', 50)->nullable();
            $table->string('city', 20);
            $table->string('state', 20)->nullable();
            $table->string('country', 2);
            $table->string('zip', 10)->nullable();
            $table->string('email');
            $table->string('mobile', 25);
            $table->date('birthdate');
            $table->string('birthplace', 50);
            $table->string('nationality', 50);
            $table->string('nature_of_work', 50);
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['should_use']);
        });
        
        Schema::create('gmag_account_documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('account_id');
            $table->char('type', 1)->comment('1 = primary, 2 secondary1, 3 = secondary2');
            $table->string('doc_type', 7);
            $table->string('doc_id', 100);
            $table->date('expiry_date');
            $table->string('proof', 255);
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['deleted_at']);
            $table->index(['account_id', 'type', 'deleted_at']);
            $table->foreign('account_id')->references('id')->on('gmag_accounts');
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
        Schema::dropIfExists('gmag_account_documents');
        Schema::dropIfExists('gmag_accounts');
    }
}
