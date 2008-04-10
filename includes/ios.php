<?

function pollDeviceIOS() {

   global $device;
   global $community;
   global $config;
   $id = $device['device_id'];

   $hostname = $device['hostname'];
   $hardware = $device['hardware'];
   $version = $device['version'];
   $features = $device['features'];
   $location = $device['location'];
   $os = $device['location'];

   $temprrd  = "rrd/" . $hostname . "-temp.rrd";
   $cpurrd   = "rrd/" . $hostname . "-cpu.rrd";
   $memrrd   = "rrd/" . $hostname . "-mem.rrd";

   list ($cpu5m, $cpu5s) = explode("\n", `snmpget -O qv -v2c -c $community $hostname 1.3.6.1.4.1.9.2.1.58.0 1.3.6.1.4.1.9.2.1.56.0`);

   $cpu5m = $cpu5m + 0;
   $cpu5s = $cpu5s + 0;
   list ($tempin1, $tempout1) = explode("\n", `snmpget -O qv -v2c -c $community $hostname .1.3.6.1.4.1.9.9.13.1.3.1.3.1 .1.3.6.1.4.1.9.9.13.1.3.1.3.2`);
   $tempin1 = $tempin1 +0;
   $tempout1 = $tempout1 + 0;
   $mem_get  = ".1.3.6.1.4.1.9.9.48.1.1.1.6.2 .1.3.6.1.4.1.9.9.48.1.1.1.6.1 .1.3.6.1.4.1.9.9.48.1.1.1.6.3";
   $mem_get .= ".1.3.6.1.4.1.9.9.48.1.1.1.5.2 .1.3.6.1.4.1.9.9.48.1.1.1.5.1 .1.3.6.1.4.1.9.9.48.1.1.1.5.3";
   $mem_raw  = `snmpget -O qv -v2c -c $community $hostname $mem_get`;
   $mem_raw  = str_replace("No Such Instance currently exists at this OID", "0", $mem_raw); 
   list ($memfreeio, $memfreeproc, $memfreeprocb, $memusedio, $memusedproc, $memusedprocb) = explode("\n", $mem_raw); 
   echo("$hostname\n");
   $memfreeproc = $memfreeproc + $memfreeprocb;
   $memusedproc = $memusedproc + $memusedprocb;
   $memfreeio = $memfreeio + 0;
   $memfreeproc = $memfreeproc + 0;
   $memusedio = $memusedio + 0;
   $memusedproc = $memusedproc + 0;
   $memtotal = $memfreeio + $memfreeproc + $memusedio + $memusedproc;
   if (!is_file($cpurrd)) {
      $rrdcreate = shell_exec($config['rrdtool'] . " create $cpurrd --step 300 \
                    DS:LOAD5S:GAUGE:600:-1:100 \
                    DS:LOAD5M:GAUGE:600:-1:100 \
                    RRA:AVERAGE:0.5:1:2000 \
                    RRA:AVERAGE:0.5:6:2000 \
                    RRA:AVERAGE:0.5:24:2000 \
                    RRA:AVERAGE:0.5:288:2000 \
                    RRA:MAX:0.5:1:2000 \
                    RRA:MAX:0.5:6:2000 \
                    RRA:MAX:0.5:24:2000 \
                    RRA:MAX:0.5:288:2000");
   }
   if (!is_file($temprrd)) {
      $rrdcreate = shell_exec($config['rrdtool'] . " create $temprrd --step 300 \
                    DS:TEMPIN1:GAUGE:600:-25:100 \
                    DS:TEMPOUT1:GAUGE:600:-25:100 \
                    RRA:AVERAGE:0.5:1:2000 \
                    RRA:AVERAGE:0.5:6:2000 \
                    RRA:AVERAGE:0.5:24:2000 \
                    RRA:AVERAGE:0.5:288:2000 \
                    RRA:MAX:0.5:1:2000 \
                    RRA:MAX:0.5:6:2000 \
                    RRA:MAX:0.5:24:2000 \
                    RRA:MAX:0.5:288:2000");
   }
   if (!is_file($memrrd)) {
      $rrdcreate = shell_exec($config['rrdtool'] . " create $memrrd --step 300 \
                    DS:IOFREE:GAUGE:600:0:U \
                    DS:IOUSED:GAUGE:600:-1:U \
                    DS:PROCFREE:GAUGE:600:0:U \
                    DS:PROCUSED:GAUGE:600:-1:U \
                    DS:MEMTOTAL:GAUGE:600:-1:U \
                    RRA:AVERAGE:0.5:1:2000 \
                    RRA:AVERAGE:0.5:6:2000 \
                    RRA:AVERAGE:0.5:24:2000 \
                    RRA:AVERAGE:0.5:288:2000 \
                    RRA:MAX:0.5:1:2000 \
                    RRA:MAX:0.5:6:2000 \
                    RRA:MAX:0.5:24:2000 \
                    RRA:MAX:0.5:288:2000");

   }
   shell_exec($config['rrdtool'] . " update $temprrd N:$tempin1:$tempout1");
   shell_exec($config['rrdtool'] . " update $cpurrd N:$cpu5s:$cpu5m");
   shell_exec($config['rrdtool'] . " update $memrrd N:$memfreeio:$memusedio:$memfreeproc:$memusedproc:$memtotal");
}

?>
