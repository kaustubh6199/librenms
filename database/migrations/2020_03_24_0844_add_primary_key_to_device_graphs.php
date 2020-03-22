<?php

/*
    This migration adds primary key for device_graphs

    Percona Xtradb refused to INSERT IGNORE into a table
    without a primary key.
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddPrimaryKeyToDeviceGraphs extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('device_graphs', function (Blueprint $table) {
            $table->bigIncrements('device_graphs_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('device_graphs', function (Blueprint $table) {
            $table->dropColumn('device_graphs_id');
        });
    }
}
