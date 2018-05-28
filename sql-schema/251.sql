CREATE TABLE IF NOT EXISTS alert_transports (transport_id INT(11) NOT NULL AUTO_INCREMENT, transport_name VARCHAR(30) NOT NULL COLLATE utf8_unicode_ci, transport_type VARCHAR(20) NOT NULL DEFAULT 'mail', transport_config TEXT, PRIMARY KEY(transport_id));
CREATE TABLE IF NOT EXISTS alert_transport_map (id INT(11) NOT NULL AUTO_INCREMENT, rule_id INT(11) NOT NULL, transport_or_group_id INT(11) NOT NULL, target_type VARCHAR(16) NOT NULL, PRIMARY KEY(id));
CREATE TABLE IF NOT EXISTS alert_transport_groups (transport_group_id INT(11) NOT NULL AUTO_INCREMENT, transport_group_name VARCHAR(30) NOT NULL COLLATE utf8_unicode_ci, PRIMARY KEY(transport_group_id));
CREATE TABLE IF NOT EXISTS transport_group_transport (transport_group_id INT(11) NOT NULL, transport_id INT(11) NOT NULL);
