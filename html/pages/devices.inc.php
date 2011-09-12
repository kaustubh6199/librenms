<?php

### FIXME - this code might suck cock. is there a better way?

### Turn /devices/os|linux/location|France/ into 
### $_POST[os] = "linux"; $_POST['location'] = "France"

foreach($_GET as $key=>$get_var) {
  if(strstr($key, "opt")) {
    list($name, $value) = explode("|", $get_var);
    $_POST[$name] = $value;
  }
}

### FIXME - build this string in new method

if ($_POST['hostname']) { $where .= " AND hostname LIKE '%".mres($_POST['hostname'])."%'"; }
if ($_POST['os'])       { $where .= " AND os = '".mres($_POST['os'])."'"; }
if ($_POST['version'])  { $where .= " AND version = '".mres($_POST['version'])."'"; }
if ($_POST['hardware']) { $where .= " AND hardware = '".mres($_POST['hardware'])."'"; }
if ($_POST['features']) { $where .= " AND features = '".mres($_POST['features'])."'"; }

if ($_GET['location'] == "Unset") { $location_filter = ''; }
if ($_GET['location'] && !isset($_POST['location']))  { $location_filter = $_GET['location']; }
if ($_POST['location']) { $location_filter = $_POST['location']; }

print_r($_POST);

print_optionbar_start(62);
?>
<form method="post" action="">
  <table cellpadding="4" cellspacing="0" class="devicetable" width="100%">
    <tr>
      <td width="30" align="center" valign="middle"></td>
      <td width="300"><span style="font-weight: bold; font-size: 14px;"></span>
        <input type="text" name="hostname" id="hostname" size="40" value="<?php echo($_POST['hostname']); ?>" />
      </td>
      <td width="200">
        <select name='os' id='os'>
          <option value=''>All OSes</option>
          <?php

foreach(dbFetch('SELECT `os` FROM `devices` AS D WHERE 1 GROUP BY `os` ORDER BY `os`') as $data)
{
  if ($data['os'])
  {
    echo("<option value='".$data['os']."'");
    if ($data['os'] == $_POST['os']) { echo(" selected"); }
    echo(">".$config['os'][$data['os']]['text']."</option>");
  }
}
          ?>
        </select>
        <br />
        <select name='version' id='version'>
          <option value=''>All Versions</option>
          <?php

foreach(dbFetch('SELECT `version` FROM `devices` AS D WHERE 1 GROUP BY `version` ORDER BY `version`') as $data)
{
  if ($data['version'])
  {
    echo("<option value='".$data['version']."'");
    if ($data['version'] == $_POST['version']) { echo(" selected"); }
    echo(">".$data['version']."</option>");
  }
}
          ?>
        </select>
      </td>
      <td width="200">
        <select name="hardware" id="hardware">
          <option value="">All Platforms</option>
          <?php
foreach(dbFetch('SELECT `hardware` FROM `devices` AS D WHERE 1 GROUP BY `hardware` ORDER BY `hardware`') as $data)
{
  if ($data['hardware'])
  {
    echo('<option value="'.$data['hardware'].'"');
    if ($data['hardware'] == $_POST['hardware']) { echo(" selected"); }
    echo(">".$data['hardware']."</option>");
  }
}
          ?>
        </select>
        <br />
        <select name="features" id="features">
          <option value="">All Featuresets</option>
          <?php

foreach(dbFetch('SELECT `features` FROM `devices` AS D WHERE 1 GROUP BY `features` ORDER BY `features`') as $data)
{
  if ($data['features'])
  {
    echo('<option value="'.$data['features'].'"');
    if ($data['features'] == $_POST['features']) { echo(" selected"); }
    echo(">".$data['features']."</option>");
  }
}
          ?>
        </select>
      </td>
      <td>
        <select name="location" id="location">
          <option value="">All Locations</option>
          <?php

foreach (getlocations() as $location) ## FIXME function name sucks maybe get_locations ?
{
  if ($location)
  {
    echo('<option value="'.$location.'"');
    if ($location == $_POST['location']) { echo(" selected"); }
    echo(">".$location."</option>");
  }
}
          ?>
        </select>
        <input class="submit" type="submit" class="submit" value="Search">
      </td>
      <td width="10"></td>
    </tr>
  </table>
</form>

<?php
print_optionbar_end();

$sql = "SELECT * FROM devices WHERE 1 $where ORDER BY `disabled` ASC, `ignore`, `status`, `hostname`";
if ($_GET['status'] == "alerted")
{
  $sql = "SELECT * FROM devices " . $device_alert_sql . " GROUP BY `device_id` ORDER BY `ignore`, `status`, `os`, `hostname`";
}

echo('<table cellpadding="7" cellspacing="0" class="devicetable sortable" width="100%">
<tr class="tablehead"><th></th><th>Device</th><th></th><th>Operating System</th><th>Platform</th><th>Uptime/Location</th></tr>');

foreach(dbFetch($sql) as $device)
{
  if (device_permitted($device['device_id']))
  {
    if (!$location_filter || ((get_dev_attrib($device,'override_sysLocation_bool') && get_dev_attrib($device,'override_sysLocation_string') == $location_filter)
      || $device['location'] == $location_filter))
    {
      include("includes/hostbox.inc.php");
    }
  }
}

echo("</table>");

?>
