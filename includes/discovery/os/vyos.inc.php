<?php

if (!$os || $os == 'vyatta') {
    if (preg_match('/^Vyatta VyOS/', $sysDescr) || preg_match('/^VyOS/i', $sysDescr)) {
        $os = 'vyos';
    }
}
