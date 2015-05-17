CREATE TABLE `config` ( `config_id` int(11) NOT NULL AUTO_INCREMENT, `config_name` varchar(255) NOT NULL, `config_value` varchar(512) NOT NULL, `config_default` varchar(512) NOT NULL, `config_type` enum('array','single','multi-array','single-array') NOT NULL DEFAULT 'single', `config_desc` varchar(100) NOT NULL, `config_form` text NOT NULL, `config_group` varchar(50) NOT NULL, `config_group_order` int(11) NOT NULL, `config_sub_group` varchar(50) NOT NULL, `config_sub_group_order` int(11) NOT NULL, `config_hidden` enum('0','1') NOT NULL DEFAULT '0', `config_disabled` enum('0','1') NOT NULL DEFAULT '0', PRIMARY KEY (`config_id`) ENGINE=InnoDB AUTO_INCREMENT=428 DEFAULT CHARSET=latin1;
INSERT INTO `config` VALUES (405,'alert,macros,rule,now','NOW()','NOW()','single-array','Time macro','text:','alerting',100,'macros',10,'0','0'),(406,'alert,macros,rule,past_5m','DATE_SUB(NOW(),INTERVAL 5 MINUTE)','DATE_SUB(NOW(),INTERVAL 5 MINUTE)','single-array','Time macro','text:','alerting',100,'macros',10,'0','0'),(407,'alert,macros,rule,past_10m','DATE_SUB(NOW(),INTERVAL 10 MINUTE)','DATE_SUB(NOW(),INTERVAL 10 MINUTE)','single-array','Time macro','text:','alerting',100,'macros',10,'0','0'),(408,'alert,macros,rule,past_15m','DATE_SUB(NOW(),INTERVAL 15 MINUTE)','DATE_SUB(NOW(),INTERVAL 10 MINUTE)','single-array','Time macro','text:','alerting',100,'macros',10,'0','0'),(409,'alert,macros,rule,past_30m','DATE_SUB(NOW(),INTERVAL 30 MINUTE)','DATE_SUB(NOW(),INTERVAL 10 MINUTE)','single-array','Time macro','text:','alerting',100,'macros',10,'0','0'),(410,'alert,macros,rule,past_60m','DATE_SUB(NOW(),INTERVAL 60 MINUTE)','DATE_SUB(NOW(),INTERVAL 10 MINUTE)','single-array','Time macro','text:','alerting',100,'macros',10,'0','0'),(411,'alert,macros,rule,device','(%devices.disabled = \"0\" && %devices.ignore = \"0\")','(%devices.disabled = \"0\" && %devices.ignore = \"0\")','single-array','Device macro','text:','alerting',100,'macros',10,'0','0'),(412,'alert,macros,rule,device_up','(%devices.status = \"1\" && %macros.device)','(%devices.status = \"1\" && %macros.device)','single-array','Device macro','text:','alerting',100,'macros',10,'0','0'),(413,'alert,macros,rule,device_down','(%devices.status = \"0\" && %macros.device)','(%devices.status = \"0\" && %macros.device)','single-array','Device macro','text:','alerting',100,'macros',10,'0','0'),(414,'alert,macros,rule,port','(%ports.deleted = \\\"0\\\" && %ports.ignore = \\\"0\\\" && %ports.disabled = \\\"0\\\")','(%ports.deleted = \"0\" && %ports.ignore = \"0\" && %ports.disabled = \"0\")','single-array','Port macro','text:','alerting',100,'macros',10,'0','0'),(415,'alert,macros,rule,port_up','(%ports.ifOperStatus = \"up\" && %ports.ifAdminStatus = \"up\" && %macros.port)','(%ports.ifOperStatus = \"up\" && %ports.ifAdminStatus = \"up\" && %macros.port)','single-array','Port macro','text:','alerting',100,'macros',10,'0','0'),(416,'alert,macros,rule,port_down','(%ports.ifOperStatus = \\\"down\\\" && %ports.ifAdminStatus != \\\"down\\\" && %macros.port)','(%ports.ifOperStatus = \"down\" && %ports.ifAdminStatus != \"down\" && %macros.port)','single-array','Port macro','text:','alerting',100,'macros',10,'0','0'),(417,'alert,macros,rule,port_usage_perc','((%ports.ifInOctets_rate*8)/%ports.ifSpeed)*100','((%ports.ifInOctets_rate*8)/%ports.ifSpeed)*100','single-array','Port macro','text:','alerting',100,'macros',10,'0','0'),(418,'alert,transports,dummy','false','false','single-array','Transports','radio:false,true','alerting',100,'transports',8,'0','0'),(419,'alert,transports,mail','false','false','single-array','Transports','radio:false,true','alerting',100,'transports',8,'0','0'),(420,'alert,transports,irc','false','false','single-array','Transports','radio:false,true','alerting',100,'transports',8,'0','0'),(421,'alert,globals','false','false','single-array','Issue alerts to global-read users','radio:false,true','alerting',100,'global',5,'0','0'),(422,'alert,admins','true','false','single-array','Issue alerts to admins','radio:false,true','alerting',100,'global',5,'0','0'),(423,'alert,default_only','true','false','single-array','Alert settings','radio:false,true','alerting',100,'global',5,'0','0'),(424,'alert,default_mail','','','single-array','Alert settings','text:','alerting',100,'global',5,'0','0'),(425,'alert,transports,pagerduty','false','false','single-array','Pagerduty transport','','alerting',100,'transports',8,'0','0'),(426,'alert,pagerduty,account','false','false','single-array','Pagerduty account name','','alerting',100,'transports',8,'0','0'),(427,'alert,pagerduty,service','false','false','single-array','Pagerduty service name','','alerting',100,'transports',8,'0','0');
