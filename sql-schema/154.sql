ALTER TABLE `devices` CHANGE `ip` `ip` VARBINARY(16) NULL DEFAULT NULL;
ALTER TABLE `alert_log` CHANGE `details` `details` LONGBLOB NULL DEFAULT NULL;
