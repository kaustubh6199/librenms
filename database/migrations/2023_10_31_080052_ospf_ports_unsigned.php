<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('ospf_ports', function (Blueprint $table) {
            $table->unsignedInteger('ospfIfEvents')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ospf_ports', function (Blueprint $table) {
            $table->integer('ospfIfEvents')->nullable()->change();
        });
    }
};
