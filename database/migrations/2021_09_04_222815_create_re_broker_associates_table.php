<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReBrokerAssociatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('re_broker_associates', function (Blueprint $table) {
            $table->id('re_broker_associate_id');
            $table->bigInteger('re_brokersre_broker_id');
            $table->string('re_broker_assoc_first_name');
            $table->string('re_broker_assoc_last_name');
            $table->string('re_broker_assoc_primary_phone')->nullable();
            $table->string('re_broker_assoc_secondary_phone')->nullable();
            $table->string('re_broker_assoc_position');
            $table->string('re_broker_assoc_email');
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
        Schema::dropIfExists('re_broker_associates');
    }
}
