<?php

// https://www.iana.org/assignments/bgp-parameters/bgp-parameters.xhtml#bgp-parameters-3
return [
 'error_codes' => [
        0 => "Reserved",
        1 => "Message Header Error",
        2 => "OPEN Message Error",
        3 => "UPDATE Message Error",
        4 => "Hold Timer Expired",
        5 => "Finite State Machine Error",
        6 => "Cease",
        7 => "ROUTE-REFRESH Message Error",
 ],
 'error_subcodes' => [
        1 => [
            0 => "Unspecific",
            1 => "Connection Not Synchronized",
            2 => "Bad Message Length",
            3 => "Bad Message Type",
        ],
        2 => [
            0 => "Unspecific",
            1 => "Unsupported Version Number",
            2 => "Bad Peer AS",
            3 => "Bad BGP Identifier",
            4 => "Unsuported Optional Parameter",
            5 => "[Deprecated]",
            6 => "Unacceptable Hold Time",
            7 => "Role Mismatch (Temporary BGP Draft)",
        ],
        3 => [
            0 => "Unspecific",
            1 => "Malformted Attribute List",
            2 => "Unrecognized Well-known Attribute",
            3 => "Missing Well-known Attribute",
            4 => "Attribute Flags Error",
            5 => "Attribute Length Error",
            6 => "Invalid ORIGIN Attribute",
            7 => "[Deprecated]",
            8 => "Invalid NEXT_HOP Attribute",
            9 => "Optional Attribute Error",
            10 => "Invalid Network Field",
            11 => "Malformed AS_PATH",
        ],
        5 => [
            0 => "Unspecified Error",
            1 => "Receive Unexpected Message in OpenSent State",
            2 => "Receive Unexpected Message in OpenConfirm State",
            3 => "Receive Unexpected Message in Established State",
        ],
        6 => [
            0 => "Reserved",
            1 => "Maximum Number of Prefixes Reached",
            2 => "Administrative Shutdown",
            3 => "Peer De-configured",
            4 => "Administrative Reset",
            5 => "Connection Rejected",
            6 => "Other Configuration Change",
            7 => "Connection Collision Resolution",
            8 => "Out of Resources",
            9 => "Hard Reset",
        ],
    ],
];
