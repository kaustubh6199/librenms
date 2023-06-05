<?php

return [
    'title' => 'Системный журнал (Syslog)',
    'severity' => [
        '0' => 'Аварийный',
        '1' => 'Предупреждение',
        '2' => 'Критическая ошибка',
        '3' => 'Ошибка',
        '4' => 'Предупреждение',
        '5' => 'Уведомление',
        '6' => 'Информационное сообщение',
        '7' => 'Отладочная информация',
    ],
    'facility' => [
        '0' => 'Сообщения ядра',
        '1' => 'Сообщения пользователей',
        '2' => 'Система почты',
        '3' => 'Системные демоны',
        '4' => 'Сообщения безопасности/авторизации',
        '5' => 'Сообщения, генерируемые самой службой syslogd',
        '6' => 'Подсистема линейного принтера',
        '7' => 'Подсистема сетевых новостей',
        '8' => 'Подсистема UUCP',
        '9' => 'Демон часов',
        '10' => 'Сообщения безопасности/авторизации',
        '11' => 'FTP-демон',
        '12' => 'Подсистема NTP',
        '13' => 'Аудит журнала',
        '14' => 'Оповещение журнала',
        '15' => 'Демон часов (примечание 2)',
        '16' => 'Локальное использование 0 (local0)',
        '17' => 'Локальное использование 1 (local1)',
        '18' => 'Локальное использование 2 (local2)',
        '19' => 'Локальное использование 3 (local3)',
        '20' => 'Локальное использование 4 (local4)',
        '21' => 'Локальное использование 5 (local5)',
        '22' => 'Локальное использование 6 (local6)',
        '23' => 'Локальное использование 7 (local7)',
    ],
];