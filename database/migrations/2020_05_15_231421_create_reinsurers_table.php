<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReinsurersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reinsurers', function (Blueprint $table) {
            $table->id('reinsurer_id');
            $table->string('re_company_name', 60);
            $table->string('re_company_email', 60);
            $table->string('re_abbrv');
            $table->string('re_company_website', 50);
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
        Schema::dropIfExists('reinsurers');
    }
}
