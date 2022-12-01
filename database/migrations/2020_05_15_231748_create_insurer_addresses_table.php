<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInsurerAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insurer_addresses', function (Blueprint $table) {
            $table->id('insurer_address_id');
            $table->unsignedBigInteger('insurersinsurer_id');
            $table->string('suburb', 60);
            $table->string('street', 120);
            $table->string('region', 60);
            $table->string('country', 60);
            $table->enum('delete_status',['DELETED','NOT DELETED'])->default('NOT DELETED');
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
        Schema::dropIfExists('insurer_addresses');
    }
}
