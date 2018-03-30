<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->increments('id');
            $table->string('vat_number', 50)->nullable();
            $table->string('registration_number', 50)->nullable();
            $table->string('registration_address', 255)->nullable();
            $table->string('shipping_address', 255)->nullable();
            $table->string('email', 255);
            $table->string('contact_person', 255);
            $table->string('payment_terms', 255);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clients');
    }
}
