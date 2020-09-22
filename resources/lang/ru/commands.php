<?php

return [
    'user:add' => [
        'description' => 'Создание локального пользователя. Вы сможете воспользоваться созданными учетными данными если вы используете авторизацию mysql',
        'arguments' => [
            'username' => 'Имя пользователя с которым вы будете проходить авторизацию',
        ],
        'options' => [
            'descr' => 'Описание пользователя',
            'email' => 'Email пользователя',
            'password' => 'Пароль пользователя, если не введен, то будет предложенно',
            'full-name' => 'Полное имя пользователя',
            'role' => 'Пользователю будет назначена роль :roles',
        ],
        'password-request' => 'Пожалуйста введите пароль',
        'success' => 'Успешно создан пользователь: :username',
        'wrong-auth' => 'Внимание! вы не смогли пройти авторизация, так как вы не используете  MySQL авторизацию',
    ],
];
