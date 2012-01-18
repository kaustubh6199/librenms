ALTER TABLE  `bills` CHANGE  `bill_cdr`  `bill_cdr` BIGINT( 20 ) NULL DEFAULT NULL;
CREATE TABLE IF NOT EXISTS `loadbalancer_rservers` (  `rserver_id` int(11) NOT NULL AUTO_INCREMENT,  `farm_id` varchar(128) CHARACTER SET utf8 NOT NULL,  `device_id` int(11) NOT NULL,  `StateDescr` varchar(64) CHARACTER SET utf8 NOT NULL,  PRIMARY KEY (`rserver_id`)) ENGINE=MyISAM AUTO_INCREMENT=514 DEFAULT CHARSET=utf8
CREATE TABLE IF NOT EXISTS `loadbalancer_vservers` (  `classmap_id` int(11) NOT NULL,  `classmap` varchar(128) NOT NULL,  `serverstate` varchar(64) NOT NULL,  `device_id` int(11) NOT NULL ) ENGINE=MyISAM DEFAULT CHARSET=utf8
ALTER TABLE  `sensors` CHANGE  `sensor_index`  `sensor_index` VARCHAR( 64 );
CREATE TABLE IF NOT EXISTS `netscaler_vservers` (  `vsvr_id` int(11) NOT NULL AUTO_INCREMENT,  `device_id` int(11) NOT NULL,  `vsvr_name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,  `vsvr_ip` varchar(128) COLLATE utf8_unicode_ci NOT NULL,  `vsvr_port` int(8) NOT NULL,  `vsvr_type` varchar(64) COLLATE utf8_unicode_ci NOT NULL,  `vsvr_state` varchar(32) COLLATE utf8_unicode_ci NOT NULL,  `vsvr_clients` int(11) NOT NULL,  `vsvr_server` int(11) NOT NULL,  `vsvr_req_rate` int(11) NOT NULL,  `vsvr_bps_in` int(11) NOT NULL,  `vsvr_bps_out` int(11) NOT NULL,  PRIMARY KEY (`vsvr_id`)) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

