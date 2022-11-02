<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReBrokerAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('re_broker_addresses', function (Blueprint $table) {
            $table->id('re_broker_address_id');
            $table->bigInteger('re_brokersre_broker_id');
            $table->string('street');
            $table->string('city');
            $table->string('region');
            $table->string('country');
            $table->string('re_primary_phone');
            $table->string('re_secondary_phone')->nullable();
            $table->enum('delete_status', ['DELETED', 'NOT DELETED'])->default('NOT DELETED');
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
        Schema::dropIfExists('re_broker_addresses');
    }
}
