<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDevicePerfIndex extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('device_perf', function (Blueprint $table) {
            $table->index(['device_id', 'timestamp']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('device_perf', function (Blueprint $table) {
            $table->dropIndex(['device_id', 'timestamp']);
        });
    }
}
