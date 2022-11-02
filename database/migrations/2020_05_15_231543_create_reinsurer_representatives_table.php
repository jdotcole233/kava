<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReinsurerRepresentativesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reinsurer_representatives', function (Blueprint $table) {
            $table->id('reinsurer_representative_id');
            $table->unsignedBigInteger('reinsurersreinsurer_id');
            $table->string('rep_first_name', 60);
            $table->string('rep_last_name', 60);
            $table->string('rep_primary_phonenumber', 50)->nullable();
            $table->string('rep_secondary_phonenumber', 50)->nullable();
            $table->string('rep_email', 60);
            $table->string('position', 100);
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
        Schema::dropIfExists('reinsurer_representatives');
    }
}
