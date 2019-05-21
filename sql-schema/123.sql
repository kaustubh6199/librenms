INSERT INTO `alert_templates` (`name`, `template`) VALUES ('BGP Sessions.', '{{ $alert->title }}\r\n\\r\\n\nSeverity: {{ $alert->severity }}\r\n\\r\\n\n @if ($alert->state == 0) Time elapsed: {{ $alert->elapsed }}\r\n @endif\\r\\n\nTimestamp: {{ $alert->timestamp }}\r\n\\r\\n\nUnique-ID: {{ $alert->uid }}\r\n\\r\\n\nRule:  @if ($alert->name) {{ $alert->name }} @else {{ $alert->rule }} @endif \r\n\\r\\n\n @if ($alert->faults) Faults:\r\n\\r\\n\n @foreach ($alert->faults as $key => $value)\\r\\n\n#{{ $key }}: {{ $value[\'string\'] }}\r\n\\r\\n\nPeer: {{ $value[\'astext\'] }}\r\n\\r\\n\nPeer IP: {{ $value[\'bgpPeerIdentifier\'] }}\r\n\\r\\n\nPeer AS: {{ $value[\'bgpPeerRemoteAs\'] }}\r\n\\r\\n\nPeer EstTime: {{ $value[\'bgpPeerFsmEstablishedTime\'] }}\r\n\\r\\n\nPeer State: {{ $value[\'bgpPeerState\'] }}\r\n\\r\\n\n @endforeach\\r\\n\n @endif');
INSERT INTO `alert_templates` (`name`, `template`) VALUES ('Ports', '{{ $alert->title }}\r\n\\r\\n\nSeverity: {{ $alert->severity }}\r\n\\r\\n\n @if ($alert->state == 0) Time elapsed: {{ $alert->elapsed }} @endif\\r\\n\nTimestamp: {{ $alert->timestamp }}\\r\\n\nUnique-ID: {{ $alert->uid }}\\r\\n\nRule:  @if ($alert->name) {{ $alert->name }} @else {{ $alert->rule }} @endif \r\n\\r\\n\n @if ($alert->faults) Faults:\r\n\\r\\n\n @foreach ($alert->faults as $key => $value)\r\n\\r\\n\n#{{ $key }}: {{ $value[\'string\'] }}\r\n\\r\\n\nPort: {{ $value[\'ifName\'] }}\r\n\\r\\n\nPort Name: {{ $value[\'ifAlias\'] }}\r\n\\r\\n\nPort Status: {{ $value[\'message\'] }}\r\n\\r\\n\n @endforeach \r\n\\r\\n\n @endif');
INSERT INTO `alert_templates` (`name`, `template`) VALUES ('Temperature', '{{ $alert->title }}\r\n\\r\\n\nSeverity: {{ $alert->severity }}\r\n\\r\\n\n @if ($alert->state == 0) Time elapsed: {{ $alert->elapsed }} @endif \r\n\\r\\n\nTimestamp: {{ $alert->timestamp }}\r\n\\r\\n\nUnique-ID: {{ $alert->uid }}\r\n\\r\\n\nRule:  @if ($alert->name) {{ $alert->name }} @else {{ $alert->rule }} @endif \r\n\\r\\n\n @if ($alert->faults) Faults:\r\n\\r\\n\n @foreach ($alert->faults as $key => $value)\r\n\\r\\n\n#{{ $key }}: {{ $value[\'string\'] }}\r\n\\r\\n\nTemperature: {{ $value[\'sensor_current\'] }}\r\n\\r\\n\nPrevious Measurement: {{ $value[\'sensor_prev\'] }}\r\n\\r\\n\n @endforeach \r\n\\r\\n\n @endif');
