<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInsurersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insurers', function (Blueprint $table) {
            $table->id('insurer_id');
            $table->string('insurer_company_name', 60)->unique();
            $table->string('insurer_company_email', 60);
            $table->string('insurer_abbrv');
            $table->string('insurer_company_website', 60);
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
        Schema::dropIfExists('insurers');
    }
}
