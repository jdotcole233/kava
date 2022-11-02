<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReBrokersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('re_borkers', function (Blueprint $table) {
            $table->id('re_broker_id');
            $table->string('re_broker_email', 100);
            $table->string('re_broker_abbrv', 200)->nullable();
            $table->string('re_broker_email', 100);
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
        Schema::dropIfExists('re_borkers');
    }
}
