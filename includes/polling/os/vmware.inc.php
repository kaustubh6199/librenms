<?php

/*
 * Fetch the VMware product version.
 *
 *  VMWARE-SYSTEM-MIB::vmwProdName.0 = STRING: VMware ESXi
 *  VMWARE-SYSTEM-MIB::vmwProdVersion.0 = STRING: 4.1.0
 *  VMWARE-SYSTEM-MIB::vmwProdBuild.0 = STRING: 348481
 *
 *  version:   ESXi 4.1.0
 *  features:  build-348481
 */

$data   = snmp_get_multi($device, "VMWARE-SYSTEM-MIB::vmwProdName.0 VMWARE-SYSTEM-MIB::vmwProdVersion.0 VMWARE-SYSTEM-MIB::vmwProdBuild.0", "-OQUs", "+VMWARE-ROOT-MIB:VMWARE-SYSTEM-MIB", "+" . $config['install_dir'] . "/mibs/vmware");
$version  = preg_replace("/^VMware /", "", $data[0]["vmwProdName"]) . " " . $data[0]["vmwProdVersion"];
$features = "build-" . $data[0]["vmwProdBuild"];

/*
 * VMware ESXi returns "not set" instead of a NULL value.
 */

if ($sysLocation == "not set")
{
  $sysLocation = "";
}

if ($sysContact == "not set")
{
  $sysContact = "";
}

/*
 * CONSOLE: Start the VMware discovery process.
 */

echo("VMware VM: ");

/*
 * Get a list of all the known Virtual Machines for this host.
 */

$db_info_list = mysql_query("SELECT id, vmwVmVMID, vmwVmDisplayName, vmwVmGuestOS, vmwVmMemSize, vmwVmCpus, vmwVmState FROM vmware_vminfo WHERE device_id = '" . $device["device_id"] . "'");

while ($db_info = mysql_fetch_array($db_info_list))
{
  /*
   * Fetch the Virtual Machine information.
   *
   *  VMWARE-VMINFO-MIB::vmwVmDisplayName.224 = STRING: My First VM
   *  VMWARE-VMINFO-MIB::vmwVmGuestOS.224 = STRING: windows7Server64Guest
   *  VMWARE-VMINFO-MIB::vmwVmMemSize.224 = INTEGER: 8192 megabytes
   *  VMWARE-VMINFO-MIB::vmwVmState.224 = STRING: poweredOn
   *  VMWARE-VMINFO-MIB::vmwVmVMID.224 = INTEGER: 224
   *  VMWARE-VMINFO-MIB::vmwVmCpus.224 = INTEGER: 2
   */

  $vm_info = array();

  $vm_info["vmwVmDisplayName"] = snmp_get($device, "VMWARE-VMINFO-MIB::vmwVmDisplayName." . $db_info["vmwVmVMID"], "-Osqnv", "+VMWARE-ROOT-MIB:VMWARE-VMINFO-MIB", "+" . $config["install_dir"] . "/mibs/vmware");
  $vm_info["vmwVmGuestOS"] = snmp_get($device, "VMWARE-VMINFO-MIB::vmwVmGuestOS."   . $db_info["vmwVmVMID"], "-Osqnv", "+VMWARE-ROOT-MIB:VMWARE-VMINFO-MIB", "+" . $config["install_dir"] . "/mibs/vmware");
  $vm_info["vmwVmMemSize"] = snmp_get($device, "VMWARE-VMINFO-MIB::vmwVmMemSize."   . $db_info["vmwVmVMID"], "-Osqnv", "+VMWARE-ROOT-MIB:VMWARE-VMINFO-MIB", "+" . $config["install_dir"] . "/mibs/vmware");
  $vm_info["vmwVmState"] = snmp_get($device, "VMWARE-VMINFO-MIB::vmwVmState."     . $db_info["vmwVmVMID"], "-Osqnv", "+VMWARE-ROOT-MIB:VMWARE-VMINFO-MIB", "+" . $config["install_dir"] . "/mibs/vmware");
  $vm_info["vmwVmCpus"] = snmp_get($device, "VMWARE-VMINFO-MIB::vmwVmCpus."    . $db_info["vmwVmVMID"], "-Osqnv", "+VMWARE-ROOT-MIB:VMWARE-VMINFO-MIB", "+" . $config["install_dir"] . "/mibs/vmware");

  /*
   * VMware does not return an INTEGER but a STRING of the vmwVmMemSize. This bug
   * might be resolved by VMware in the future making this code absolete.
   */

  if (preg_match("/^([0-9]+) .*$/", $vm_info["vmwVmMemSize"], $matches))
  {
    $vm_info["vmwVmMemSize"] = $matches[1];
  }

  /*
   * Proceess all the VMware Virtual Machine properties.
   */

  foreach ($vm_info as $property => $value)
  {
    /*
     * Check the property for any modifications.
     */

    if ($vm_info[$property] != $db_info[$property])
    {
      mysql_query("UPDATE vmware_vminfo SET " . $property ." = '" . mres($vm_info[$property]) ."' WHERE id = '" . $db_info["id"] . "'");
      log_event($db_info["vmwVmDisplayName"] . " (" . preg_replace("/^vmwVm/", "", $property) . ") -> " . $vm_info[$property], $device['device_id']);
    }
  }
}

/*
 * Finished discovering VMware information.
 */

echo("\n");

?>