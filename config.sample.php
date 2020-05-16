<?php

## Have a look in misc/config_definitions.json for examples of settings you can set here. DO NOT EDIT misc/config_definitions.json!

### Database config
$config['db_host'] = 'localhost';
$config['db_user'] = 'USERNAME';
$config['db_pass'] = 'PASSWORD';
$config['db_name'] = 'librenms';

// This is the user LibreNMS will run as
//Please ensure this user is created and has the correct permissions to your install
$config['user'] = 'librenms';

### This should *only* be set if you want to *force* a particular hostname/port
### It will prevent the web interface being usable form any other hostname
$config['base_url']        = "/";

### Enable this to use rrdcached. Be sure rrd_dir is within the rrdcached dir
### and that your web server has permission to talk to rrdcached.
#$config['rrdcached']    = "unix:/var/run/rrdcached.sock";

### Default community
$config['snmp']['community'] = array('public');

### Authentication Model
$config['auth_mechanism'] = "mysql"; # default, other options: ldap, http-auth
#$config['http_auth_guest'] = "guest"; # remember to configure this user if you use http-auth

### List of RFC1918 networks to allow scanning-based discovery
#$config['nets'][] = "10.0.0.0/8";
#$config['nets'][] = "172.16.0.0/12";
#$config['nets'][] = "192.168.0.0/16";

# Uncomment the next line to disable daily updates
#$config['update'] = 0;

# Number in days of how long to keep old rrd files. 0 disables this feature
$config['rrd_purge'] = 0;

# Uncomment to submit callback stats via proxy
#$config['callback_proxy'] = "hostname:port";

# Set default port association mode for new devices (default: ifIndex)
#$config['default_port_association_mode'] = 'ifIndex';

# Enable the in-built billing extension
$config['enable_billing'] = 1;

# Enable the in-built services support (Nagios plugins)
$config['show_services'] = 1;

# If LIBRENMS_DATA_PATH env var is defined (from our Docker image), load config files from this path
if (is_dir(getenv('LIBRENMS_DATA_PATH'))) {
    foreach (glob( getenv('LIBRENMS_DATA_PATH') . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . '*.php') as $configfile) {
        include $configfile;
    }
}

# Load from config.d folder
if (is_dir(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'config.d')) {
    foreach (glob( dirname(__FILE__) . DIRECTORY_SEPARATOR . 'config.d' . DIRECTORY_SEPARATOR . '*.php') as $configfile) {
        include $configfile;
    }
}
