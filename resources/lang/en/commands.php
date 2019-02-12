<?php

return [
    'pull-request' => [
        'description' => 'Apply or remove a GitHub pull request so you can test it locally',
        'arguments' => [
            'pull-request' => 'The pull request number, PRs can be found here :url',
        ],
        'options' => [
            'remove' => 'Remove the pull request via reverse patch',
        ],
        'success' => [
            'apply' => 'Pull request :number applied',
            'remove' => 'Pull request :number removed',
        ],
        'download_failed' => 'Could not download from GitHub or invalid PR number.',
        'failed' => [
            'apply' => 'An error occurred applying PR :number',
            'remove' => 'An error occurred removing PR :number',
        ]
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
