<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class AddColumnsCabCustomerTransits
 */
class AddColumnsCabCustomerTransits extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cab_customer_transits', function (Blueprint $table) {
            $table->renameColumn('lat', 'from_lat')->change();
            $table->renameColumn('lng', 'from_lng')->change();
            $table->float('to_lat', 10, 8)->after('customer_id');
            $table->float('to_lng', 10, 8)->after('customer_id');
            $table->timestamp('started_at')->nullable();
            $table->timestamp('ended_at')->nullable();
            $table->string('status')->after('customer_id')->nullable()->length(20);
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
            $table->renameColumn('from_lat', 'lat');
            $table->renameColumn('from_lng', 'lng');
            $table->dropColumn('to_lat');
            $table->dropColumn('to_lng');
            $table->dropColumn('status');
        });
    }
}
