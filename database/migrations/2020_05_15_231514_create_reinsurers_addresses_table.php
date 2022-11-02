<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReinsurersAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reinsurers_addresses', function (Blueprint $table) {
            $table->id('reinsurer_address_id');
            $table->unsignedBigInteger('reinsurersreinsurer_id');
            $table->string('street', 120);
            $table->string('suburb', 120)->nullable();
            $table->string('region', 120)->nullable();
            $table->string('country', 120);
            $table->enum('delete_status', ['DELETED','NOT DELETED'])->default('NOT DELETED');
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
        Schema::dropIfExists('reinsurers_addresses');
    }
}
