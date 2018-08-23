<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateWirelessSensorsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wireless_sensors', function (Blueprint $table) {
            $table->integer('sensor_id', true);
            $table->boolean('sensor_deleted')->default(0);
            $table->string('sensor_class', 64)->index('sensor_class');
            $table->unsignedInteger('device_id')->default(0)->index('sensor_host');
            $table->string('sensor_index', 64)->nullable();
            $table->string('sensor_type')->index('sensor_type');
            $table->string('sensor_descr')->nullable();
            $table->integer('sensor_divisor')->default(1);
            $table->integer('sensor_multiplier')->default(1);
            $table->string('sensor_aggregator', 16)->default('sum');
            $table->double('sensor_current')->nullable();
            $table->double('sensor_prev')->nullable();
            $table->double('sensor_limit')->nullable();
            $table->double('sensor_limit_warn')->nullable();
            $table->double('sensor_limit_low')->nullable();
            $table->double('sensor_limit_low_warn')->nullable();
            $table->boolean('sensor_alert')->default(1);
            $table->enum('sensor_custom', array('No','Yes'))->default('No');
            $table->string('entPhysicalIndex', 16)->nullable();
            $table->string('entPhysicalIndex_measured', 16)->nullable();
            $table->timestamp('lastupdate')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->text('sensor_oids');
            $table->integer('access_point_id')->nullable();
        });
   }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('wireless_sensors');
    }
}
