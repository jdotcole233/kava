<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reinsurance_brokers', function (Blueprint $table) {
            $table->id('re_broker_id');
            $table->string('re_broker_email', 100);
            $table->string('re_broker_abbrv', 200)->nullable();
            $table->string('re_broker_website', 100)->nullable();
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
        Schema::dropIfExists('reinsurance_brokers');
    }
};
