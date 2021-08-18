<?php

return [
    'config:get' => [
        'description' => 'Get configuration value',
        'arguments' => [
            'setting' => 'setting to get value of in dot notation (example: snmp.community.0)',
        ],
        'options' => [
            'json' => 'Output setting or entire config as json',
        ],
    ],
    'config:set' => [
        'description' => 'Set configuration value (or unset)',
        'arguments' => [
            'setting' => 'setting to set in dot notation (example: snmp.community.0) To append to an array suffix with .+',
            'value' => 'value to set, unset setting if this is omitted',
        ],
        'options' => [
            'ignore-checks' => 'Ignore all safety checks',
        ],
        'confirm' => 'Reset :setting to the default?',
        'forget_from' => 'Forget :path from :parent?',
        'errors' => [
            'append' => 'Cannot append to non-array setting',
            'failed' => 'Failed to set :setting',
            'invalid' => 'This is not a valid setting. Please check your input',
            'nodb' => 'Database is not connected',
            'no-validation' => 'Cannot set :setting, it is missing validation definition.',
        ],
    ],
    'dev:check' => [
        'description' => 'LibreNMS code checks. Running with no options runs all checks',
        'arguments' => [
            'check' => 'Run the specified check :checks',
        ],
        'options' => [
            'commands' => 'Print commands that would be run only, no checks',
            'db' => 'Run unit tests that require a database connection',
            'fail-fast' => 'Stop checks when any failure is encountered',
            'full' => 'Run full checks ignoring changed file filtering',
            'module' => 'Specific Module to run tests on. Implies unit, --db, --snmpsim',
            'os' => 'Specific OS to run tests on. Implies unit, --db, --snmpsim',
            'quiet' => 'Hide output unless there is an error',
            'snmpsim' => 'Use snmpsim for unit tests',
        ],
    ],
    'dev:simulate' => [
        'description' => 'Simulate devices using test data',
        'arguments' => [
            'file' => 'The file name (only base name) of the snmprec file to update or add to LibreNMS. If file not specified, no device will be added or updated.',
        ],
        'options' => [
            'multiple' => 'Use community name for hostname instead of snmpsim',
            'remove' => 'Remove the device after stopping',
        ],
        'added' => 'Device :hostname (:id) added',
        'exit' => 'Ctrl-C to stop',
        'removed' => 'Device :id removed',
        'updated' => 'Device :hostname (:id) updated',
    ],
    'smokeping:generate' => [
        'args-nonsense' => 'Use one of --probes and --targets',
        'config-insufficient' => 'In order to generate a smokeping configuration, you must have set "smokeping.probes", "fping", and "fping6" set in your configuration',
        'dns-fail' => 'was not resolvable and was omitted from the configuration',
        'description' => 'Generate a configuration suitable for use with smokeping',
        'header-first' => 'This file was automatically generated by "lnms smokeping:generate',
        'header-second' => 'Local changes may be overwritten without notice or backups being taken',
        'header-third' => 'For more information see https://docs.librenms.org/Extensions/Smokeping/"',
        'no-devices' => 'No eligible devices found - devices must not be disabled.',
        'no-probes' => 'At least one probe is required.',
        'options' => [
            'probes' => 'Generate probe list - used for splitting the smokeping configuration into multiple files. Conflicts with "--targets"',
            'targets' => 'Generate the target list - used for splitting the smokeping configuration into multiple files. Conflicts with "--probes"',
            'no-header' => 'Don\'t add the boilerplate comment to the start of the generated file',
            'no-dns' => 'Skip DNS lookups',
            'single-process' => 'Only use a single process for smokeping',
            'compat' => '[deprecated] Mimic the behaviour of gen_smokeping.php',
        ],
    ],
    'translation:generate' => [
        'description' => 'Generate updated json language files for use in the web frontend',
    ],
    'user:add' => [
        'description' => 'Add a local user, you can only log in with this user if auth is set to mysql',
        'arguments' => [
            'username' => 'The username the user will log in with',
        ],
        'options' => [
            'descr' => 'User description',
            'email' => 'Email to use for the user',
            'password' => 'Password for the user, if not given, you will be prompted',
            'full-name' => 'Full name for the user',
            'role' => 'Set the user to the desired role :roles',
        ],
        'password-request' => "Please enter the user's password",
        'success' => 'Successfully added user: :username',
        'wrong-auth' => 'Warning! You will not be able to log in with this user because you are not using MySQL auth',
    ],
];
