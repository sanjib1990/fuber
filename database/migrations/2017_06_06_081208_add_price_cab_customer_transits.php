<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class AddPriceCabCustomerTransits
 */
class AddPriceCabCustomerTransits extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cab_customer_transits', function (Blueprint $table) {
            $table->float('price')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cab_customer_transits', function (Blueprint $table) {
            $table->dropColumn('price');
        });
    }
}
