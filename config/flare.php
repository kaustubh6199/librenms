<?php

 /*
 | !!!! DO NOT EDIT THIS FILE !!!!
 |
 | You can change settings by setting them in the environment or .env
 | If there is something you need to change, but is not available as an environment setting,
 | request an environment variable to be created upstream or send a pull request.
 */

return [
    /*
    |
    |--------------------------------------------------------------------------
    | Flare API key
    |--------------------------------------------------------------------------
    |
    | Specify Flare's API key below to enable error reporting to the service.
    |
    | More info: https://flareapp.io/docs/general/projects
    |
    */

    'key' => null,

    /*
    |--------------------------------------------------------------------------
    | Reporting Options
    |--------------------------------------------------------------------------
    |
    | These options determine which information will be transmitted to Flare.
    |
    */

    'reporting' => [
        'anonymize_ips' => true,
        'collect_git_information' => true,
        'report_queries' => true,
        'maximum_number_of_collected_queries' => 200,
        'report_query_bindings' => true,
        'report_view_data' => true,
        'grouping_type' => null,
        'report_logs' => false,
        'maximum_number_of_collected_logs' => 200,
        'censor_request_body_fields' => ['username', 'password', 'sysContact', 'community', 'authname', 'authpass', 'cryptopass'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Reporting Log statements
    |--------------------------------------------------------------------------
    |
    | If this setting is `false` log statements won't be sent as events to Flare,
    | no matter which error level you specified in the Flare log channel.
    |
    */

    'send_logs_as_events' => false,

    /*
    |--------------------------------------------------------------------------
    | Censor request body fields
    |--------------------------------------------------------------------------
    |
    | These fields will be censored from your request when sent to Flare.
    |
    */

    'censor_request_body_fields' => ['username', 'password', 'sysContact', 'community', 'authname', 'authpass', 'cryptopass'],
];
