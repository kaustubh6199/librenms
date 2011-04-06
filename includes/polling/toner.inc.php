<?php

if ($config['enable_printers'])
{
  $query = "SELECT * FROM toner WHERE device_id = '" . $device['device_id'] . "'";
  $toner_data = mysql_query($query);

  while ($toner = mysql_fetch_assoc($toner_data))
  {
    echo("Checking toner " . $toner['toner_descr'] . "... ");

    $tonerperc = snmp_get($device, $toner['toner_oid'], "-OUqnv") / $toner['toner_capacity'] * 100;

    $tonerrrd  = $config['rrd_dir'] . "/" . $device['hostname'] . "/" . safename("toner-" . $toner['toner_descr'] . ".rrd");

    if (!is_file($tonerrrd))
    {
      rrdtool_create($tonerrrd,"--step 300 \
      DS:toner:GAUGE:600:0:20000 \
      RRA:AVERAGE:0.5:1:1200 \
      RRA:MIN:0.5:12:2400 \
      RRA:MAX:0.5:12:2400 \
      RRA:AVERAGE:0.5:12:2400");
    }

    echo($tonerperc . " %\n");

    rrdtool_update($tonerrrd,"N:$tonerperc");

    #FIXME could report for toner out... :)

    mysql_query("UPDATE toner SET toner_current = '$tonerperc' WHERE toner_id = '" . $toner['toner_id'] . "'");
  }
}

?>