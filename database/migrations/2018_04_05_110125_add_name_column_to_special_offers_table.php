<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNameColumnToSpecialOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('special_offers', function (Blueprint $table){
            $table->string('name')->nullable();
        });
    }


    public function down()
    {
        Schema::table('special_offers', function (Blueprint $table){
            $table->dropColumn('name');
        });
    }
}
