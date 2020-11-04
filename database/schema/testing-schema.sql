/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `access_points` (
  `accesspoint_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `device_id` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `radio_number` tinyint(4) DEFAULT NULL,
  `type` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `mac_addr` varchar(24) COLLATE utf8_unicode_ci NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `channel` tinyint(3) unsigned NOT NULL DEFAULT 0,
  `txpow` tinyint(4) NOT NULL DEFAULT 0,
  `radioutil` tinyint(4) NOT NULL DEFAULT 0,
  `numasoclients` smallint(6) NOT NULL DEFAULT 0,
  `nummonclients` smallint(6) NOT NULL DEFAULT 0,
  `numactbssid` tinyint(4) NOT NULL DEFAULT 0,
  `nummonbssid` tinyint(4) NOT NULL DEFAULT 0,
  `interference` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`accesspoint_id`),
  KEY `name` (`name`,`radio_number`),
  KEY `access_points_deleted_index` (`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `alert_device_map` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rule_id` int(10) unsigned NOT NULL,
  `device_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `alert_device_map_rule_id_device_id_unique` (`rule_id`,`device_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `alert_group_map` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rule_id` int(10) unsigned NOT NULL,
  `group_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `alert_group_map_rule_id_group_id_unique` (`rule_id`,`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `alert_location_map` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rule_id` int(10) unsigned NOT NULL,
  `location_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `alert_location_map_rule_id_location_id_uindex` (`rule_id`,`location_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `alert_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rule_id` int(10) unsigned NOT NULL,
  `device_id` int(10) unsigned NOT NULL,
  `state` int(11) NOT NULL,
  `details` longblob DEFAULT NULL,
  `time_logged` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `alert_log_rule_id_index` (`rule_id`),
  KEY `alert_log_device_id_index` (`device_id`),
  KEY `alert_log_time_logged_index` (`time_logged`),
  KEY `alert_log_rule_id_device_id_index` (`rule_id`,`device_id`),
  KEY `alert_log_rule_id_device_id_state_index` (`rule_id`,`device_id`,`state`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `alert_rules` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rule` text COLLATE utf8_unicode_ci NOT NULL,
  `severity` enum('ok','warning','critical') COLLATE utf8_unicode_ci NOT NULL,
  `extra` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `disabled` tinyint(1) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `query` text COLLATE utf8_unicode_ci NOT NULL,
  `builder` text COLLATE utf8_unicode_ci NOT NULL,
  `proc` varchar(80) COLLATE utf8_unicode_ci DEFAULT NULL,
  `invert_map` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `alert_rules_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `alert_schedulables` (
  `item_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `schedule_id` int(10) unsigned NOT NULL,
  `alert_schedulable_id` int(10) unsigned NOT NULL,
  `alert_schedulable_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`item_id`),
  KEY `schedulable_morph_index` (`alert_schedulable_type`,`alert_schedulable_id`),
  KEY `alert_schedulables_schedule_id_index` (`schedule_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `alert_schedule` (
  `schedule_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `recurring` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `start` datetime NOT NULL DEFAULT '1970-01-02 00:00:01',
  `end` datetime NOT NULL DEFAULT '1970-01-02 00:00:01',
  `recurring_day` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `notes` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`schedule_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `alert_template_map` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `alert_templates_id` int(10) unsigned NOT NULL,
  `alert_rule_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `alert_templates_id` (`alert_templates_id`,`alert_rule_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `alert_templates` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `template` longtext COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `title_rec` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `alert_transport_groups` (
  `transport_group_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `transport_group_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`transport_group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `alert_transport_map` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rule_id` int(10) unsigned NOT NULL,
  `transport_or_group_id` int(10) unsigned NOT NULL,
  `target_type` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `alert_transports` (
  `transport_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `transport_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `transport_type` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'mail',
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `transport_config` text COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`transport_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `alerts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `device_id` int(10) unsigned NOT NULL,
  `rule_id` int(10) unsigned NOT NULL,
  `state` int(11) NOT NULL,
  `alerted` int(11) NOT NULL,
  `open` int(11) NOT NULL,
  `note` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `info` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `alerts_device_id_rule_id_unique` (`device_id`,`rule_id`),
  KEY `alerts_device_id_index` (`device_id`),
  KEY `alerts_rule_id_index` (`rule_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `api_tokens` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `token_hash` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `disabled` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `api_tokens_token_hash_unique` (`token_hash`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `application_metrics` (
  `app_id` int(10) unsigned NOT NULL,
  `metric` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `value` double DEFAULT NULL,
  `value_prev` double DEFAULT NULL,
  UNIQUE KEY `application_metrics_app_id_metric_unique` (`app_id`,`metric`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `applications` (
  `app_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `device_id` int(10) unsigned NOT NULL,
  `app_type` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `app_state` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'UNKNOWN',
  `discovered` tinyint(4) NOT NULL DEFAULT 0,
  `app_state_prev` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `app_status` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `app_instance` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`app_id`),
  UNIQUE KEY `applications_device_id_app_type_unique` (`device_id`,`app_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `authlog` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `user` text COLLATE utf8_unicode_ci NOT NULL,
  `address` text COLLATE utf8_unicode_ci NOT NULL,
  `result` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `availability` (
  `availability_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `device_id` int(10) unsigned NOT NULL,
  `duration` bigint(20) NOT NULL,
  `availability_perc` decimal(9,6) NOT NULL DEFAULT 0.000000,
  PRIMARY KEY (`availability_id`),
  UNIQUE KEY `availability_device_id_duration_unique` (`device_id`,`duration`),
  KEY `availability_device_id_index` (`device_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bgpPeers` (
  `bgpPeer_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `device_id` int(10) unsigned NOT NULL,
  `vrf_id` int(10) unsigned DEFAULT NULL,
  `astext` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `bgpPeerIdentifier` text COLLATE utf8_unicode_ci NOT NULL,
  `bgpPeerRemoteAs` bigint(20) NOT NULL,
  `bgpPeerState` text COLLATE utf8_unicode_ci NOT NULL,
  `bgpPeerAdminStatus` text COLLATE utf8_unicode_ci NOT NULL,
  `bgpPeerLastErrorCode` int(11) DEFAULT NULL,
  `bgpPeerLastErrorSubCode` int(11) DEFAULT NULL,
  `bgpPeerLastErrorText` varchar(254) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bgpLocalAddr` text COLLATE utf8_unicode_ci NOT NULL,
  `bgpPeerRemoteAddr` text COLLATE utf8_unicode_ci NOT NULL,
  `bgpPeerDescr` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `bgpPeerInUpdates` int(11) NOT NULL,
  `bgpPeerOutUpdates` int(11) NOT NULL,
  `bgpPeerInTotalMessages` int(11) NOT NULL,
  `bgpPeerOutTotalMessages` int(11) NOT NULL,
  `bgpPeerFsmEstablishedTime` int(11) NOT NULL,
  `bgpPeerInUpdateElapsedTime` int(11) NOT NULL,
  `context_name` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`bgpPeer_id`),
  KEY `bgppeers_device_id_context_name_index` (`device_id`,`context_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bgpPeers_cbgp` (
  `device_id` int(10) unsigned NOT NULL,
  `bgpPeerIdentifier` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `afi` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `safi` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `AcceptedPrefixes` int(11) NOT NULL,
  `DeniedPrefixes` int(11) NOT NULL,
  `PrefixAdminLimit` int(11) NOT NULL,
  `PrefixThreshold` int(11) NOT NULL,
  `PrefixClearThreshold` int(11) NOT NULL,
  `AdvertisedPrefixes` int(11) NOT NULL,
  `SuppressedPrefixes` int(11) NOT NULL,
  `WithdrawnPrefixes` int(11) NOT NULL,
  `AcceptedPrefixes_delta` int(11) NOT NULL,
  `AcceptedPrefixes_prev` int(11) NOT NULL,
  `DeniedPrefixes_delta` int(11) NOT NULL,
  `DeniedPrefixes_prev` int(11) NOT NULL,
  `AdvertisedPrefixes_delta` int(11) NOT NULL,
  `AdvertisedPrefixes_prev` int(11) NOT NULL,
  `SuppressedPrefixes_delta` int(11) NOT NULL,
  `SuppressedPrefixes_prev` int(11) NOT NULL,
  `WithdrawnPrefixes_delta` int(11) NOT NULL,
  `WithdrawnPrefixes_prev` int(11) NOT NULL,
  `context_name` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  UNIQUE KEY `bgppeers_cbgp_device_id_bgppeeridentifier_afi_safi_unique` (`device_id`,`bgpPeerIdentifier`,`afi`,`safi`),
  KEY `bgppeers_cbgp_device_id_bgppeeridentifier_context_name_index` (`device_id`,`bgpPeerIdentifier`,`context_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bill_data` (
  `bill_id` int(10) unsigned NOT NULL,
  `timestamp` datetime NOT NULL,
  `period` int(11) NOT NULL,
  `delta` bigint(20) NOT NULL,
  `in_delta` bigint(20) NOT NULL,
  `out_delta` bigint(20) NOT NULL,
  PRIMARY KEY (`bill_id`,`timestamp`),
  KEY `bill_data_bill_id_index` (`bill_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bill_history` (
  `bill_hist_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `bill_id` int(10) unsigned NOT NULL,
  `updated` timestamp NOT NULL DEFAULT current_timestamp(),
  `bill_datefrom` datetime NOT NULL,
  `bill_dateto` datetime NOT NULL,
  `bill_type` text COLLATE utf8_unicode_ci NOT NULL,
  `bill_allowed` bigint(20) NOT NULL,
  `bill_used` bigint(20) NOT NULL,
  `bill_overuse` bigint(20) NOT NULL,
  `bill_percent` decimal(10,2) NOT NULL,
  `rate_95th_in` bigint(20) NOT NULL,
  `rate_95th_out` bigint(20) NOT NULL,
  `rate_95th` bigint(20) NOT NULL,
  `dir_95th` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `rate_average` bigint(20) NOT NULL,
  `rate_average_in` bigint(20) NOT NULL,
  `rate_average_out` bigint(20) NOT NULL,
  `traf_in` bigint(20) NOT NULL,
  `traf_out` bigint(20) NOT NULL,
  `traf_total` bigint(20) NOT NULL,
  `pdf` longblob DEFAULT NULL,
  PRIMARY KEY (`bill_hist_id`),
  UNIQUE KEY `bill_history_bill_id_bill_datefrom_bill_dateto_unique` (`bill_id`,`bill_datefrom`,`bill_dateto`),
  KEY `bill_history_bill_id_index` (`bill_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bill_perms` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `bill_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bill_port_counters` (
  `port_id` int(10) unsigned NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `in_counter` bigint(20) DEFAULT NULL,
  `in_delta` bigint(20) NOT NULL DEFAULT 0,
  `out_counter` bigint(20) DEFAULT NULL,
  `out_delta` bigint(20) NOT NULL DEFAULT 0,
  `bill_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`port_id`,`bill_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bill_ports` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `bill_id` int(10) unsigned NOT NULL,
  `port_id` int(10) unsigned NOT NULL,
  `bill_port_autoadded` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bills` (
  `bill_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `bill_name` text COLLATE utf8_unicode_ci NOT NULL,
  `bill_type` text COLLATE utf8_unicode_ci NOT NULL,
  `bill_cdr` bigint(20) DEFAULT NULL,
  `bill_day` int(11) NOT NULL DEFAULT 1,
  `bill_quota` bigint(20) DEFAULT NULL,
  `rate_95th_in` bigint(20) NOT NULL,
  `rate_95th_out` bigint(20) NOT NULL,
  `rate_95th` bigint(20) NOT NULL,
  `dir_95th` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `total_data` bigint(20) NOT NULL,
  `total_data_in` bigint(20) NOT NULL,
  `total_data_out` bigint(20) NOT NULL,
  `rate_average_in` bigint(20) NOT NULL,
  `rate_average_out` bigint(20) NOT NULL,
  `rate_average` bigint(20) NOT NULL,
  `bill_last_calc` datetime NOT NULL,
  `bill_custid` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `bill_ref` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `bill_notes` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `bill_autoadded` tinyint(1) NOT NULL,
  PRIMARY KEY (`bill_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL,
  UNIQUE KEY `cache_key_unique` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `callback` (
  `callback_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(64) COLLATE utf8_unicode_ci NOT NULL,
  `value` char(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`callback_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cef_switching` (
  `cef_switching_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `device_id` int(10) unsigned NOT NULL,
  `entPhysicalIndex` int(11) NOT NULL,
  `afi` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `cef_index` int(11) NOT NULL,
  `cef_path` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `drop` int(11) NOT NULL,
  `punt` int(11) NOT NULL,
  `punt2host` int(11) NOT NULL,
  `drop_prev` int(11) NOT NULL,
  `punt_prev` int(11) NOT NULL,
  `punt2host_prev` int(11) NOT NULL,
  `updated` int(10) unsigned NOT NULL,
  `updated_prev` int(10) unsigned NOT NULL,
  PRIMARY KEY (`cef_switching_id`),
  UNIQUE KEY `cef_switching_device_id_entphysicalindex_afi_cef_index_unique` (`device_id`,`entPhysicalIndex`,`afi`,`cef_index`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ciscoASA` (
  `ciscoASA_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `device_id` int(10) unsigned NOT NULL,
  `oid` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `data` bigint(20) NOT NULL,
  `high_alert` bigint(20) NOT NULL,
  `low_alert` bigint(20) NOT NULL,
  `disabled` tinyint(4) NOT NULL DEFAULT 0,
  PRIMARY KEY (`ciscoASA_id`),
  KEY `ciscoasa_device_id_index` (`device_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `component` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID for each component, unique index',
  `device_id` int(10) unsigned NOT NULL COMMENT 'device_id from the devices table',
  `type` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'name from the component_type table',
  `label` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Display label for the component',
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'The status of the component, retreived from the device',
  `disabled` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Should this component be polled',
  `ignore` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Should this component be alerted on',
  `error` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Error message if in Alert state',
  PRIMARY KEY (`id`),
  KEY `component_device_id_index` (`device_id`),
  KEY `component_type_index` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `component_prefs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID for each entry',
  `component` int(10) unsigned NOT NULL COMMENT 'id from the component table',
  `attribute` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Attribute for the Component',
  `value` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'Value for the Component',
  PRIMARY KEY (`id`),
  KEY `component_prefs_component_index` (`component`),
  CONSTRAINT `component_prefs_ibfk_1` FOREIGN KEY (`component`) REFERENCES `component` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `component_statuslog` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID for each log entry, unique index',
  `component_id` int(10) unsigned NOT NULL COMMENT 'id from the component table',
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'The status that the component was changed TO',
  `message` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'When the status of the component was changed',
  PRIMARY KEY (`id`),
  KEY `component_statuslog_component_id_index` (`component_id`),
  CONSTRAINT `component_statuslog_ibfk_1` FOREIGN KEY (`component_id`) REFERENCES `component` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `config` (
  `config_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `config_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `config_value` varchar(512) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`config_id`),
  UNIQUE KEY `config_config_name_unique` (`config_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customers` (
  `customer_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` char(64) COLLATE utf8_unicode_ci NOT NULL,
  `password` char(32) COLLATE utf8_unicode_ci NOT NULL,
  `string` char(64) COLLATE utf8_unicode_ci NOT NULL,
  `level` tinyint(4) NOT NULL DEFAULT 0,
  PRIMARY KEY (`customer_id`),
  UNIQUE KEY `customers_username_unique` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customoids` (
  `customoid_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `device_id` int(10) unsigned NOT NULL DEFAULT 0,
  `customoid_descr` varchar(255) COLLATE utf8_unicode_ci DEFAULT '',
  `customoid_deleted` tinyint(4) NOT NULL DEFAULT 0,
  `customoid_current` double DEFAULT NULL,
  `customoid_prev` double DEFAULT NULL,
  `customoid_oid` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `customoid_datatype` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'GAUGE',
  `customoid_unit` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `customoid_divisor` int(10) unsigned NOT NULL DEFAULT 1,
  `customoid_multiplier` int(10) unsigned NOT NULL DEFAULT 1,
  `customoid_limit` double DEFAULT NULL,
  `customoid_limit_warn` double DEFAULT NULL,
  `customoid_limit_low` double DEFAULT NULL,
  `customoid_limit_low_warn` double DEFAULT NULL,
  `customoid_alert` tinyint(4) NOT NULL DEFAULT 0,
  `customoid_passed` tinyint(4) NOT NULL DEFAULT 0,
  `lastupdate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user_func` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`customoid_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dashboards` (
  `dashboard_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT 0,
  `dashboard_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `access` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`dashboard_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dbSchema` (
  `version` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `device_graphs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `device_id` int(10) unsigned NOT NULL,
  `graph` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `device_graphs_device_id_index` (`device_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `device_group_device` (
  `device_group_id` int(10) unsigned NOT NULL,
  `device_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`device_group_id`,`device_id`),
  KEY `device_group_device_device_group_id_index` (`device_group_id`),
  KEY `device_group_device_device_id_index` (`device_id`),
  CONSTRAINT `device_group_device_device_group_id_foreign` FOREIGN KEY (`device_group_id`) REFERENCES `device_groups` (`id`) ON DELETE CASCADE,
  CONSTRAINT `device_group_device_device_id_foreign` FOREIGN KEY (`device_id`) REFERENCES `devices` (`device_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `device_groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `desc` varchar(255) COLLATE utf8_unicode_ci DEFAULT '',
  `type` varchar(16) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'dynamic',
  `rules` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `pattern` text COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `device_groups_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `device_outages` (
  `device_id` int(10) unsigned NOT NULL,
  `going_down` bigint(20) NOT NULL,
  `up_again` bigint(20) DEFAULT NULL,
  UNIQUE KEY `device_outages_device_id_going_down_unique` (`device_id`,`going_down`),
  KEY `device_outages_device_id_index` (`device_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `device_perf` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `device_id` int(10) unsigned NOT NULL,
  `timestamp` datetime NOT NULL,
  `xmt` int(11) NOT NULL,
  `rcv` int(11) NOT NULL,
  `loss` int(11) NOT NULL,
  `min` double(8,2) NOT NULL,
  `max` double(8,2) NOT NULL,
  `avg` double(8,2) NOT NULL,
  `debug` text COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `device_perf_device_id_index` (`device_id`),
  KEY `device_perf_device_id_timestamp_index` (`device_id`,`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `device_relationships` (
  `parent_device_id` int(10) unsigned NOT NULL DEFAULT 0,
  `child_device_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`parent_device_id`,`child_device_id`),
  KEY `device_relationships_child_device_id_index` (`child_device_id`),
  CONSTRAINT `device_relationship_child_device_id_fk` FOREIGN KEY (`child_device_id`) REFERENCES `devices` (`device_id`) ON DELETE CASCADE,
  CONSTRAINT `device_relationship_parent_device_id_fk` FOREIGN KEY (`parent_device_id`) REFERENCES `devices` (`device_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `devices` (
  `device_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `inserted` timestamp NULL DEFAULT current_timestamp(),
  `hostname` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `sysName` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ip` varbinary(16) DEFAULT NULL,
  `overwrite_ip` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `community` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `authlevel` enum('noAuthNoPriv','authNoPriv','authPriv') COLLATE utf8_unicode_ci DEFAULT NULL,
  `authname` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `authpass` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `authalgo` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cryptopass` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cryptoalgo` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `snmpver` varchar(4) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'v2c',
  `port` smallint(5) unsigned NOT NULL DEFAULT 161,
  `transport` varchar(16) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'udp',
  `timeout` int(11) DEFAULT NULL,
  `retries` int(11) DEFAULT NULL,
  `snmp_disable` tinyint(1) NOT NULL DEFAULT 0,
  `bgpLocalAs` int(10) unsigned DEFAULT NULL,
  `sysObjectID` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sysDescr` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `sysContact` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `version` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `hardware` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `features` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `location_id` int(10) unsigned DEFAULT NULL,
  `os` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `status_reason` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `ignore` tinyint(1) NOT NULL DEFAULT 0,
  `disabled` tinyint(1) NOT NULL DEFAULT 0,
  `uptime` bigint(20) DEFAULT NULL,
  `agent_uptime` int(10) unsigned NOT NULL DEFAULT 0,
  `last_polled` timestamp NULL DEFAULT NULL,
  `last_poll_attempted` timestamp NULL DEFAULT NULL,
  `last_polled_timetaken` double(5,2) DEFAULT NULL,
  `last_discovered_timetaken` double(5,2) DEFAULT NULL,
  `last_discovered` timestamp NULL DEFAULT NULL,
  `last_ping` timestamp NULL DEFAULT NULL,
  `last_ping_timetaken` double(8,2) DEFAULT NULL,
  `purpose` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `serial` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `icon` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `poller_group` int(11) NOT NULL DEFAULT 0,
  `override_sysLocation` tinyint(1) DEFAULT 0,
  `notes` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `port_association_mode` int(11) NOT NULL DEFAULT 1,
  `max_depth` int(11) NOT NULL DEFAULT 0,
  `disable_notify` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`device_id`),
  KEY `devices_hostname_index` (`hostname`),
  KEY `devices_sysname_index` (`sysName`),
  KEY `devices_os_index` (`os`),
  KEY `devices_status_index` (`status`),
  KEY `devices_last_polled_index` (`last_polled`),
  KEY `devices_last_poll_attempted_index` (`last_poll_attempted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `devices_attribs` (
  `attrib_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `device_id` int(10) unsigned NOT NULL,
  `attrib_type` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `attrib_value` text COLLATE utf8_unicode_ci NOT NULL,
  `updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`attrib_id`),
  KEY `devices_attribs_device_id_index` (`device_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `devices_group_perms` (
  `user_id` int(10) unsigned NOT NULL,
  `device_group_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`device_group_id`,`user_id`),
  KEY `devices_group_perms_user_id_index` (`user_id`),
  KEY `devices_group_perms_device_group_id_index` (`device_group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `devices_perms` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `device_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `devices_perms_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `entPhysical` (
  `entPhysical_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `device_id` int(10) unsigned NOT NULL,
  `entPhysicalIndex` int(11) NOT NULL,
  `entPhysicalDescr` text COLLATE utf8_unicode_ci NOT NULL,
  `entPhysicalClass` text COLLATE utf8_unicode_ci NOT NULL,
  `entPhysicalName` text COLLATE utf8_unicode_ci NOT NULL,
  `entPhysicalHardwareRev` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `entPhysicalFirmwareRev` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `entPhysicalSoftwareRev` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `entPhysicalAlias` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `entPhysicalAssetID` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `entPhysicalIsFRU` varchar(8) COLLATE utf8_unicode_ci DEFAULT NULL,
  `entPhysicalModelName` text COLLATE utf8_unicode_ci NOT NULL,
  `entPhysicalVendorType` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `entPhysicalSerialNum` text COLLATE utf8_unicode_ci NOT NULL,
  `entPhysicalContainedIn` int(11) NOT NULL,
  `entPhysicalParentRelPos` int(11) NOT NULL,
  `entPhysicalMfgName` text COLLATE utf8_unicode_ci NOT NULL,
  `ifIndex` int(11) DEFAULT NULL,
  PRIMARY KEY (`entPhysical_id`),
  KEY `entphysical_device_id_index` (`device_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `entPhysical_state` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `device_id` int(10) unsigned NOT NULL,
  `entPhysicalIndex` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `subindex` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `group` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `key` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `device_id_index` (`device_id`,`entPhysicalIndex`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `entityState` (
  `entity_state_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `device_id` int(10) unsigned DEFAULT NULL,
  `entPhysical_id` int(10) unsigned DEFAULT NULL,
  `entStateLastChanged` datetime DEFAULT NULL,
  `entStateAdmin` int(11) DEFAULT NULL,
  `entStateOper` int(11) DEFAULT NULL,
  `entStateUsage` int(11) DEFAULT NULL,
  `entStateAlarm` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `entStateStandby` int(11) DEFAULT NULL,
  PRIMARY KEY (`entity_state_id`),
  KEY `entitystate_device_id_index` (`device_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `eventlog` (
  `event_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `device_id` int(10) unsigned DEFAULT NULL,
  `datetime` datetime NOT NULL DEFAULT '1970-01-02 00:00:01',
  `message` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `reference` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `username` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `severity` tinyint(4) NOT NULL DEFAULT 2,
  PRIMARY KEY (`event_id`),
  KEY `eventlog_device_id_index` (`device_id`),
  KEY `eventlog_datetime_index` (`datetime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `graph_types` (
  `graph_type` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `graph_subtype` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `graph_section` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `graph_descr` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `graph_order` int(11) NOT NULL,
  PRIMARY KEY (`graph_type`,`graph_subtype`,`graph_section`),
  KEY `graph_types_graph_type_index` (`graph_type`),
  KEY `graph_types_graph_subtype_index` (`graph_subtype`),
  KEY `graph_types_graph_section_index` (`graph_section`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hrDevice` (
  `hrDevice_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `device_id` int(10) unsigned NOT NULL,
  `hrDeviceIndex` int(11) NOT NULL,
  `hrDeviceDescr` text COLLATE utf8_unicode_ci NOT NULL,
  `hrDeviceType` text COLLATE utf8_unicode_ci NOT NULL,
  `hrDeviceErrors` int(11) NOT NULL DEFAULT 0,
  `hrDeviceStatus` text COLLATE utf8_unicode_ci NOT NULL,
  `hrProcessorLoad` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`hrDevice_id`),
  KEY `hrdevice_device_id_index` (`device_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ipsec_tunnels` (
  `tunnel_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `device_id` int(10) unsigned NOT NULL,
  `peer_port` int(10) unsigned NOT NULL,
  `peer_addr` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `local_addr` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `local_port` int(10) unsigned NOT NULL,
  `tunnel_name` varchar(96) COLLATE utf8_unicode_ci NOT NULL,
  `tunnel_status` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`tunnel_id`),
  UNIQUE KEY `ipsec_tunnels_device_id_peer_addr_unique` (`device_id`,`peer_addr`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ipv4_addresses` (
  `ipv4_address_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ipv4_address` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `ipv4_prefixlen` int(11) NOT NULL,
  `ipv4_network_id` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `port_id` int(10) unsigned NOT NULL,
  `context_name` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`ipv4_address_id`),
  KEY `ipv4_addresses_port_id_index` (`port_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ipv4_mac` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `port_id` int(10) unsigned NOT NULL,
  `device_id` int(10) unsigned DEFAULT NULL,
  `mac_address` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `ipv4_address` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `context_name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ipv4_mac_port_id_index` (`port_id`),
  KEY `ipv4_mac_mac_address_index` (`mac_address`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ipv4_networks` (
  `ipv4_network_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ipv4_network` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `context_name` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`ipv4_network_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ipv6_addresses` (
  `ipv6_address_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ipv6_address` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `ipv6_compressed` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `ipv6_prefixlen` int(11) NOT NULL,
  `ipv6_origin` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `ipv6_network_id` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `port_id` int(10) unsigned NOT NULL,
  `context_name` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`ipv6_address_id`),
  KEY `ipv6_addresses_port_id_index` (`port_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ipv6_networks` (
  `ipv6_network_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ipv6_network` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `context_name` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`ipv6_network_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `juniAtmVp` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `juniAtmVp_id` int(10) unsigned NOT NULL,
  `port_id` int(10) unsigned NOT NULL,
  `vp_id` int(10) unsigned NOT NULL,
  `vp_descr` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `juniatmvp_port_id_index` (`port_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `links` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `local_port_id` int(10) unsigned DEFAULT NULL,
  `local_device_id` int(10) unsigned NOT NULL,
  `remote_port_id` int(10) unsigned DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `protocol` varchar(11) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remote_hostname` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `remote_device_id` int(10) unsigned NOT NULL,
  `remote_port` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `remote_platform` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remote_version` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `local_device_id` (`local_device_id`,`remote_device_id`),
  KEY `links_local_port_id_index` (`local_port_id`),
  KEY `links_remote_port_id_index` (`remote_port_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `loadbalancer_rservers` (
  `rserver_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `farm_id` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `device_id` int(10) unsigned NOT NULL,
  `StateDescr` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`rserver_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `loadbalancer_vservers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `classmap_id` int(10) unsigned NOT NULL,
  `classmap` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `serverstate` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `device_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `loadbalancer_vservers_device_id_index` (`device_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `locations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `location` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lat` double(10,6) DEFAULT NULL,
  `lng` double(10,6) DEFAULT NULL,
  `timestamp` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `locations_location_unique` (`location`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mac_accounting` (
  `ma_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `port_id` int(10) unsigned NOT NULL,
  `mac` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `in_oid` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `out_oid` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `bps_out` int(11) NOT NULL,
  `bps_in` int(11) NOT NULL,
  `cipMacHCSwitchedBytes_input` bigint(20) DEFAULT NULL,
  `cipMacHCSwitchedBytes_input_prev` bigint(20) DEFAULT NULL,
  `cipMacHCSwitchedBytes_input_delta` bigint(20) DEFAULT NULL,
  `cipMacHCSwitchedBytes_input_rate` int(11) DEFAULT NULL,
  `cipMacHCSwitchedBytes_output` bigint(20) DEFAULT NULL,
  `cipMacHCSwitchedBytes_output_prev` bigint(20) DEFAULT NULL,
  `cipMacHCSwitchedBytes_output_delta` bigint(20) DEFAULT NULL,
  `cipMacHCSwitchedBytes_output_rate` int(11) DEFAULT NULL,
  `cipMacHCSwitchedPkts_input` bigint(20) DEFAULT NULL,
  `cipMacHCSwitchedPkts_input_prev` bigint(20) DEFAULT NULL,
  `cipMacHCSwitchedPkts_input_delta` bigint(20) DEFAULT NULL,
  `cipMacHCSwitchedPkts_input_rate` int(11) DEFAULT NULL,
  `cipMacHCSwitchedPkts_output` bigint(20) DEFAULT NULL,
  `cipMacHCSwitchedPkts_output_prev` bigint(20) DEFAULT NULL,
  `cipMacHCSwitchedPkts_output_delta` bigint(20) DEFAULT NULL,
  `cipMacHCSwitchedPkts_output_rate` int(11) DEFAULT NULL,
  `poll_time` int(10) unsigned DEFAULT NULL,
  `poll_prev` int(10) unsigned DEFAULT NULL,
  `poll_period` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`ma_id`),
  KEY `mac_accounting_port_id_index` (`port_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mefinfo` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `device_id` int(10) unsigned NOT NULL,
  `mefID` int(11) NOT NULL,
  `mefType` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `mefIdent` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `mefMTU` int(11) NOT NULL DEFAULT 1500,
  `mefAdmState` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `mefRowState` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `mefinfo_device_id_index` (`device_id`),
  KEY `mefinfo_mefid_index` (`mefID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mempools` (
  `mempool_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mempool_index` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `entPhysicalIndex` int(11) DEFAULT NULL,
  `mempool_type` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `mempool_precision` int(11) NOT NULL DEFAULT 1,
  `mempool_descr` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `device_id` int(10) unsigned NOT NULL,
  `mempool_perc` int(11) NOT NULL,
  `mempool_perc_oid` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mempool_used` bigint(20) NOT NULL,
  `mempool_used_oid` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mempool_free` bigint(20) NOT NULL,
  `mempool_free_oid` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mempool_total` bigint(20) NOT NULL,
  `mempool_total_oid` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mempool_largestfree` bigint(20) DEFAULT NULL,
  `mempool_lowestfree` bigint(20) DEFAULT NULL,
  `mempool_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `mempool_perc_warn` int(11) DEFAULT NULL,
  PRIMARY KEY (`mempool_id`),
  KEY `mempools_device_id_index` (`device_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mpls_lsp_paths` (
  `lsp_path_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lsp_id` int(10) unsigned NOT NULL,
  `path_oid` int(10) unsigned NOT NULL,
  `device_id` int(10) unsigned NOT NULL,
  `mplsLspPathRowStatus` enum('active','notInService','notReady','createAndGo','createAndWait','destroy') COLLATE utf8_unicode_ci NOT NULL,
  `mplsLspPathLastChange` bigint(20) NOT NULL,
  `mplsLspPathType` enum('other','primary','standby','secondary') COLLATE utf8_unicode_ci NOT NULL,
  `mplsLspPathBandwidth` int(10) unsigned NOT NULL,
  `mplsLspPathOperBandwidth` int(10) unsigned NOT NULL,
  `mplsLspPathAdminState` enum('noop','inService','outOfService') COLLATE utf8_unicode_ci NOT NULL,
  `mplsLspPathOperState` enum('unknown','inService','outOfService','transition') COLLATE utf8_unicode_ci NOT NULL,
  `mplsLspPathState` enum('unknown','active','inactive') COLLATE utf8_unicode_ci NOT NULL,
  `mplsLspPathFailCode` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `mplsLspPathFailNodeAddr` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `mplsLspPathMetric` int(10) unsigned NOT NULL,
  `mplsLspPathOperMetric` int(10) unsigned DEFAULT NULL,
  `mplsLspPathTimeUp` bigint(20) DEFAULT NULL,
  `mplsLspPathTimeDown` bigint(20) DEFAULT NULL,
  `mplsLspPathTransitionCount` int(10) unsigned DEFAULT NULL,
  `mplsLspPathTunnelARHopListIndex` int(10) unsigned DEFAULT NULL,
  `mplsLspPathTunnelCHopListIndex` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`lsp_path_id`),
  KEY `mpls_lsp_paths_device_id_index` (`device_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mpls_lsps` (
  `lsp_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `vrf_oid` int(10) unsigned NOT NULL,
  `lsp_oid` int(10) unsigned NOT NULL,
  `device_id` int(10) unsigned NOT NULL,
  `mplsLspRowStatus` enum('active','notInService','notReady','createAndGo','createAndWait','destroy') COLLATE utf8_unicode_ci NOT NULL,
  `mplsLspLastChange` bigint(20) DEFAULT NULL,
  `mplsLspName` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `mplsLspAdminState` enum('noop','inService','outOfService') COLLATE utf8_unicode_ci NOT NULL,
  `mplsLspOperState` enum('unknown','inService','outOfService','transition') COLLATE utf8_unicode_ci NOT NULL,
  `mplsLspFromAddr` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `mplsLspToAddr` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `mplsLspType` enum('unknown','dynamic','static','bypassOnly','p2mpLsp','p2mpAuto','mplsTp','meshP2p','oneHopP2p','srTe','meshP2pSrTe','oneHopP2pSrTe') COLLATE utf8_unicode_ci NOT NULL,
  `mplsLspFastReroute` enum('true','false') COLLATE utf8_unicode_ci NOT NULL,
  `mplsLspAge` bigint(20) DEFAULT NULL,
  `mplsLspTimeUp` bigint(20) DEFAULT NULL,
  `mplsLspTimeDown` bigint(20) DEFAULT NULL,
  `mplsLspPrimaryTimeUp` bigint(20) DEFAULT NULL,
  `mplsLspTransitions` int(10) unsigned DEFAULT NULL,
  `mplsLspLastTransition` bigint(20) DEFAULT NULL,
  `mplsLspConfiguredPaths` int(10) unsigned DEFAULT NULL,
  `mplsLspStandbyPaths` int(10) unsigned DEFAULT NULL,
  `mplsLspOperationalPaths` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`lsp_id`),
  KEY `mpls_lsps_device_id_index` (`device_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mpls_saps` (
  `sap_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `svc_id` int(10) unsigned NOT NULL,
  `svc_oid` int(10) unsigned NOT NULL,
  `sapPortId` int(10) unsigned NOT NULL,
  `ifName` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `device_id` int(10) unsigned NOT NULL,
  `sapEncapValue` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sapRowStatus` enum('active','notInService','notReady','createAndGo','createAndWait','destroy') COLLATE utf8_unicode_ci DEFAULT NULL,
  `sapType` enum('unknown','epipe','tls','vprn','ies','mirror','apipe','fpipe','ipipe','cpipe','intTls','evpnIsaTls') COLLATE utf8_unicode_ci DEFAULT NULL,
  `sapDescription` varchar(80) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sapAdminStatus` enum('up','down') COLLATE utf8_unicode_ci DEFAULT NULL,
  `sapOperStatus` enum('up','down') COLLATE utf8_unicode_ci DEFAULT NULL,
  `sapLastMgmtChange` bigint(20) DEFAULT NULL,
  `sapLastStatusChange` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`sap_id`),
  KEY `mpls_saps_device_id_index` (`device_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mpls_sdp_binds` (
  `bind_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sdp_id` int(10) unsigned NOT NULL,
  `svc_id` int(10) unsigned NOT NULL,
  `sdp_oid` int(10) unsigned NOT NULL,
  `svc_oid` int(10) unsigned NOT NULL,
  `device_id` int(10) unsigned NOT NULL,
  `sdpBindRowStatus` enum('active','notInService','notReady','createAndGo','createAndWait','destroy') COLLATE utf8_unicode_ci DEFAULT NULL,
  `sdpBindAdminStatus` enum('up','down') COLLATE utf8_unicode_ci DEFAULT NULL,
  `sdpBindOperStatus` enum('up','down') COLLATE utf8_unicode_ci DEFAULT NULL,
  `sdpBindLastMgmtChange` bigint(20) DEFAULT NULL,
  `sdpBindLastStatusChange` bigint(20) DEFAULT NULL,
  `sdpBindType` enum('spoke','mesh') COLLATE utf8_unicode_ci DEFAULT NULL,
  `sdpBindVcType` enum('undef','ether','vlan','mirrior','atmSduatmCell','atmVcc','atmVpc','frDlci','ipipe','satopE1','satopT1','satopE3','satopT3','cesopsn','cesopsnCas') COLLATE utf8_unicode_ci DEFAULT NULL,
  `sdpBindBaseStatsIngFwdPackets` bigint(20) DEFAULT NULL,
  `sdpBindBaseStatsIngFwdOctets` bigint(20) DEFAULT NULL,
  `sdpBindBaseStatsEgrFwdPackets` bigint(20) DEFAULT NULL,
  `sdpBindBaseStatsEgrFwdOctets` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`bind_id`),
  KEY `mpls_sdp_binds_device_id_index` (`device_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mpls_sdps` (
  `sdp_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sdp_oid` int(10) unsigned NOT NULL,
  `device_id` int(10) unsigned NOT NULL,
  `sdpRowStatus` enum('active','notInService','notReady','createAndGo','createAndWait','destroy') COLLATE utf8_unicode_ci DEFAULT NULL,
  `sdpDelivery` enum('gre','mpls','l2tpv3','greethbridged') COLLATE utf8_unicode_ci DEFAULT NULL,
  `sdpDescription` varchar(80) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sdpAdminStatus` enum('up','down') COLLATE utf8_unicode_ci DEFAULT NULL,
  `sdpOperStatus` enum('up','notAlive','notReady','invalidEgressInterface','transportTunnelDown','down') COLLATE utf8_unicode_ci DEFAULT NULL,
  `sdpAdminPathMtu` int(11) DEFAULT NULL,
  `sdpOperPathMtu` int(11) DEFAULT NULL,
  `sdpLastMgmtChange` bigint(20) DEFAULT NULL,
  `sdpLastStatusChange` bigint(20) DEFAULT NULL,
  `sdpActiveLspType` enum('not-applicable','rsvp','ldp','bgp','none','mplsTp','srIsis','srOspf','srTeLsp','fpe') COLLATE utf8_unicode_ci DEFAULT NULL,
  `sdpFarEndInetAddressType` enum('ipv4','ipv6') COLLATE utf8_unicode_ci DEFAULT NULL,
  `sdpFarEndInetAddress` varchar(46) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`sdp_id`),
  KEY `mpls_sdps_device_id_index` (`device_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mpls_services` (
  `svc_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `svc_oid` int(10) unsigned NOT NULL,
  `device_id` int(10) unsigned NOT NULL,
  `svcRowStatus` enum('active','notInService','notReady','createAndGo','createAndWait','destroy') COLLATE utf8_unicode_ci DEFAULT NULL,
  `svcType` enum('unknown','epipe','tls','vprn','ies','mirror','apipe','fpipe','ipipe','cpipe','intTls','evpnIsaTls') COLLATE utf8_unicode_ci DEFAULT NULL,
  `svcCustId` int(10) unsigned DEFAULT NULL,
  `svcAdminStatus` enum('up','down') COLLATE utf8_unicode_ci DEFAULT NULL,
  `svcOperStatus` enum('up','down') COLLATE utf8_unicode_ci DEFAULT NULL,
  `svcDescription` varchar(80) COLLATE utf8_unicode_ci DEFAULT NULL,
  `svcMtu` int(11) DEFAULT NULL,
  `svcNumSaps` int(11) DEFAULT NULL,
  `svcNumSdps` int(11) DEFAULT NULL,
  `svcLastMgmtChange` bigint(20) DEFAULT NULL,
  `svcLastStatusChange` bigint(20) DEFAULT NULL,
  `svcVRouterId` int(11) DEFAULT NULL,
  `svcTlsMacLearning` enum('enabled','disabled') COLLATE utf8_unicode_ci DEFAULT NULL,
  `svcTlsStpAdminStatus` enum('enabled','disabled') COLLATE utf8_unicode_ci DEFAULT NULL,
  `svcTlsStpOperStatus` enum('up','down') COLLATE utf8_unicode_ci DEFAULT NULL,
  `svcTlsFdbTableSize` int(11) DEFAULT NULL,
  `svcTlsFdbNumEntries` int(11) DEFAULT NULL,
  PRIMARY KEY (`svc_id`),
  KEY `mpls_services_device_id_index` (`device_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mpls_tunnel_ar_hops` (
  `ar_hop_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mplsTunnelARHopListIndex` int(10) unsigned NOT NULL,
  `mplsTunnelARHopIndex` int(10) unsigned NOT NULL,
  `device_id` int(10) unsigned NOT NULL,
  `lsp_path_id` int(10) unsigned NOT NULL,
  `mplsTunnelARHopAddrType` enum('unknown','ipV4','ipV6','asNumber','lspid','unnum') COLLATE utf8_unicode_ci DEFAULT NULL,
  `mplsTunnelARHopIpv4Addr` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mplsTunnelARHopIpv6Addr` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mplsTunnelARHopAsNumber` int(10) unsigned DEFAULT NULL,
  `mplsTunnelARHopStrictOrLoose` enum('strict','loose') COLLATE utf8_unicode_ci DEFAULT NULL,
  `mplsTunnelARHopRouterId` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `localProtected` enum('false','true') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'false',
  `linkProtectionInUse` enum('false','true') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'false',
  `bandwidthProtected` enum('false','true') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'false',
  `nextNodeProtected` enum('false','true') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'false',
  PRIMARY KEY (`ar_hop_id`),
  KEY `mpls_tunnel_ar_hops_device_id_index` (`device_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mpls_tunnel_c_hops` (
  `c_hop_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mplsTunnelCHopListIndex` int(10) unsigned NOT NULL,
  `mplsTunnelCHopIndex` int(10) unsigned NOT NULL,
  `device_id` int(10) unsigned NOT NULL,
  `lsp_path_id` int(10) unsigned DEFAULT NULL,
  `mplsTunnelCHopAddrType` enum('unknown','ipV4','ipV6','asNumber','lspid','unnum') COLLATE utf8_unicode_ci DEFAULT NULL,
  `mplsTunnelCHopIpv4Addr` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mplsTunnelCHopIpv6Addr` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mplsTunnelCHopAsNumber` int(10) unsigned DEFAULT NULL,
  `mplsTunnelCHopStrictOrLoose` enum('strict','loose') COLLATE utf8_unicode_ci DEFAULT NULL,
  `mplsTunnelCHopRouterId` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`c_hop_id`),
  KEY `mpls_tunnel_c_hops_device_id_index` (`device_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `munin_plugins` (
  `mplug_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `device_id` int(10) unsigned NOT NULL,
  `mplug_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mplug_instance` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mplug_category` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mplug_title` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mplug_info` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `mplug_vlabel` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mplug_args` varchar(512) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mplug_total` tinyint(1) NOT NULL DEFAULT 0,
  `mplug_graph` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`mplug_id`),
  UNIQUE KEY `munin_plugins_device_id_mplug_type_unique` (`device_id`,`mplug_type`),
  KEY `munin_plugins_device_id_index` (`device_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `munin_plugins_ds` (
  `mplug_id` int(10) unsigned NOT NULL,
  `ds_name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `ds_type` enum('COUNTER','ABSOLUTE','DERIVE','GAUGE') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'GAUGE',
  `ds_label` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `ds_cdef` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ds_draw` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `ds_graph` enum('no','yes') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'yes',
  `ds_info` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ds_extinfo` text COLLATE utf8_unicode_ci NOT NULL,
  `ds_max` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `ds_min` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `ds_negative` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `ds_warning` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `ds_critical` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `ds_colour` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `ds_sum` text COLLATE utf8_unicode_ci NOT NULL,
  `ds_stack` text COLLATE utf8_unicode_ci NOT NULL,
  `ds_line` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  UNIQUE KEY `munin_plugins_ds_mplug_id_ds_name_unique` (`mplug_id`,`ds_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `netscaler_vservers` (
  `vsvr_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `device_id` int(10) unsigned NOT NULL,
  `vsvr_name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `vsvr_ip` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `vsvr_port` int(11) NOT NULL,
  `vsvr_type` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `vsvr_state` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `vsvr_clients` int(11) NOT NULL,
  `vsvr_server` int(11) NOT NULL,
  `vsvr_req_rate` int(11) NOT NULL,
  `vsvr_bps_in` int(11) NOT NULL,
  `vsvr_bps_out` int(11) NOT NULL,
  PRIMARY KEY (`vsvr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notifications` (
  `notifications_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `body` text COLLATE utf8_unicode_ci NOT NULL,
  `severity` int(11) DEFAULT 0 COMMENT '0=ok,1=warning,2=critical',
  `source` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `checksum` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT '1970-01-02 06:00:00',
  PRIMARY KEY (`notifications_id`),
  UNIQUE KEY `notifications_checksum_unique` (`checksum`),
  KEY `notifications_severity_index` (`severity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notifications_attribs` (
  `attrib_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `notifications_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `key` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`attrib_id`),
  KEY `notifications_attribs_notifications_id_user_id_index` (`notifications_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ospf_areas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `device_id` int(10) unsigned NOT NULL,
  `ospfAreaId` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `ospfAuthType` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ospfImportAsExtern` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `ospfSpfRuns` int(11) NOT NULL,
  `ospfAreaBdrRtrCount` int(11) NOT NULL,
  `ospfAsBdrRtrCount` int(11) NOT NULL,
  `ospfAreaLsaCount` int(11) NOT NULL,
  `ospfAreaLsaCksumSum` int(11) NOT NULL,
  `ospfAreaSummary` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `ospfAreaStatus` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `context_name` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ospf_areas_device_id_ospfareaid_context_name_unique` (`device_id`,`ospfAreaId`,`context_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ospf_instances` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `device_id` int(10) unsigned NOT NULL,
  `ospf_instance_id` int(10) unsigned NOT NULL,
  `ospfRouterId` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `ospfAdminStat` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `ospfVersionNumber` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `ospfAreaBdrRtrStatus` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `ospfASBdrRtrStatus` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `ospfExternLsaCount` int(11) NOT NULL,
  `ospfExternLsaCksumSum` int(11) NOT NULL,
  `ospfTOSSupport` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `ospfOriginateNewLsas` int(11) NOT NULL,
  `ospfRxNewLsas` int(11) NOT NULL,
  `ospfExtLsdbLimit` int(11) DEFAULT NULL,
  `ospfMulticastExtensions` int(11) DEFAULT NULL,
  `ospfExitOverflowInterval` int(11) DEFAULT NULL,
  `ospfDemandExtensions` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `context_name` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ospf_instances_device_id_ospf_instance_id_context_name_unique` (`device_id`,`ospf_instance_id`,`context_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ospf_nbrs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `device_id` int(10) unsigned NOT NULL,
  `port_id` int(10) unsigned DEFAULT NULL,
  `ospf_nbr_id` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `ospfNbrIpAddr` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `ospfNbrAddressLessIndex` int(11) NOT NULL,
  `ospfNbrRtrId` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `ospfNbrOptions` int(11) NOT NULL,
  `ospfNbrPriority` int(11) NOT NULL,
  `ospfNbrState` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `ospfNbrEvents` int(11) NOT NULL,
  `ospfNbrLsRetransQLen` int(11) NOT NULL,
  `ospfNbmaNbrStatus` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `ospfNbmaNbrPermanence` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `ospfNbrHelloSuppressed` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `context_name` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ospf_nbrs_device_id_ospf_nbr_id_context_name_unique` (`device_id`,`ospf_nbr_id`,`context_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ospf_ports` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `device_id` int(10) unsigned NOT NULL,
  `port_id` int(10) unsigned NOT NULL,
  `ospf_port_id` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `ospfIfIpAddress` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `ospfAddressLessIf` int(11) NOT NULL,
  `ospfIfAreaId` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `ospfIfType` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ospfIfAdminStat` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ospfIfRtrPriority` int(11) DEFAULT NULL,
  `ospfIfTransitDelay` int(11) DEFAULT NULL,
  `ospfIfRetransInterval` int(11) DEFAULT NULL,
  `ospfIfHelloInterval` int(11) DEFAULT NULL,
  `ospfIfRtrDeadInterval` int(11) DEFAULT NULL,
  `ospfIfPollInterval` int(11) DEFAULT NULL,
  `ospfIfState` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ospfIfDesignatedRouter` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ospfIfBackupDesignatedRouter` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ospfIfEvents` int(11) DEFAULT NULL,
  `ospfIfAuthKey` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ospfIfStatus` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ospfIfMulticastForwarding` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ospfIfDemand` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ospfIfAuthType` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `context_name` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ospf_ports_device_id_ospf_port_id_context_name_unique` (`device_id`,`ospf_port_id`,`context_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `packages` (
  `pkg_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `device_id` int(10) unsigned NOT NULL,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `manager` varchar(16) COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL,
  `version` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `build` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `arch` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `size` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`pkg_id`),
  UNIQUE KEY `packages_device_id_name_manager_arch_version_build_unique` (`device_id`,`name`,`manager`,`arch`,`version`,`build`),
  KEY `packages_device_id_index` (`device_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pdb_ix` (
  `pdb_ix_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ix_id` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `asn` int(10) unsigned NOT NULL,
  `timestamp` int(10) unsigned NOT NULL,
  PRIMARY KEY (`pdb_ix_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pdb_ix_peers` (
  `pdb_ix_peers_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ix_id` int(10) unsigned NOT NULL,
  `peer_id` int(10) unsigned NOT NULL,
  `remote_asn` int(10) unsigned NOT NULL,
  `remote_ipaddr4` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remote_ipaddr6` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `timestamp` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`pdb_ix_peers_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `perf_times` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `doing` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `start` int(10) unsigned NOT NULL,
  `duration` double(8,2) NOT NULL,
  `devices` int(10) unsigned NOT NULL,
  `poller` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `perf_times_type_index` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `plugins` (
  `plugin_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `plugin_name` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `plugin_active` int(11) NOT NULL,
  PRIMARY KEY (`plugin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `poller_cluster` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `node_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `poller_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `poller_version` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `poller_groups` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `last_report` datetime NOT NULL,
  `master` tinyint(1) NOT NULL,
  `poller_enabled` tinyint(1) DEFAULT NULL,
  `poller_frequency` int(11) DEFAULT NULL,
  `poller_workers` int(11) DEFAULT NULL,
  `poller_down_retry` int(11) DEFAULT NULL,
  `discovery_enabled` tinyint(1) DEFAULT NULL,
  `discovery_frequency` int(11) DEFAULT NULL,
  `discovery_workers` int(11) DEFAULT NULL,
  `services_enabled` tinyint(1) DEFAULT NULL,
  `services_frequency` int(11) DEFAULT NULL,
  `services_workers` int(11) DEFAULT NULL,
  `billing_enabled` tinyint(1) DEFAULT NULL,
  `billing_frequency` int(11) DEFAULT NULL,
  `billing_calculate_frequency` int(11) DEFAULT NULL,
  `alerting_enabled` tinyint(1) DEFAULT NULL,
  `alerting_frequency` int(11) DEFAULT NULL,
  `ping_enabled` tinyint(1) DEFAULT NULL,
  `ping_frequency` int(11) DEFAULT NULL,
  `update_enabled` tinyint(1) DEFAULT NULL,
  `update_frequency` int(11) DEFAULT NULL,
  `loglevel` varchar(8) COLLATE utf8_unicode_ci DEFAULT NULL,
  `watchdog_enabled` tinyint(1) DEFAULT NULL,
  `watchdog_log` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `poller_cluster_node_id_unique` (`node_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `poller_cluster_stats` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_poller` int(10) unsigned NOT NULL DEFAULT 0,
  `poller_type` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `depth` int(10) unsigned NOT NULL,
  `devices` int(10) unsigned NOT NULL,
  `worker_seconds` double unsigned NOT NULL,
  `workers` int(10) unsigned NOT NULL,
  `frequency` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `poller_cluster_stats_parent_poller_poller_type_unique` (`parent_poller`,`poller_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `poller_groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `group_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `descr` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pollers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `poller_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_polled` datetime NOT NULL,
  `devices` int(10) unsigned NOT NULL,
  `time_taken` double NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pollers_poller_name_unique` (`poller_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ports` (
  `port_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `device_id` int(10) unsigned NOT NULL DEFAULT 0,
  `port_descr_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `port_descr_descr` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `port_descr_circuit` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `port_descr_speed` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `port_descr_notes` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ifDescr` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ifName` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `portName` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ifIndex` bigint(20) DEFAULT 0,
  `ifSpeed` bigint(20) DEFAULT NULL,
  `ifSpeed_prev` bigint(20) DEFAULT NULL,
  `ifConnectorPresent` varchar(12) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ifPromiscuousMode` varchar(12) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ifHighSpeed` int(11) DEFAULT NULL,
  `ifHighSpeed_prev` int(11) DEFAULT NULL,
  `ifOperStatus` varchar(16) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ifOperStatus_prev` varchar(16) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ifAdminStatus` varchar(16) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ifAdminStatus_prev` varchar(16) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ifDuplex` varchar(12) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ifMtu` int(11) DEFAULT NULL,
  `ifType` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `ifAlias` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `ifPhysAddress` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `ifHardType` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ifLastChange` bigint(20) unsigned NOT NULL DEFAULT 0,
  `ifVlan` varchar(8) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `ifTrunk` varchar(16) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ifVrf` int(11) NOT NULL DEFAULT 0,
  `counter_in` int(11) DEFAULT NULL,
  `counter_out` int(11) DEFAULT NULL,
  `ignore` tinyint(1) NOT NULL DEFAULT 0,
  `disabled` tinyint(1) NOT NULL DEFAULT 0,
  `detailed` tinyint(1) NOT NULL DEFAULT 0,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `pagpOperationMode` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pagpPortState` varchar(16) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pagpPartnerDeviceId` varchar(48) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pagpPartnerLearnMethod` varchar(16) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pagpPartnerIfIndex` int(11) DEFAULT NULL,
  `pagpPartnerGroupIfIndex` int(11) DEFAULT NULL,
  `pagpPartnerDeviceName` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pagpEthcOperationMode` varchar(16) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pagpDeviceId` varchar(48) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pagpGroupIfIndex` int(11) DEFAULT NULL,
  `ifInUcastPkts` bigint(20) unsigned DEFAULT NULL,
  `ifInUcastPkts_prev` bigint(20) unsigned DEFAULT NULL,
  `ifInUcastPkts_delta` bigint(20) unsigned DEFAULT NULL,
  `ifInUcastPkts_rate` bigint(20) unsigned DEFAULT NULL,
  `ifOutUcastPkts` bigint(20) unsigned DEFAULT NULL,
  `ifOutUcastPkts_prev` bigint(20) unsigned DEFAULT NULL,
  `ifOutUcastPkts_delta` bigint(20) unsigned DEFAULT NULL,
  `ifOutUcastPkts_rate` bigint(20) unsigned DEFAULT NULL,
  `ifInErrors` bigint(20) unsigned DEFAULT NULL,
  `ifInErrors_prev` bigint(20) unsigned DEFAULT NULL,
  `ifInErrors_delta` bigint(20) unsigned DEFAULT NULL,
  `ifInErrors_rate` bigint(20) unsigned DEFAULT NULL,
  `ifOutErrors` bigint(20) unsigned DEFAULT NULL,
  `ifOutErrors_prev` bigint(20) unsigned DEFAULT NULL,
  `ifOutErrors_delta` bigint(20) unsigned DEFAULT NULL,
  `ifOutErrors_rate` bigint(20) unsigned DEFAULT NULL,
  `ifInOctets` bigint(20) unsigned DEFAULT NULL,
  `ifInOctets_prev` bigint(20) unsigned DEFAULT NULL,
  `ifInOctets_delta` bigint(20) unsigned DEFAULT NULL,
  `ifInOctets_rate` bigint(20) unsigned DEFAULT NULL,
  `ifOutOctets` bigint(20) unsigned DEFAULT NULL,
  `ifOutOctets_prev` bigint(20) unsigned DEFAULT NULL,
  `ifOutOctets_delta` bigint(20) unsigned DEFAULT NULL,
  `ifOutOctets_rate` bigint(20) unsigned DEFAULT NULL,
  `poll_time` int(10) unsigned DEFAULT NULL,
  `poll_prev` int(10) unsigned DEFAULT NULL,
  `poll_period` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`port_id`),
  UNIQUE KEY `ports_device_id_ifindex_unique` (`device_id`,`ifIndex`),
  KEY `ports_ifdescr_index` (`ifDescr`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ports_adsl` (
  `port_id` int(10) unsigned NOT NULL,
  `port_adsl_updated` timestamp NOT NULL DEFAULT current_timestamp(),
  `adslLineCoding` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `adslLineType` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `adslAtucInvVendorID` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `adslAtucInvVersionNumber` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `adslAtucCurrSnrMgn` decimal(5,1) NOT NULL,
  `adslAtucCurrAtn` decimal(5,1) NOT NULL,
  `adslAtucCurrOutputPwr` decimal(5,1) NOT NULL,
  `adslAtucCurrAttainableRate` int(11) NOT NULL,
  `adslAtucChanCurrTxRate` int(11) NOT NULL,
  `adslAturInvSerialNumber` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `adslAturInvVendorID` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `adslAturInvVersionNumber` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `adslAturChanCurrTxRate` int(11) NOT NULL,
  `adslAturCurrSnrMgn` decimal(5,1) NOT NULL,
  `adslAturCurrAtn` decimal(5,1) NOT NULL,
  `adslAturCurrOutputPwr` decimal(5,1) NOT NULL,
  `adslAturCurrAttainableRate` int(11) NOT NULL,
  UNIQUE KEY `ports_adsl_port_id_unique` (`port_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ports_fdb` (
  `ports_fdb_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `port_id` int(10) unsigned NOT NULL,
  `mac_address` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `vlan_id` int(10) unsigned NOT NULL,
  `device_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`ports_fdb_id`),
  KEY `ports_fdb_port_id_index` (`port_id`),
  KEY `ports_fdb_mac_address_index` (`mac_address`),
  KEY `ports_fdb_vlan_id_index` (`vlan_id`),
  KEY `ports_fdb_device_id_index` (`device_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ports_nac` (
  `ports_nac_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `auth_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `device_id` int(10) unsigned NOT NULL,
  `port_id` int(10) unsigned NOT NULL,
  `domain` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `mac_address` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `ip_address` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `host_mode` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `authz_status` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `authz_by` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `authc_status` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `method` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `timeout` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `time_left` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `vlan` int(10) unsigned DEFAULT NULL,
  `time_elapsed` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`ports_nac_id`),
  KEY `ports_nac_port_id_mac_address_index` (`port_id`,`mac_address`),
  KEY `ports_nac_device_id_index` (`device_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ports_perms` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `port_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ports_stack` (
  `device_id` int(10) unsigned NOT NULL,
  `port_id_high` int(10) unsigned NOT NULL,
  `port_id_low` int(10) unsigned NOT NULL,
  `ifStackStatus` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  UNIQUE KEY `ports_stack_device_id_port_id_high_port_id_low_unique` (`device_id`,`port_id_high`,`port_id_low`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ports_statistics` (
  `port_id` int(10) unsigned NOT NULL,
  `ifInNUcastPkts` bigint(20) DEFAULT NULL,
  `ifInNUcastPkts_prev` bigint(20) DEFAULT NULL,
  `ifInNUcastPkts_delta` bigint(20) DEFAULT NULL,
  `ifInNUcastPkts_rate` int(11) DEFAULT NULL,
  `ifOutNUcastPkts` bigint(20) DEFAULT NULL,
  `ifOutNUcastPkts_prev` bigint(20) DEFAULT NULL,
  `ifOutNUcastPkts_delta` bigint(20) DEFAULT NULL,
  `ifOutNUcastPkts_rate` int(11) DEFAULT NULL,
  `ifInDiscards` bigint(20) DEFAULT NULL,
  `ifInDiscards_prev` bigint(20) DEFAULT NULL,
  `ifInDiscards_delta` bigint(20) DEFAULT NULL,
  `ifInDiscards_rate` int(11) DEFAULT NULL,
  `ifOutDiscards` bigint(20) DEFAULT NULL,
  `ifOutDiscards_prev` bigint(20) DEFAULT NULL,
  `ifOutDiscards_delta` bigint(20) DEFAULT NULL,
  `ifOutDiscards_rate` int(11) DEFAULT NULL,
  `ifInUnknownProtos` bigint(20) DEFAULT NULL,
  `ifInUnknownProtos_prev` bigint(20) DEFAULT NULL,
  `ifInUnknownProtos_delta` bigint(20) DEFAULT NULL,
  `ifInUnknownProtos_rate` int(11) DEFAULT NULL,
  `ifInBroadcastPkts` bigint(20) DEFAULT NULL,
  `ifInBroadcastPkts_prev` bigint(20) DEFAULT NULL,
  `ifInBroadcastPkts_delta` bigint(20) DEFAULT NULL,
  `ifInBroadcastPkts_rate` int(11) DEFAULT NULL,
  `ifOutBroadcastPkts` bigint(20) DEFAULT NULL,
  `ifOutBroadcastPkts_prev` bigint(20) DEFAULT NULL,
  `ifOutBroadcastPkts_delta` bigint(20) DEFAULT NULL,
  `ifOutBroadcastPkts_rate` int(11) DEFAULT NULL,
  `ifInMulticastPkts` bigint(20) DEFAULT NULL,
  `ifInMulticastPkts_prev` bigint(20) DEFAULT NULL,
  `ifInMulticastPkts_delta` bigint(20) DEFAULT NULL,
  `ifInMulticastPkts_rate` int(11) DEFAULT NULL,
  `ifOutMulticastPkts` bigint(20) DEFAULT NULL,
  `ifOutMulticastPkts_prev` bigint(20) DEFAULT NULL,
  `ifOutMulticastPkts_delta` bigint(20) DEFAULT NULL,
  `ifOutMulticastPkts_rate` int(11) DEFAULT NULL,
  PRIMARY KEY (`port_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ports_stp` (
  `port_stp_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `device_id` int(10) unsigned NOT NULL,
  `port_id` int(10) unsigned NOT NULL,
  `priority` tinyint(3) unsigned NOT NULL,
  `state` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `enable` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `pathCost` int(10) unsigned NOT NULL,
  `designatedRoot` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `designatedCost` smallint(5) unsigned NOT NULL,
  `designatedBridge` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `designatedPort` mediumint(9) NOT NULL,
  `forwardTransitions` int(10) unsigned NOT NULL,
  PRIMARY KEY (`port_stp_id`),
  UNIQUE KEY `ports_stp_device_id_port_id_unique` (`device_id`,`port_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ports_vlans` (
  `port_vlan_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `device_id` int(10) unsigned NOT NULL,
  `port_id` int(10) unsigned NOT NULL,
  `vlan` int(11) NOT NULL,
  `baseport` int(11) NOT NULL,
  `priority` bigint(20) NOT NULL,
  `state` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `cost` int(11) NOT NULL,
  `untagged` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`port_vlan_id`),
  UNIQUE KEY `ports_vlans_device_id_port_id_vlan_unique` (`device_id`,`port_id`,`vlan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `processes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `device_id` int(10) unsigned NOT NULL,
  `pid` int(11) NOT NULL,
  `vsz` int(11) NOT NULL,
  `rss` int(11) NOT NULL,
  `cputime` varchar(12) COLLATE utf8_unicode_ci NOT NULL,
  `user` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `command` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `processes_device_id_index` (`device_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `processors` (
  `processor_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `entPhysicalIndex` int(11) NOT NULL DEFAULT 0,
  `hrDeviceIndex` int(11) DEFAULT NULL,
  `device_id` int(10) unsigned NOT NULL,
  `processor_oid` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `processor_index` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `processor_type` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `processor_usage` int(11) NOT NULL,
  `processor_descr` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `processor_precision` int(11) NOT NULL DEFAULT 1,
  `processor_perc_warn` int(11) DEFAULT 75,
  PRIMARY KEY (`processor_id`),
  KEY `processors_device_id_index` (`device_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `proxmox` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `device_id` int(10) unsigned NOT NULL DEFAULT 0,
  `vmid` int(11) NOT NULL,
  `cluster` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_seen` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `proxmox_cluster_vmid_unique` (`cluster`,`vmid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `proxmox_ports` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `vm_id` int(11) NOT NULL,
  `port` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `last_seen` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `proxmox_ports_vm_id_port_unique` (`vm_id`,`port`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pseudowires` (
  `pseudowire_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `device_id` int(10) unsigned NOT NULL,
  `port_id` int(10) unsigned NOT NULL,
  `peer_device_id` int(10) unsigned NOT NULL,
  `peer_ldp_id` int(11) NOT NULL,
  `cpwVcID` int(11) NOT NULL,
  `cpwOid` int(11) NOT NULL,
  `pw_type` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `pw_psntype` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `pw_local_mtu` int(11) NOT NULL,
  `pw_peer_mtu` int(11) NOT NULL,
  `pw_descr` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`pseudowire_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `route` (
  `route_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `device_id` int(10) unsigned NOT NULL,
  `port_id` int(10) unsigned NOT NULL,
  `context_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `inetCidrRouteIfIndex` bigint(20) NOT NULL,
  `inetCidrRouteType` int(10) unsigned NOT NULL,
  `inetCidrRouteProto` int(10) unsigned NOT NULL,
  `inetCidrRouteNextHopAS` int(10) unsigned NOT NULL,
  `inetCidrRouteMetric1` int(10) unsigned NOT NULL,
  `inetCidrRouteDestType` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `inetCidrRouteDest` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `inetCidrRouteNextHopType` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `inetCidrRouteNextHop` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `inetCidrRoutePolicy` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `inetCidrRoutePfxLen` int(10) unsigned NOT NULL,
  PRIMARY KEY (`route_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sensors` (
  `sensor_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sensor_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `sensor_class` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `device_id` int(10) unsigned NOT NULL DEFAULT 0,
  `poller_type` varchar(16) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'snmp',
  `sensor_oid` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sensor_index` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sensor_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sensor_descr` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `group` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sensor_divisor` bigint(20) NOT NULL DEFAULT 1,
  `sensor_multiplier` int(11) NOT NULL DEFAULT 1,
  `sensor_current` double DEFAULT NULL,
  `sensor_limit` double DEFAULT NULL,
  `sensor_limit_warn` double DEFAULT NULL,
  `sensor_limit_low` double DEFAULT NULL,
  `sensor_limit_low_warn` double DEFAULT NULL,
  `sensor_alert` tinyint(1) NOT NULL DEFAULT 1,
  `sensor_custom` enum('No','Yes') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'No',
  `entPhysicalIndex` varchar(16) COLLATE utf8_unicode_ci DEFAULT NULL,
  `entPhysicalIndex_measured` varchar(16) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lastupdate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `sensor_prev` double DEFAULT NULL,
  `user_func` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`sensor_id`),
  KEY `sensors_sensor_class_index` (`sensor_class`),
  KEY `sensors_device_id_index` (`device_id`),
  KEY `sensors_sensor_type_index` (`sensor_type`),
  CONSTRAINT `sensors_device_id_foreign` FOREIGN KEY (`device_id`) REFERENCES `devices` (`device_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sensors_to_state_indexes` (
  `sensors_to_state_translations_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sensor_id` int(10) unsigned NOT NULL,
  `state_index_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`sensors_to_state_translations_id`),
  UNIQUE KEY `sensors_to_state_indexes_sensor_id_state_index_id_unique` (`sensor_id`,`state_index_id`),
  KEY `sensors_to_state_indexes_state_index_id_index` (`state_index_id`),
  CONSTRAINT `sensors_to_state_indexes_ibfk_1` FOREIGN KEY (`state_index_id`) REFERENCES `state_indexes` (`state_index_id`),
  CONSTRAINT `sensors_to_state_indexes_sensor_id_foreign` FOREIGN KEY (`sensor_id`) REFERENCES `sensors` (`sensor_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `services` (
  `service_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `device_id` int(10) unsigned NOT NULL,
  `service_ip` text COLLATE utf8_unicode_ci NOT NULL,
  `service_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `service_desc` text COLLATE utf8_unicode_ci NOT NULL,
  `service_param` text COLLATE utf8_unicode_ci NOT NULL,
  `service_ignore` tinyint(1) NOT NULL,
  `service_status` tinyint(4) NOT NULL DEFAULT 0,
  `service_changed` int(10) unsigned NOT NULL DEFAULT 0,
  `service_message` text COLLATE utf8_unicode_ci NOT NULL,
  `service_disabled` tinyint(1) NOT NULL DEFAULT 0,
  `service_ds` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`service_id`),
  KEY `services_device_id_index` (`device_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `session` (
  `session_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `session_username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `session_value` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `session_token` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `session_auth` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `session_expiry` int(11) NOT NULL,
  PRIMARY KEY (`session_id`),
  UNIQUE KEY `session_session_value_unique` (`session_value`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `slas` (
  `sla_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `device_id` int(10) unsigned NOT NULL,
  `sla_nr` int(11) NOT NULL,
  `owner` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tag` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `rtt_type` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `opstatus` tinyint(1) NOT NULL DEFAULT 0,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`sla_id`),
  UNIQUE KEY `slas_device_id_sla_nr_unique` (`device_id`,`sla_nr`),
  KEY `slas_device_id_index` (`device_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `state_indexes` (
  `state_index_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `state_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`state_index_id`),
  UNIQUE KEY `state_indexes_state_name_unique` (`state_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `state_translations` (
  `state_translation_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `state_index_id` int(10) unsigned NOT NULL,
  `state_descr` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `state_draw_graph` tinyint(1) NOT NULL,
  `state_value` smallint(6) NOT NULL DEFAULT 0,
  `state_generic_value` tinyint(1) NOT NULL,
  `state_lastupdated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`state_translation_id`),
  UNIQUE KEY `state_translations_state_index_id_state_value_unique` (`state_index_id`,`state_value`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `storage` (
  `storage_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `device_id` int(10) unsigned NOT NULL,
  `storage_mib` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `storage_index` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `storage_type` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `storage_descr` text COLLATE utf8_unicode_ci NOT NULL,
  `storage_size` bigint(20) NOT NULL,
  `storage_units` int(11) NOT NULL,
  `storage_used` bigint(20) NOT NULL DEFAULT 0,
  `storage_free` bigint(20) NOT NULL DEFAULT 0,
  `storage_perc` int(11) NOT NULL DEFAULT 0,
  `storage_perc_warn` int(11) DEFAULT 60,
  `storage_deleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`storage_id`),
  UNIQUE KEY `storage_device_id_storage_mib_storage_index_unique` (`device_id`,`storage_mib`,`storage_index`),
  KEY `storage_device_id_index` (`device_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stp` (
  `stp_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `device_id` int(10) unsigned NOT NULL,
  `rootBridge` tinyint(1) NOT NULL,
  `bridgeAddress` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `protocolSpecification` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `priority` mediumint(9) NOT NULL,
  `timeSinceTopologyChange` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `topChanges` mediumint(9) NOT NULL,
  `designatedRoot` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `rootCost` mediumint(9) NOT NULL,
  `rootPort` int(11) DEFAULT NULL,
  `maxAge` mediumint(9) NOT NULL,
  `helloTime` mediumint(9) NOT NULL,
  `holdTime` mediumint(9) NOT NULL,
  `forwardDelay` mediumint(9) NOT NULL,
  `bridgeMaxAge` smallint(6) NOT NULL,
  `bridgeHelloTime` smallint(6) NOT NULL,
  `bridgeForwardDelay` smallint(6) NOT NULL,
  PRIMARY KEY (`stp_id`),
  KEY `stp_device_id_index` (`device_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `syslog` (
  `device_id` int(10) unsigned DEFAULT NULL,
  `facility` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `priority` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `level` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tag` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `program` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `msg` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `seq` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`seq`),
  KEY `syslog_priority_level_index` (`priority`,`level`),
  KEY `syslog_device_id_timestamp_index` (`device_id`,`timestamp`),
  KEY `syslog_device_id_index` (`device_id`),
  KEY `syslog_timestamp_index` (`timestamp`),
  KEY `syslog_program_index` (`program`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tnmsneinfo` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `device_id` int(10) unsigned NOT NULL,
  `neID` int(11) NOT NULL,
  `neType` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `neName` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `neLocation` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `neAlarm` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `neOpMode` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `neOpState` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tnmsneinfo_device_id_index` (`device_id`),
  KEY `tnmsneinfo_neid_index` (`neID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `toner` (
  `toner_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `device_id` int(10) unsigned NOT NULL DEFAULT 0,
  `toner_index` int(11) NOT NULL,
  `toner_type` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `toner_oid` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `toner_descr` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `toner_capacity` int(11) NOT NULL DEFAULT 0,
  `toner_current` int(11) NOT NULL DEFAULT 0,
  `toner_capacity_oid` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`toner_id`),
  KEY `toner_device_id_index` (`device_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transport_group_transport` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `transport_group_id` int(10) unsigned NOT NULL,
  `transport_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ucd_diskio` (
  `diskio_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `device_id` int(10) unsigned NOT NULL,
  `diskio_index` int(11) NOT NULL,
  `diskio_descr` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`diskio_id`),
  KEY `ucd_diskio_device_id_index` (`device_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `auth_type` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `auth_id` int(11) DEFAULT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `realname` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `descr` char(30) COLLATE utf8_unicode_ci NOT NULL,
  `level` tinyint(4) NOT NULL DEFAULT 0,
  `can_modify_passwd` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT '1970-01-02 06:00:01',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `users_auth_type_username_unique` (`auth_type`,`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users_prefs` (
  `user_id` int(10) unsigned NOT NULL,
  `pref` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  UNIQUE KEY `users_prefs_user_id_pref_unique` (`user_id`,`pref`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users_widgets` (
  `user_widget_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `widget_id` int(10) unsigned NOT NULL,
  `col` tinyint(4) NOT NULL,
  `row` tinyint(4) NOT NULL,
  `size_x` tinyint(4) NOT NULL,
  `size_y` tinyint(4) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `refresh` tinyint(4) NOT NULL DEFAULT 60,
  `settings` text COLLATE utf8_unicode_ci NOT NULL,
  `dashboard_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_widget_id`),
  KEY `user_id` (`user_id`,`widget_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vlans` (
  `vlan_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `device_id` int(10) unsigned DEFAULT NULL,
  `vlan_vlan` int(11) DEFAULT NULL,
  `vlan_domain` int(11) DEFAULT NULL,
  `vlan_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `vlan_type` varchar(16) COLLATE utf8_unicode_ci DEFAULT NULL,
  `vlan_mtu` int(11) DEFAULT NULL,
  PRIMARY KEY (`vlan_id`),
  KEY `device_id` (`device_id`,`vlan_vlan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vminfo` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `device_id` int(10) unsigned NOT NULL,
  `vm_type` varchar(16) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'vmware',
  `vmwVmVMID` int(11) NOT NULL,
  `vmwVmDisplayName` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `vmwVmGuestOS` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `vmwVmMemSize` int(11) NOT NULL,
  `vmwVmCpus` int(11) NOT NULL,
  `vmwVmState` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `vminfo_device_id_index` (`device_id`),
  KEY `vminfo_vmwvmvmid_index` (`vmwVmVMID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vrf_lite_cisco` (
  `vrf_lite_cisco_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `device_id` int(10) unsigned NOT NULL,
  `context_name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `intance_name` varchar(128) COLLATE utf8_unicode_ci DEFAULT '',
  `vrf_name` varchar(128) COLLATE utf8_unicode_ci DEFAULT 'Default',
  PRIMARY KEY (`vrf_lite_cisco_id`),
  KEY `vrf_lite_cisco_device_id_context_name_vrf_name_index` (`device_id`,`context_name`,`vrf_name`),
  KEY `vrf_lite_cisco_device_id_index` (`device_id`),
  KEY `vrf_lite_cisco_context_name_index` (`context_name`),
  KEY `vrf_lite_cisco_vrf_name_index` (`vrf_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vrfs` (
  `vrf_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `vrf_oid` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `vrf_name` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bgpLocalAs` int(10) unsigned DEFAULT NULL,
  `mplsVpnVrfRouteDistinguisher` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mplsVpnVrfDescription` text COLLATE utf8_unicode_ci NOT NULL,
  `device_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`vrf_id`),
  KEY `vrfs_device_id_index` (`device_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `widgets` (
  `widget_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `widget_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `widget` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `base_dimensions` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`widget_id`),
  UNIQUE KEY `widgets_widget_unique` (`widget`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wireless_sensors` (
  `sensor_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sensor_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `sensor_class` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `device_id` int(10) unsigned NOT NULL DEFAULT 0,
  `sensor_index` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sensor_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sensor_descr` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sensor_divisor` int(11) NOT NULL DEFAULT 1,
  `sensor_multiplier` int(11) NOT NULL DEFAULT 1,
  `sensor_aggregator` varchar(16) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'sum',
  `sensor_current` double DEFAULT NULL,
  `sensor_prev` double DEFAULT NULL,
  `sensor_limit` double DEFAULT NULL,
  `sensor_limit_warn` double DEFAULT NULL,
  `sensor_limit_low` double DEFAULT NULL,
  `sensor_limit_low_warn` double DEFAULT NULL,
  `sensor_alert` tinyint(1) NOT NULL DEFAULT 1,
  `sensor_custom` enum('No','Yes') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'No',
  `entPhysicalIndex` varchar(16) COLLATE utf8_unicode_ci DEFAULT NULL,
  `entPhysicalIndex_measured` varchar(16) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lastupdate` timestamp NOT NULL DEFAULT current_timestamp(),
  `sensor_oids` text COLLATE utf8_unicode_ci NOT NULL,
  `access_point_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`sensor_id`),
  KEY `wireless_sensors_sensor_class_index` (`sensor_class`),
  KEY `wireless_sensors_device_id_index` (`device_id`),
  KEY `wireless_sensors_sensor_type_index` (`sensor_type`),
  CONSTRAINT `wireless_sensors_device_id_foreign` FOREIGN KEY (`device_id`) REFERENCES `devices` (`device_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

INSERT INTO `migrations` VALUES (165,'2018_07_03_091314_create_access_points_table',1);
INSERT INTO `migrations` VALUES (166,'2018_07_03_091314_create_alert_device_map_table',1);
INSERT INTO `migrations` VALUES (167,'2018_07_03_091314_create_alert_group_map_table',1);
INSERT INTO `migrations` VALUES (168,'2018_07_03_091314_create_alert_log_table',1);
INSERT INTO `migrations` VALUES (169,'2018_07_03_091314_create_alert_rules_table',1);
INSERT INTO `migrations` VALUES (170,'2018_07_03_091314_create_alert_schedulables_table',1);
INSERT INTO `migrations` VALUES (171,'2018_07_03_091314_create_alert_schedule_table',1);
INSERT INTO `migrations` VALUES (172,'2018_07_03_091314_create_alert_template_map_table',1);
INSERT INTO `migrations` VALUES (173,'2018_07_03_091314_create_alert_templates_table',1);
INSERT INTO `migrations` VALUES (174,'2018_07_03_091314_create_alert_transport_groups_table',1);
INSERT INTO `migrations` VALUES (175,'2018_07_03_091314_create_alert_transport_map_table',1);
INSERT INTO `migrations` VALUES (176,'2018_07_03_091314_create_alert_transports_table',1);
INSERT INTO `migrations` VALUES (177,'2018_07_03_091314_create_alerts_table',1);
INSERT INTO `migrations` VALUES (178,'2018_07_03_091314_create_api_tokens_table',1);
INSERT INTO `migrations` VALUES (179,'2018_07_03_091314_create_application_metrics_table',1);
INSERT INTO `migrations` VALUES (180,'2018_07_03_091314_create_applications_table',1);
INSERT INTO `migrations` VALUES (181,'2018_07_03_091314_create_authlog_table',1);
INSERT INTO `migrations` VALUES (182,'2018_07_03_091314_create_bgpPeers_cbgp_table',1);
INSERT INTO `migrations` VALUES (183,'2018_07_03_091314_create_bgpPeers_table',1);
INSERT INTO `migrations` VALUES (184,'2018_07_03_091314_create_bill_data_table',1);
INSERT INTO `migrations` VALUES (185,'2018_07_03_091314_create_bill_history_table',1);
INSERT INTO `migrations` VALUES (186,'2018_07_03_091314_create_bill_perms_table',1);
INSERT INTO `migrations` VALUES (187,'2018_07_03_091314_create_bill_port_counters_table',1);
INSERT INTO `migrations` VALUES (188,'2018_07_03_091314_create_bill_ports_table',1);
INSERT INTO `migrations` VALUES (189,'2018_07_03_091314_create_bills_table',1);
INSERT INTO `migrations` VALUES (190,'2018_07_03_091314_create_callback_table',1);
INSERT INTO `migrations` VALUES (191,'2018_07_03_091314_create_cef_switching_table',1);
INSERT INTO `migrations` VALUES (192,'2018_07_03_091314_create_ciscoASA_table',1);
INSERT INTO `migrations` VALUES (193,'2018_07_03_091314_create_component_prefs_table',1);
INSERT INTO `migrations` VALUES (194,'2018_07_03_091314_create_component_statuslog_table',1);
INSERT INTO `migrations` VALUES (195,'2018_07_03_091314_create_component_table',1);
INSERT INTO `migrations` VALUES (196,'2018_07_03_091314_create_config_table',1);
INSERT INTO `migrations` VALUES (197,'2018_07_03_091314_create_customers_table',1);
INSERT INTO `migrations` VALUES (198,'2018_07_03_091314_create_dashboards_table',1);
INSERT INTO `migrations` VALUES (199,'2018_07_03_091314_create_dbSchema_table',1);
INSERT INTO `migrations` VALUES (200,'2018_07_03_091314_create_device_graphs_table',1);
INSERT INTO `migrations` VALUES (201,'2018_07_03_091314_create_device_group_device_table',1);
INSERT INTO `migrations` VALUES (202,'2018_07_03_091314_create_device_groups_table',1);
INSERT INTO `migrations` VALUES (203,'2018_07_03_091314_create_device_mibs_table',1);
INSERT INTO `migrations` VALUES (204,'2018_07_03_091314_create_device_oids_table',1);
INSERT INTO `migrations` VALUES (205,'2018_07_03_091314_create_device_perf_table',1);
INSERT INTO `migrations` VALUES (206,'2018_07_03_091314_create_device_relationships_table',1);
INSERT INTO `migrations` VALUES (207,'2018_07_03_091314_create_devices_attribs_table',1);
INSERT INTO `migrations` VALUES (208,'2018_07_03_091314_create_devices_perms_table',1);
INSERT INTO `migrations` VALUES (209,'2018_07_03_091314_create_devices_table',1);
INSERT INTO `migrations` VALUES (210,'2018_07_03_091314_create_entPhysical_state_table',1);
INSERT INTO `migrations` VALUES (211,'2018_07_03_091314_create_entPhysical_table',1);
INSERT INTO `migrations` VALUES (212,'2018_07_03_091314_create_entityState_table',1);
INSERT INTO `migrations` VALUES (213,'2018_07_03_091314_create_eventlog_table',1);
INSERT INTO `migrations` VALUES (214,'2018_07_03_091314_create_graph_types_table',1);
INSERT INTO `migrations` VALUES (215,'2018_07_03_091314_create_hrDevice_table',1);
INSERT INTO `migrations` VALUES (216,'2018_07_03_091314_create_ipsec_tunnels_table',1);
INSERT INTO `migrations` VALUES (217,'2018_07_03_091314_create_ipv4_addresses_table',1);
INSERT INTO `migrations` VALUES (218,'2018_07_03_091314_create_ipv4_mac_table',1);
INSERT INTO `migrations` VALUES (219,'2018_07_03_091314_create_ipv4_networks_table',1);
INSERT INTO `migrations` VALUES (220,'2018_07_03_091314_create_ipv6_addresses_table',1);
INSERT INTO `migrations` VALUES (221,'2018_07_03_091314_create_ipv6_networks_table',1);
INSERT INTO `migrations` VALUES (222,'2018_07_03_091314_create_juniAtmVp_table',1);
INSERT INTO `migrations` VALUES (223,'2018_07_03_091314_create_links_table',1);
INSERT INTO `migrations` VALUES (224,'2018_07_03_091314_create_loadbalancer_rservers_table',1);
INSERT INTO `migrations` VALUES (225,'2018_07_03_091314_create_loadbalancer_vservers_table',1);
INSERT INTO `migrations` VALUES (226,'2018_07_03_091314_create_locations_table',1);
INSERT INTO `migrations` VALUES (227,'2018_07_03_091314_create_mac_accounting_table',1);
INSERT INTO `migrations` VALUES (228,'2018_07_03_091314_create_mefinfo_table',1);
INSERT INTO `migrations` VALUES (229,'2018_07_03_091314_create_mempools_table',1);
INSERT INTO `migrations` VALUES (230,'2018_07_03_091314_create_mibdefs_table',1);
INSERT INTO `migrations` VALUES (231,'2018_07_03_091314_create_munin_plugins_ds_table',1);
INSERT INTO `migrations` VALUES (232,'2018_07_03_091314_create_munin_plugins_table',1);
INSERT INTO `migrations` VALUES (233,'2018_07_03_091314_create_netscaler_vservers_table',1);
INSERT INTO `migrations` VALUES (234,'2018_07_03_091314_create_notifications_attribs_table',1);
INSERT INTO `migrations` VALUES (235,'2018_07_03_091314_create_notifications_table',1);
INSERT INTO `migrations` VALUES (236,'2018_07_03_091314_create_ospf_areas_table',1);
INSERT INTO `migrations` VALUES (237,'2018_07_03_091314_create_ospf_instances_table',1);
INSERT INTO `migrations` VALUES (238,'2018_07_03_091314_create_ospf_nbrs_table',1);
INSERT INTO `migrations` VALUES (239,'2018_07_03_091314_create_ospf_ports_table',1);
INSERT INTO `migrations` VALUES (240,'2018_07_03_091314_create_packages_table',1);
INSERT INTO `migrations` VALUES (241,'2018_07_03_091314_create_pdb_ix_peers_table',1);
INSERT INTO `migrations` VALUES (242,'2018_07_03_091314_create_pdb_ix_table',1);
INSERT INTO `migrations` VALUES (243,'2018_07_03_091314_create_perf_times_table',1);
INSERT INTO `migrations` VALUES (244,'2018_07_03_091314_create_plugins_table',1);
INSERT INTO `migrations` VALUES (245,'2018_07_03_091314_create_poller_cluster_stats_table',1);
INSERT INTO `migrations` VALUES (246,'2018_07_03_091314_create_poller_cluster_table',1);
INSERT INTO `migrations` VALUES (247,'2018_07_03_091314_create_poller_groups_table',1);
INSERT INTO `migrations` VALUES (248,'2018_07_03_091314_create_pollers_table',1);
INSERT INTO `migrations` VALUES (249,'2018_07_03_091314_create_ports_adsl_table',1);
INSERT INTO `migrations` VALUES (250,'2018_07_03_091314_create_ports_fdb_table',1);
INSERT INTO `migrations` VALUES (251,'2018_07_03_091314_create_ports_nac_table',1);
INSERT INTO `migrations` VALUES (252,'2018_07_03_091314_create_ports_perms_table',1);
INSERT INTO `migrations` VALUES (253,'2018_07_03_091314_create_ports_stack_table',1);
INSERT INTO `migrations` VALUES (254,'2018_07_03_091314_create_ports_statistics_table',1);
INSERT INTO `migrations` VALUES (255,'2018_07_03_091314_create_ports_stp_table',1);
INSERT INTO `migrations` VALUES (256,'2018_07_03_091314_create_ports_table',1);
INSERT INTO `migrations` VALUES (257,'2018_07_03_091314_create_ports_vlans_table',1);
INSERT INTO `migrations` VALUES (258,'2018_07_03_091314_create_processes_table',1);
INSERT INTO `migrations` VALUES (259,'2018_07_03_091314_create_processors_table',1);
INSERT INTO `migrations` VALUES (260,'2018_07_03_091314_create_proxmox_ports_table',1);
INSERT INTO `migrations` VALUES (261,'2018_07_03_091314_create_proxmox_table',1);
INSERT INTO `migrations` VALUES (262,'2018_07_03_091314_create_pseudowires_table',1);
INSERT INTO `migrations` VALUES (263,'2018_07_03_091314_create_route_table',1);
INSERT INTO `migrations` VALUES (264,'2018_07_03_091314_create_sensors_table',1);
INSERT INTO `migrations` VALUES (265,'2018_07_03_091314_create_sensors_to_state_indexes_table',1);
INSERT INTO `migrations` VALUES (266,'2018_07_03_091314_create_services_table',1);
INSERT INTO `migrations` VALUES (267,'2018_07_03_091314_create_session_table',1);
INSERT INTO `migrations` VALUES (268,'2018_07_03_091314_create_slas_table',1);
INSERT INTO `migrations` VALUES (269,'2018_07_03_091314_create_state_indexes_table',1);
INSERT INTO `migrations` VALUES (270,'2018_07_03_091314_create_state_translations_table',1);
INSERT INTO `migrations` VALUES (271,'2018_07_03_091314_create_storage_table',1);
INSERT INTO `migrations` VALUES (272,'2018_07_03_091314_create_stp_table',1);
INSERT INTO `migrations` VALUES (273,'2018_07_03_091314_create_syslog_table',1);
INSERT INTO `migrations` VALUES (274,'2018_07_03_091314_create_tnmsneinfo_table',1);
INSERT INTO `migrations` VALUES (275,'2018_07_03_091314_create_toner_table',1);
INSERT INTO `migrations` VALUES (276,'2018_07_03_091314_create_transport_group_transport_table',1);
INSERT INTO `migrations` VALUES (277,'2018_07_03_091314_create_ucd_diskio_table',1);
INSERT INTO `migrations` VALUES (278,'2018_07_03_091314_create_users_prefs_table',1);
INSERT INTO `migrations` VALUES (279,'2018_07_03_091314_create_users_table',1);
INSERT INTO `migrations` VALUES (280,'2018_07_03_091314_create_users_widgets_table',1);
INSERT INTO `migrations` VALUES (281,'2018_07_03_091314_create_vlans_table',1);
INSERT INTO `migrations` VALUES (282,'2018_07_03_091314_create_vminfo_table',1);
INSERT INTO `migrations` VALUES (283,'2018_07_03_091314_create_vrf_lite_cisco_table',1);
INSERT INTO `migrations` VALUES (284,'2018_07_03_091314_create_vrfs_table',1);
INSERT INTO `migrations` VALUES (285,'2018_07_03_091314_create_widgets_table',1);
INSERT INTO `migrations` VALUES (286,'2018_07_03_091314_create_wireless_sensors_table',1);
INSERT INTO `migrations` VALUES (287,'2018_07_03_091322_add_foreign_keys_to_component_prefs_table',1);
INSERT INTO `migrations` VALUES (288,'2018_07_03_091322_add_foreign_keys_to_component_statuslog_table',1);
INSERT INTO `migrations` VALUES (289,'2018_07_03_091322_add_foreign_keys_to_device_group_device_table',1);
INSERT INTO `migrations` VALUES (290,'2018_07_03_091322_add_foreign_keys_to_device_relationships_table',1);
INSERT INTO `migrations` VALUES (291,'2018_07_03_091322_add_foreign_keys_to_sensors_table',1);
INSERT INTO `migrations` VALUES (292,'2018_07_03_091322_add_foreign_keys_to_sensors_to_state_indexes_table',1);
INSERT INTO `migrations` VALUES (293,'2018_07_03_091322_add_foreign_keys_to_wireless_sensors_table',1);
INSERT INTO `migrations` VALUES (294,'2019_01_16_132200_add_vlan_and_elapsed_to_nac',1);
INSERT INTO `migrations` VALUES (295,'2019_01_16_195644_add_vrf_id_and_bgpLocalAs',1);
INSERT INTO `migrations` VALUES (296,'2019_02_05_140857_remove_config_definition_from_db',1);
INSERT INTO `migrations` VALUES (297,'2019_02_10_220000_add_dates_to_fdb',1);
INSERT INTO `migrations` VALUES (298,'2019_04_22_220000_update_route_table',1);
INSERT INTO `migrations` VALUES (299,'2019_05_12_202407_create_mpls_lsps_table',1);
INSERT INTO `migrations` VALUES (300,'2019_05_12_202408_create_mpls_lsp_paths_table',1);
INSERT INTO `migrations` VALUES (301,'2019_05_30_225937_device_groups_rewrite',1);
INSERT INTO `migrations` VALUES (302,'2019_06_30_190400_create_mpls_sdps_table',1);
INSERT INTO `migrations` VALUES (303,'2019_06_30_190401_create_mpls_sdp_binds_table',1);
INSERT INTO `migrations` VALUES (304,'2019_06_30_190402_create_mpls_services_table',1);
INSERT INTO `migrations` VALUES (305,'2019_07_03_132417_create_mpls_saps_table',1);
INSERT INTO `migrations` VALUES (306,'2019_07_09_150217_update_users_widgets_settings',1);
INSERT INTO `migrations` VALUES (307,'2019_08_10_223200_add_enabled_to_users',1);
INSERT INTO `migrations` VALUES (308,'2019_08_28_105051_fix-template-linefeeds',1);
INSERT INTO `migrations` VALUES (309,'2019_09_05_153524_create_notifications_attribs_index',1);
INSERT INTO `migrations` VALUES (310,'2019_09_29_114433_change_default_mempool_perc_warn_in_mempools_table',1);
INSERT INTO `migrations` VALUES (311,'2019_10_03_211702_serialize_config',1);
INSERT INTO `migrations` VALUES (312,'2019_10_21_105350_devices_group_perms',1);
INSERT INTO `migrations` VALUES (313,'2019_11_30_191013_create_mpls_tunnel_ar_hops_table',1);
INSERT INTO `migrations` VALUES (314,'2019_11_30_191013_create_mpls_tunnel_c_hops_table',1);
INSERT INTO `migrations` VALUES (315,'2019_12_01_165514_add_indexes_to_mpls_lsp_paths_table',1);
INSERT INTO `migrations` VALUES (316,'2019_12_05_164700_alerts_disable_on_update_current_timestamp',1);
INSERT INTO `migrations` VALUES (317,'2019_12_16_140000_create_customoids_table',1);
INSERT INTO `migrations` VALUES (318,'2019_12_17_151314_add_invert_map_to_alert_rules',1);
INSERT INTO `migrations` VALUES (319,'2019_12_28_180000_add_overwrite_ip_to_devices',1);
INSERT INTO `migrations` VALUES (320,'2020_01_09_1300_migrate_devices_attribs_table',1);
INSERT INTO `migrations` VALUES (321,'2020_01_10_075852_alter_mpls_lsp_paths_table',1);
INSERT INTO `migrations` VALUES (322,'2020_02_05_093457_add_inserted_to_devices',1);
INSERT INTO `migrations` VALUES (323,'2020_02_05_224042_device_inserted_null',1);
INSERT INTO `migrations` VALUES (324,'2020_02_10_223323_create_alert_location_map_table',1);
INSERT INTO `migrations` VALUES (325,'2020_03_24_0844_add_primary_key_to_device_graphs',1);
INSERT INTO `migrations` VALUES (326,'2020_03_25_165300_add_column_to_ports',1);
INSERT INTO `migrations` VALUES (327,'2020_04_06_001048_the_great_index_rename',1);
INSERT INTO `migrations` VALUES (328,'2020_04_13_150500_add_last_error_fields_to_bgp_peers',1);
INSERT INTO `migrations` VALUES (329,'2020_04_19_010532_eventlog_sensor_reference_cleanup',1);
INSERT INTO `migrations` VALUES (330,'2020_05_24_212054_poller_cluster_settings',2);
INSERT INTO `migrations` VALUES (332,'2020_04_08_172357_alert_schedule_utc',3);
INSERT INTO `migrations` VALUES (333,'2020_05_22_020303_alter_metric_column',4);
INSERT INTO `migrations` VALUES (334,'2020_06_06_222222_create_device_outages_table',4);
INSERT INTO `migrations` VALUES (335,'2020_06_23_00522_alter_availability_perc_column',4);
INSERT INTO `migrations` VALUES (336,'2020_05_30_162638_remove_mib_polling_tables',5);
INSERT INTO `migrations` VALUES (337,'2020_07_29_143221_add_device_perf_index',6);
INSERT INTO `migrations` VALUES (339,'2020_08_28_212054_drop_uptime_column_outages',7);
INSERT INTO `migrations` VALUES (340,'2020_09_18_223431_create_cache_table',7);
INSERT INTO `migrations` VALUES (341,'2020_09_24_000500_create_cache_locks_table',7);
INSERT INTO `migrations` VALUES (342,'2020_09_22_172321_add_alert_log_index',8);
INSERT INTO `migrations` VALUES (343,'2020_10_03_1000_add_primary_key_bill_perms',9);
INSERT INTO `migrations` VALUES (344,'2020_10_03_1000_add_primary_key_bill_ports',9);
INSERT INTO `migrations` VALUES (345,'2020_10_03_1000_add_primary_key_devices_perms',9);
INSERT INTO `migrations` VALUES (346,'2020_10_03_1000_add_primary_key_entPhysical_state',9);
INSERT INTO `migrations` VALUES (347,'2020_10_03_1000_add_primary_key_ipv4_mac',9);
INSERT INTO `migrations` VALUES (348,'2020_10_03_1000_add_primary_key_juniAtmVp',9);
INSERT INTO `migrations` VALUES (349,'2020_10_03_1000_add_primary_key_loadbalancer_vservers',9);
INSERT INTO `migrations` VALUES (350,'2020_10_03_1000_add_primary_key_ports_perms',9);
INSERT INTO `migrations` VALUES (351,'2020_10_03_1000_add_primary_key_processes',9);
INSERT INTO `migrations` VALUES (352,'2020_10_03_1000_add_primary_key_transport_group_transport',9);
INSERT INTO `migrations` VALUES (353,'2020_10_21_124101_allow_nullable_ospf_columns',10);
INSERT INTO `migrations` VALUES (354,'2020_10_12_095504_mempools_add_oids',11);
INSERT INTO `migrations` VALUES (356,'2020_07_27_00522_alter_authalgo_column',12);
INSERT INTO `migrations` VALUES (357,'2020_07_27_00522_alter_devices_snmp_algo_columns',13);
