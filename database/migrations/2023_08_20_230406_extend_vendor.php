<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('vendor_ouis', function (Blueprint $table) {
            $table->string('vendor_short');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('vendor_ouis', function (Blueprint $table) {
            $table->dropColumn(['vendor_short']);
        });
    }
};
