<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateCabCustomerTransitsTable
 */
class CreateCabCustomerTransitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cab_customer_transits', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cab_id')->unsigned();
            $table->integer('customer_id')->unsigned();
            $table->float('lat', 10, 8);
            $table->float('lng', 10, 8);
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
        Schema::dropIfExists('cab_customer_transits');
    }
}
