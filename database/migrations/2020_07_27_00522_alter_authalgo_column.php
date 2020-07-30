<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAuthalgoColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('devices', function (Blueprint $table) {
            $table->string('authalgo', 10)->nullable()->change();
            $table->string('cryptoalgo', 10)->nullable()->change();
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('devices', function (Blueprint $table) {
            $table->string('authalgo', 10)->nullable()->change(); //Rolling back to enum fails.
            $table->string('cryptoalgo', 10)->nullable()->change();
        });
    }
}
