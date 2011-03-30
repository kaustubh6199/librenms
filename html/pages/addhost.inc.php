<?php

if ($_SESSION['userlevel'] < 10)
{
  include("includes/error-no-perm.inc.php");
  exit;
}

echo("<h2>Add Device</h2>");

if ($_POST['hostname'] && $_POST['community'])
{
  if ($_SESSION['userlevel'] > '5')
  {
    $hostname = mres($_POST['hostname']);
    $community = mres($_POST['community']);
    $snmpver = mres($_POST['snmpver']);
    if ($_POST['port']) { $port = mres($_POST['port']); } else { $port = "161"; }
    print_message("Adding host $hostname community $community port $port");
    $result = addHost($hostname, $community, $snmpver, $port);
  } else {
    print_error("You don't have the necessary privileges to add hosts.");
  }
} elseif ($_POST['hostname'] && !$_POST['community']) {
  print_error("A community string is required.");
} elseif (!$_POST['hostname'] && $_POST['community']) {
  print_error("A hostname is required.");
}

?>

<form name="form1" method="post" action="">
  <p>Devices will be checked for Ping and SNMP reachability before being probed. Only devices with recognised OSes will be added.</p>

  <div style="padding: 10px; background: #f0f0f0;">
    <table cellpadding=2px>
      <tr>
        <td><strong>Hostname</strong></td>
        <td><input type="text" name="hostname" size="32"></td>
      </tr>
        <td><strong>Community</strong></td>
        <td><input type="text" name="community" size="32"></td>
      </tr>
      <tr>
        <td><strong>SNMP Version</strong></td>
        <td>
          <select name="snmpver">
            <option value="v1">v1</option>
            <option value="v2c" selected>v2c</option>
          </select>
          &nbsp;<strong>Port</strong> <input type="text" name="port" size="16">
        </td>
      </tr>
      <tr>
        <td></td><td><input type="submit" class="submit" name="Submit" value="Add Host"></td>
      </tr>
    </table>
  </div>
</form>
