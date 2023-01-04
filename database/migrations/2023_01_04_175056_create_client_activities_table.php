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
        Schema::create('client_activities', function (Blueprint $table) {
            $table->id('client_activity_id');
            $table->unsignedBigInteger('usersuser_id');
            $table->string('resource_accessed');
            $table->string('ip_address');
            $table->string('device_type');
            $table->string('country_code');
            $table->string('city');
            $table->string('region');
            $table->string('country');
            $table->string('lat');
            $table->string('lng');
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
        Schema::dropIfExists('client_activities');
    }
};
