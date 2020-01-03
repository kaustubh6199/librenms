<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMplsTunnelArHopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mpls_tunnel_ar_hops', function (Blueprint $table) {
            $table->increments('ar_hop_id');
            $table->unsignedInteger('mplsTunnelARHopListIndex');
            $table->unsignedInteger('mplsTunnelARHopIndex');
            $table->unsignedInteger('device_id')->index('device_id');
            $table->unsignedInteger('lsp_path_id');
            $table->enum('mplsTunnelARHopAddrType', array('unknown','ipV4','ipV6','asNumber','lspid','unnum'))->nullable();
            $table->string('mplsTunnelARHopIpv4Addr', 15)->nullable();
            $table->string('mplsTunnelARHopIpv6Addr', 45)->nullable();
            $table->unsignedInteger('mplsTunnelARHopAsNumber')->nullable();
            $table->enum('mplsTunnelARHopStrictOrLoose', array('strict','loose'))->nullable();
            $table->string('mplsTunnelARHopRouterId', 15)->nullable();
            $table->enum('localProtected', array('false','true'))->default('false');
            $table->enum('linkProtectionInUse', array('false','true'))->default('false');
            $table->enum('bandwidthProtected', array('false','true'))->default('false');
            $table->enum('nextNodeProtected', array('false','true'))->default('false');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mpls_tunnel_ar_hops');
    }
}
