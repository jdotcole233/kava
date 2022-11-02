<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInsurerAssociatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insurer_associates', function (Blueprint $table) {
            $table->id('insurer_associate_id');
            $table->unsignedBigInteger('insurersinsurer_id');
            $table->string('assoc_first_name', 60);
            $table->string('assoc_last_name', 60);
            $table->string('assoc_primary_phonenumber', 50)->nullable();
            $table->string('assoc_secondary_phonenumber', 50)->nullable();
            $table->string('assoc_email',60);
            $table->string('position', 60);
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
        Schema::dropIfExists('insurer_associates');
    }
}
