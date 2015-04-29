<?php

if (!$os)
{
  if (preg_match("/^Linux/", $sysDescr)) { $os = "linux"; }

  // Specific Linux-derivatives

  if ($os == "linux")
  {
    // Check for QNAP Systems TurboNAS
    $entPhysicalMfgName = snmp_get($device, "ENTITY-MIB::entPhysicalMfgName.1", "-Osqnv");

    if (strstr($sysObjectId, ".1.3.6.1.4.1.5528.100.20.10.2014")) { $os = "netbotz"; }
    elseif (strstr($sysDescr, "endian")) { $os = "endian"; }
    elseif (preg_match("/Cisco Small Business/", $sysDescr)) { $os = "ciscosmblinux"; }
    elseif (strpos($entPhysicalMfgName, "QNAP") !== FALSE) { $os = "qnap"; }
    elseif (stristr($sysObjectId, "packetlogic") || strstr($sysObjectId, ".1.3.6.1.4.1.15397.2")) { $os = "procera"; }
    elseif (strstr($sysObjectId, ".1.3.6.1.4.1.10002.1") || strstr($sysObjectId, ".1.3.6.1.4.1.41112.1.4") || strpos(trim(snmp_get($device, "dot11manufacturerName.5", "-Osqnv", "IEEE802dot11-MIB")), "Ubiquiti") !== FALSE)
    {
      $os = "airos";
      if (strpos(trim(snmp_get($device, "dot11manufacturerProductName.5", "-Osqnv", "IEEE802dot11-MIB")), "UAP") !== FALSE) { $os = "unifi"; }
      elseif (strpos(trim(snmp_get($device, "dot11manufacturerProductName.2", "-Osqnv", "IEEE802dot11-MIB")), "UAP") !== FALSE) { $os = "unifi"; }
      elseif (strpos(trim(snmp_get($device, "dot11manufacturerProductName.3", "-Osqnv", "IEEE802dot11-MIB")), "UAP") !== FALSE) { $os = "unifi"; }
      elseif (strpos(trim(snmp_get($device, "dot11manufacturerProductName.4", "-Osqnv", "IEEE802dot11-MIB")), "UAP") !== FALSE) { $os = "unifi"; }
      elseif (strpos(trim(snmp_get($device, "dot11manufacturerProductName.6", "-Osqnv", "IEEE802dot11-MIB")), "UAP") !== FALSE) { $os = "unifi"; }
      elseif (trim(snmp_get($device, "fwVersion.1", "-Osqnv", "UBNT-AirFIBER-MIB")) != '') { $os = "airos-af"; }
    }
    else
    {
      // Check for Synology DSM
      $hrSystemInitialLoadParameters = trim(snmp_get($device, "hrSystemInitialLoadParameters.0", "-Osqnv"));

      if (strpos($hrSystemInitialLoadParameters, "syno_hw_version") !== FALSE) { $os = "dsm"; }
      else
      {
        // Check for Carel PCOweb
        $roomTemp = trim(snmp_get($device,"roomTemp.0", "-OqvU", "CAREL-ug40cdz-MIB"));

        if (is_numeric($roomTemp))
        {
          $os = "pcoweb";
        }
      }
    }
  }
}

?>
