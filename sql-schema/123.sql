INSERT INTO `alert_templates` (`rule_id`, `name`, `template`, `title`, `title_rec`) VALUES (',','BGP Sessions.','%title\\r\\n\nSeverity: %severity\\r\\n\n{if %state == 0}Time elapsed: %elapsed\\r\\n{/if}\nTimestamp: %timestamp\\r\\n\nUnique-ID: %uid\\r\\n\nRule: {if %name}%name{else}%rule{/if}\\r\\n\n{if %faults}Faults:\\r\\n\n{foreach %faults}\n#%key: %value.string\\r\\n\nPeer: %value.astext\\r\\n\nPeer IP: %value.bgpPeerIdentifier\\r\\n\nPeer AS: %value.bgpPeerRemoteAs\\r\\n\nPeer EstTime: %value.bgpPeerFsmEstablishedTime\\r\\n\nPeer State: %value.bgpPeerState\\r\\n\n{/foreach}\n{/if}','','');
INSERT INTO `alert_templates` (`rule_id`, `name`, `template`, `title`, `title_rec`) VALUES (',','Ports','%title\\r\\n\nSeverity: %severity\\r\\n\n{if %state == 0}Time elapsed: %elapsed{/if}\nTimestamp: %timestamp\nUnique-ID: %uid\nRule: {if %name}%name{else}%rule{/if}\\r\\n\n{if %faults}Faults:\\r\\n\n{foreach %faults}\\r\\n\n#%key: %value.string\\r\\n\nPort: %value.ifName\\r\\n\nPort Name: %value.ifAlias\\r\\n\nPort Status: %value.message\\r\\n\n{/foreach}\\r\\n\n{/if}\n','','');
INSERT INTO `alert_templates` (`rule_id`, `name`, `template`, `title`, `title_rec`) VALUES (',','Temperature','%title\\r\\n\nSeverity: %severity\\r\\n\n{if %state == 0}Time elapsed: %elapsed{/if}\\r\\n\nTimestamp: %timestamp\\r\\n\nUnique-ID: %uid\\r\\n\nRule: {if %name}%name{else}%rule{/if}\\r\\n\n{if %faults}Faults:\\r\\n\n{foreach %faults}\\r\\n\n#%key: %value.string\\r\\n\nTemperature: %value.sensor_current\\r\\n\nPrevious Measurement: %value.sensor_prev\\r\\n\n{/foreach}\\r\\n\n{/if}','','');
