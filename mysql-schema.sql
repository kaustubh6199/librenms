-- phpMyAdmin SQL Dump
-- version 2.11.3deb1ubuntu1.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 12, 2008 at 12:53 PM
-- Server version: 5.0.51
-- PHP Version: 5.2.4-2ubuntu5.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `observer-demo`
--

-- --------------------------------------------------------

--
-- Table structure for table `adjacencies`
--

CREATE TABLE IF NOT EXISTS `adjacencies` (
  `adj_id` int(11) NOT NULL auto_increment,
  `network_id` int(11) NOT NULL default '0',
  `interface_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`adj_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `alerts`
--

CREATE TABLE IF NOT EXISTS `alerts` (
  `id` int(11) NOT NULL auto_increment,
  `importance` int(11) NOT NULL default '0',
  `device_id` int(11) NOT NULL default '0',
  `message` text NOT NULL,
  `time_logged` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `alerted` smallint(6) NOT NULL default '0',
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bgpPeers`
--

CREATE TABLE IF NOT EXISTS `bgpPeers` (
  `bgpPeer_id` int(11) NOT NULL auto_increment,
  `device_id` int(11) NOT NULL,
  `bgpPeerIdentifier` text NOT NULL,
  `bgpPeerRemoteAs` int(11) NOT NULL,
  `bgpPeerState` text NOT NULL,
  `bgpPeerAdminStatus` text NOT NULL,
  `bgpPeerLocalAddr` text NOT NULL,
  `bgpPeerRemoteAddr` text NOT NULL,
  `bgpPeerInUpdates` int(11) NOT NULL,
  `bgpPeerOutUpdates` int(11) NOT NULL,
  `bgpPeerInTotalMessages` int(11) NOT NULL,
  `bgpPeerOutTotalMessages` int(11) NOT NULL,
  `bgpPeerFsmEstablishedTime` int(11) NOT NULL,
  `bgpPeerInUpdateElapsedTime` int(11) NOT NULL,
  `astext` varchar(32) NOT NULL,
  PRIMARY KEY  (`bgpPeer_id`),
  KEY `device_id` (`device_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bills`
--

CREATE TABLE IF NOT EXISTS `bills` (
  `bill_id` int(11) NOT NULL auto_increment,
  `bill_name` text NOT NULL,
  `bill_type` text NOT NULL,
  `bill_cdr` int(11) default NULL,
  `bill_day` int(11) NOT NULL default '1',
  `bill_gb` int(11) default NULL,
  UNIQUE KEY `bill_id` (`bill_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bill_data`
--

CREATE TABLE IF NOT EXISTS `bill_data` (
  `bill_id` int(11) NOT NULL,
  `timestamp` datetime NOT NULL,
  `period` int(11) NOT NULL,
  `delta` bigint(11) NOT NULL,
  `in_delta` bigint(11) NOT NULL,
  `out_delta` bigint(11) NOT NULL,
  KEY `bill_id` (`bill_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bill_perms`
--

CREATE TABLE IF NOT EXISTS `bill_perms` (
  `user_id` int(11) NOT NULL,
  `bill_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bill_ports`
--

CREATE TABLE IF NOT EXISTS `bill_ports` (
  `bill_id` int(11) NOT NULL,
  `port_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE IF NOT EXISTS `customers` (
  `username` char(64) NOT NULL default '',
  `password` char(32) NOT NULL default '',
  `string` char(64) NOT NULL default '',
  `level` tinyint(4) NOT NULL default '0',
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `devices`
--

CREATE TABLE IF NOT EXISTS `devices` (
  `device_id` int(11) NOT NULL auto_increment,
  `hostname` text character set utf8 collate utf8_unicode_ci NOT NULL,
  `community` text character set utf8 collate utf8_unicode_ci,
  `snmpver` char(3) NOT NULL default 'v2c',
  `bgpLocalAs` varchar(8) default NULL,
  `monowall` tinyint(4) NOT NULL default '0',
  `version` text NOT NULL,
  `hardware` text NOT NULL,
  `features` text NOT NULL,
  `sysDescr` text,
  `sysContact` varchar(64) NOT NULL,
  `location` text,
  `os` text character set utf8 collate utf8_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL default '0',
  `ignore` tinyint(4) NOT NULL default '0',
  `lastchange` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `purpose` text NOT NULL,
  `type` varchar(16) character set utf8 collate utf8_unicode_ci NOT NULL default 'Unknown',
  PRIMARY KEY  (`device_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `devices_attribs`
--

CREATE TABLE IF NOT EXISTS `devices_attribs` (
  `attrib_id` int(11) NOT NULL auto_increment,
  `device_id` int(11) NOT NULL default '0',
  `attrib_type` varchar(32) NOT NULL default '',
  `attrib_value` int(16) NOT NULL,
  `updated` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`attrib_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `devices_perms`
--

CREATE TABLE IF NOT EXISTS `devices_perms` (
  `user_id` int(11) NOT NULL,
  `device_id` int(11) NOT NULL,
  `access_level` int(4) NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `entPhysical`
--

CREATE TABLE IF NOT EXISTS `entPhysical` (
  `entPhysical_id` int(11) NOT NULL auto_increment,
  `device_id` int(11) NOT NULL,
  `entPhysicalIndex` int(11) NOT NULL,
  `entPhysicalDescr` text NOT NULL,
  `entPhysicalClass` text NOT NULL,
  `entPhysicalName` text NOT NULL,
  `entPhysicalModelName` text NOT NULL,
  `entPhysicalVendorType` text,
  `entPhysicalSerialNum` text NOT NULL,
  `entPhysicalContainedIn` int(11) NOT NULL,
  `entPhysicalParentRelPos` int(11) NOT NULL,
  `entPhysicalMfgName` text NOT NULL,
  `ifIndex` int(11) default NULL,
  PRIMARY KEY  (`entPhysical_id`),
  KEY `device_id` (`device_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `eventlog`
--

CREATE TABLE IF NOT EXISTS `eventlog` (
  `id` int(11) NOT NULL default '0',
  `host` int(11) NOT NULL default '0',
  `interface` int(11) default NULL,
  `datetime` datetime NOT NULL default '0000-00-00 00:00:00',
  `message` text NOT NULL,
  `type` int(11) NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `interfaces`
--

CREATE TABLE IF NOT EXISTS `interfaces` (
  `interface_id` int(11) NOT NULL auto_increment,
  `device_id` int(11) NOT NULL default '0',
  `ifDescr` varchar(64) NOT NULL default '',
  `ifIndex` int(11) NOT NULL default '0',
  `ifSpeed` text,
  `ifOperStatus` varchar(12) NOT NULL default '',
  `ifAdminStatus` varchar(12) default NULL,
  `ifDuplex` varchar(12) default NULL,
  `ifMtu` int(11) default NULL,
  `ifType` text,
  `ifAlias` text,
  `ifPhysAddress` text,
  `ifHardType` varchar(64) default NULL,
  `ifLastChange` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `ignore` tinyint(1) NOT NULL default '0',
  `ifVlan` int(11) NOT NULL,
  `ifTrunk` varchar(8) NOT NULL,
  `in_rate` int(11) NOT NULL,
  `out_rate` int(11) NOT NULL,
  `counter_in` int(11) NOT NULL,
  `counter_out` int(11) NOT NULL,
  `in_errors` int(11) NOT NULL,
  `out_errors` int(11) NOT NULL,
  `detailed` tinyint(1) NOT NULL default '0',
  `deleted` tinyint(1) NOT NULL,
  PRIMARY KEY  (`interface_id`),
  KEY `host` (`device_id`),
  KEY `snmpid` (`ifIndex`),
  KEY `if_2` (`ifDescr`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `interfaces_perms`
--

CREATE TABLE IF NOT EXISTS `interfaces_perms` (
  `user_id` int(11) NOT NULL,
  `interface_id` int(11) NOT NULL,
  `access_level` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ip6addr`
--

CREATE TABLE IF NOT EXISTS `ip6addr` (
  `id` int(11) NOT NULL auto_increment,
  `addr` varchar(128) NOT NULL,
  `comp_addr` text NOT NULL,
  `cidr` smallint(6) NOT NULL default '0',
  `origin` text NOT NULL,
  `network` varchar(64) NOT NULL default '',
  `interface_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `addr` (`addr`,`cidr`,`interface_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ip6adjacencies`
--

CREATE TABLE IF NOT EXISTS `ip6adjacencies` (
  `adj_id` int(11) NOT NULL auto_increment,
  `network_id` int(11) NOT NULL default '0',
  `interface_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`adj_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ip6networks`
--

CREATE TABLE IF NOT EXISTS `ip6networks` (
  `id` int(11) NOT NULL auto_increment,
  `cidr` varchar(32) NOT NULL default '',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `cidr` (`cidr`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ipaddr`
--

CREATE TABLE IF NOT EXISTS `ipaddr` (
  `id` int(11) NOT NULL auto_increment,
  `addr` varchar(32) NOT NULL default '',
  `cidr` smallint(6) NOT NULL default '0',
  `network` varchar(64) NOT NULL default '',
  `interface_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `addr` (`addr`,`cidr`,`interface_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `links`
--

CREATE TABLE IF NOT EXISTS `links` (
  `id` int(11) NOT NULL auto_increment,
  `src_if` int(11) default NULL,
  `dst_if` int(11) default NULL,
  `active` tinyint(4) NOT NULL default '1',
  `cdp` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `networks`
--

CREATE TABLE IF NOT EXISTS `networks` (
  `id` int(11) NOT NULL auto_increment,
  `cidr` varchar(32) NOT NULL default '',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `cidr` (`cidr`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `port_in_measurements`
--

CREATE TABLE IF NOT EXISTS `port_in_measurements` (
  `port_id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `counter` bigint(11) NOT NULL,
  `delta` bigint(11) NOT NULL,
  KEY `port_id` (`port_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `port_out_measurements`
--

CREATE TABLE IF NOT EXISTS `port_out_measurements` (
  `port_id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `counter` bigint(11) NOT NULL,
  `delta` bigint(11) NOT NULL,
  KEY `port_id` (`port_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE IF NOT EXISTS `services` (
  `service_id` int(11) NOT NULL auto_increment,
  `service_host` int(11) NOT NULL default '0',
  `service_ip` text,
  `service_type` text NOT NULL,
  `service_desc` text NOT NULL,
  `service_param` text NOT NULL,
  `service_status` tinyint(4) NOT NULL default '2',
  `service_message` text NOT NULL,
  `service_changed` int(11) NOT NULL default '0',
  `service_checked` int(11) NOT NULL default '0',
  `service_ignore` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`service_id`),
  KEY `service_host` (`service_host`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `storage`
--

CREATE TABLE IF NOT EXISTS `storage` (
  `storage_id` int(11) NOT NULL auto_increment,
  `host_id` int(11) NOT NULL default '0',
  `hrStorageIndex` int(11) NOT NULL default '0',
  `hrStorageDescr` text NOT NULL,
  `hrStorageSize` int(11) NOT NULL default '0',
  `hrStorageAllocationUnits` int(11) NOT NULL default '0',
  `hrStorageUsed` int(11) NOT NULL,
  `storage_perc` text NOT NULL,
  PRIMARY KEY  (`storage_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `syslog`
--

CREATE TABLE IF NOT EXISTS `syslog` (
  `host` int(11) default NULL,
  `facility` varchar(10) default NULL,
  `priority` varchar(10) default NULL,
  `level` varchar(10) default NULL,
  `tag` varchar(10) default NULL,
  `datetime` datetime default NULL,
  `program` varchar(32) default NULL,
  `msg` text,
  `seq` bigint(20) unsigned NOT NULL auto_increment,
  `processed` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`seq`),
  KEY `host` (`host`),
  KEY `datetime` (`datetime`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `temperature`
--

CREATE TABLE IF NOT EXISTS `temperature` (
  `temp_id` int(11) NOT NULL auto_increment,
  `temp_host` int(11) NOT NULL default '0',
  `temp_oid` varchar(64) NOT NULL,
  `temp_descr` varchar(32) NOT NULL default '',
  `temp_tenths` tinyint(1) NOT NULL default '0',
  `temp_current` tinyint(4) NOT NULL default '0',
  `temp_limit` tinyint(4) NOT NULL default '70',
  PRIMARY KEY  (`temp_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL auto_increment,
  `username` char(30) NOT NULL,
  `password` char(32) NOT NULL default '',
  `descr` char(30) NOT NULL default '',
  `level` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`user_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `vlans`
--

CREATE TABLE IF NOT EXISTS `vlans` (
  `vlan_id` int(11) NOT NULL auto_increment,
  `device_id` int(11) default NULL,
  `vlan_vlan` int(11) default NULL,
  `vlan_domain` text,
  `vlan_descr` text,
  PRIMARY KEY  (`vlan_id`),
  KEY `device_id` (`device_id`,`vlan_vlan`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

