<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNotificationsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->integer('notifications_id', true);
            $table->string('title')->default('');
            $table->text('body', 65535);
            $table->integer('severity')->nullable()->default(0)->index()->comment('0=ok,1=warning,2=critical');
            $table->string('source')->default('');
            $table->string('checksum', 128)->unique('checksum');
            $table->timestamp('datetime')->default('1970-01-02 00:00:00');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('notifications');
    }
}
