ALTER TABLE `users` CHANGE `created_at` `created_at` TIMESTAMP NOT NULL DEFAULT '1970-01-02 00:00:01';
ALTER TABLE `eventlog` CHANGE `datetime` `datetime` DATETIME NOT NULL DEFAULT '1970-01-02 00:00:01';
ALTER TABLE `alert_schedule` CHANGE `start` `start` DATETIME NOT NULL DEFAULT '1970-01-02 00:00:01', CHANGE `end` `end` DATETIME NOT NULL DEFAULT '1970-01-02 00:00:01' dd;
