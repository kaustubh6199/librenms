<?php

return [
    'config:get' => [
        'description' => 'Отримати значення налаштування',
        'arguments' => [
            'setting' => 'Налаштування, значення якого необхідно отримати у формі з крапкою (приклад: snmp.community.0)',
        ],
        'options' => [
            'dump' => 'Вивести всю конфігурацію у форматі JSON',
        ],
    ],
    'config:set' => [
        'description' => 'Встановити значення налаштування (або очистити)',
        'arguments' => [
            'setting' => 'Налаштування для встановлення у формі з крапкою (приклад: snmp.community.0). Щоб додати до масиву необхідний суфікс .+',
            'value' => 'Встановлене значення, очистити значенняналаштування якщо не вказано',
        ],
        'options' => [
            'ignore-checks' => 'Ігнорувати всі запобіжні перевірки',
        ],
        'confirm' => 'Скинути :setting на замовчування?',
        'forget_from' => 'Забути :path від :parent?',
        'errors' => [
            'append' => 'Неможливо додати елемент до налаштування що не є масивом',
            'failed' => 'Не вдалося встановити :setting',
            'invalid' => 'Це налаштування не є коректним. Перевірте ваш ввід',
            'invalid_os' => 'Вказаної ОС (:os) не існує',
            'nodb' => 'З\'єднання з базою даних відсутнє',
            'no-validation' => 'Неможливо встановити :setting через брак визначень валідації.',
        ],
    ],
    'db:seed' => [
        'existing_config' => 'База даних містить існуючі налаштування. Продовжити?',
    ],
    'dev:check' => [
        'description' => 'Перевірки коду LibreNMS. Запуск без опцій запускає всі перевірки',
        'arguments' => [
            'check' => 'Запустити вказану перевірку :checks',
        ],
        'options' => [
            'commands' => 'Лише вивести командиякі були б застосовані, не проводити перевірок',
            'db' => 'Виконувати unit тести які потребують з\'єднання з базою даних',
            'fail-fast' => 'Припиняти перевірки при будь-яких помилках',
            'full' => 'Виконувати повні перевірки ігноруючи фільтрацію змінених файлів',
            'module' => 'Окремий модуль для запуску тестів для нього. Означає використання unit, --db, --snmpsim',
            'os' => 'Окрема OS для запуску тестів ля неї. Означає використання unit, --db, --snmpsim',
            'os-modules-only' => 'Пропустити тест на визначення OS при визначення конкретної OS.  Пришвидшує тести при перевірці змін не пов\'язаних із визначенням.',
            'quiet' => 'Приховати вивід окрім помилок',
            'snmpsim' => 'Використати snmpsim для unit тестів',
        ],
    ],
    'dev:simulate' => [
        'description' => 'Симулювати пристрої використовуючи тестові дані',
        'arguments' => [
            'file' => 'Ім\'я файлу snmprec який необхідно оновити або додати до LibreNMS. Якщо файл не вказано, пристрій не буде додано або оновлено.',
        ],
        'options' => [
            'multiple' => 'Використати ім\'я community для hostname замість snmpsim',
            'remove' => 'Видалити пристрій після завершення',
        ],
        'added' => 'Пристрій :hostname (:id) додано',
        'exit' => 'Ctrl-C для зупинки',
        'removed' => 'Пристрій :id видалено',
        'updated' => 'Пристрій :hostname (:id) оновлено',
    ],
    'device:add' => [
        'description' => 'Додати новий пристрій',
        'arguments' => [
            'device spec' => 'Ім\'я хоста або IP адреса по яким додати',
        ],
        'options' => [
            'v1' => 'Використовувати SNMP v1',
            'v2c' => 'Використовувати SNMP v2c',
            'v3' => 'Використовувати SNMP v3',
            'display-name' => "Стрічка яку буде показано в якості імені пристрою, за замовчуванням ім'я хоста.\nМоже бути простим шаблоном з використанням заміщення: {{ \$hostname }}, {{ \$sysName }}, {{ \$sysName_fallback }}, {{ \$ip }}",
            'force' => 'Додати пристрій без проведення будь-яких запобіжних перевірок',
            'group' => 'Група опитувачів (для розподіленого опитування)',
            'ping-fallback' => 'Додати пристрій як доступний лише по ping якщо він не відповідає на SNMP',
            'port-association-mode' => 'Визначає порядок призначення портів. ifName рекомендовано для Linux/Unix',
            'community' => 'community для SNMP v1 або v2',
            'transport' => 'Транспортний протокол для з\'єднання з пристроєм',
            'port' => 'Транспортний порт SNMP',
            'security-name' => 'Ім\'я користувача SNMPv3',
            'auth-password' => 'Пароль автентифікації SNMPv3',
            'auth-protocol' => 'Протокол автентифікації SNMPv3',
            'privacy-protocol' => 'Протокол шифрування SNMPv3',
            'privacy-password' => 'Пароль шифрування SNMPv3',
            'ping-only' => 'Додати пристрій лише з ping',
            'os' => 'Лише ping: вказати OS',
            'hardware' => 'Лише ping: вказати модель пристрою',
            'sysName' => 'Лише ping: вказати sysName',
        ],
        'validation-errors' => [
            'port.between' => 'Порт має знаходитися у діапазоні 1-65535',
            'poller-group.in' => 'Даної групи опитувачів не існує',
        ],
        'messages' => [
            'save_failed' => 'Не вдалося зберегти пристрій :hostname',
            'try_force' => 'Ви можете спробувати опцію --force для пропуску перевірок',
            'added' => 'Пристрій :hostname (:device_id) додано',
        ],
    ],
    'device:ping' => [
        'description' => 'Надіслати ping до пристрою та записати відповідь',
        'arguments' => [
            'device spec' => 'Пристрій для запиту ping: <Device ID>, <Hostname/IP>, all',
        ],
    ],
    'device:poll' => [
        'description' => 'Опитати пристрій(-ої) як визначено дискаверінгом',
        'arguments' => [
            'device spec' => 'Пристрої для опитування: device_id, hostname, wildcard, odd, even, all',
        ],
        'options' => [
            'modules' => 'Визначити єдиний модуль який буде запущено. Додаткові модулі вказуються через кому, підмодулі додаються через /',
            'no-data' => 'Не оновлювати дані сховищ даних (RRD, InfluxDB, інші)',
        ],
        'errors' => [
            'db_connect' => 'Не вдалося встановити з\'єднання з базою даних. Перевірте сервіс бази даних та налаштування з\'єднання.',
            'db_auth' => 'Не вдалося встановити з\'єднання з базою даних. Перевірте дані облікового запису: :error',
        ],
    ],
    'key:rotate' => [
        'description' => 'Ротувати APP_KEY, це дешифрує всі зашифровані дані вказаним старим ключем та зберігає їх з новим ключем у APP_KEY.',
        'arguments' => [
            'old_key' => 'Старий APP_KEY який валідний для шифрованих даних.',
        ],
        'cleared-cache' => 'Конфігурацію було закешовано, кеш було очищено для того щоб APP_KEY був коректним. Перезапустіть lnms key:rotate',
        'backup_keys' => 'Запишіть ОБИДВА ключі! У разі якщо щось піде не так вкажіть новий ключ в .env та використайте старий ключ в якості аргументу для цієї команди',
        'backups' => 'Ця команда може призвести до незворотньої втрати даних та інвалідує всі сесії браузера. Впевніться що маєте резервну копію.',
        'confirm' => 'Я маю резервну копію та хочу продовжити',
        'decrypt-failed' => 'Не вдалося розшифрувати :item, пропускаємо',
        'failed' => 'Не вдалося розшифрувати.  Призначте новий ключ в якості APP_KEY and та запустіть команду знову зі старим ключем в якості аргументу.',
        'new_key' => 'Новий ключ: :key',
        'old_key' => 'Старий ключ: :key',
        'save_key' => 'Зберегти новий ключ до .env?',
        'success' => 'Ротація ключів успішна!',
        'validation-errors' => [
            'not_in' => ':attribute не має співпадати з наявним APP_KEY',
            'required' => 'Необхідний або старий ключ або --generate-new-key.',
        ],
    ],
    'lnms' => [
        'validation-errors' => [
            'optionValue' => 'Обране :option не є валідним. Має бути одним з: :values',
        ],
    ],
    'smokeping:generate' => [
        'args-nonsense' => 'Використати --probes або --targets',
        'config-insufficient' => 'Для генерації конфігурації smokeping необхідно задати у конфігурації "smokeping.probes", "fping", та "fping6"',
        'dns-fail' => 'Не міг бути визначеним через DNS та було виключено з конфігурації',
        'description' => 'Згенерувати конфігурацію придатну для використання з smokeping',
        'header-first' => 'Цей файл було автоматично згенеровано за допомогою "lnms smokeping:generate',
        'header-second' => 'Локальні зміни можуть бути перезаписані без попередження або резервної копії',
        'header-third' => 'Для додаткової інформації див. https://docs.librenms.org/Extensions/Smokeping/"',
        'no-devices' => 'Не знайдено підходящих пристроїв - пристрої не мають бути вимкнені.',
        'no-probes' => 'Необхідна щонайменше одна проба.',
        'options' => [
            'probes' => 'Згенерувати список проб - використовується для розділення конфігурації smokeping на декілька файлів. Конфліктує з "--targets"',
            'targets' => 'Згенерувати список цілей - використовується для розділення конфігурації smokeping на декілька файлів. Конфліктує з "--probes"',
            'no-header' => 'Не додавати шаблонний коментар до початку згенерованого файлу',
            'no-dns' => 'Пропустити запити DNS',
            'single-process' => 'Використовувати лише один процес для smokeping',
            'compat' => '[deprecated] Копіювати поведінку gen_smokeping.php',
        ],
    ],
    'snmp:fetch' => [
        'description' => 'Надіслати запит SNMP для пристрою',
        'arguments' => [
            'device spec' => 'Пристрій для запиту: device_id, hostname/ip, регулярний вираз по hostname, або all',
            'oid' => 'SNMP OID для отримання.  Має бути або у формі MIB::oid або чисельним OID',
        ],
        'failed' => 'Запит SNMP невдалий!',
        'oid' => 'OID',
        'options' => [
            'type' => 'Тип запиту SNMP для виконання :types',
            'output' => 'Вказати формат виводу :formats',
            'numeric' => 'Числові OID',
        ],
        'not_found' => 'Пристрій не знайдено',
        'value' => 'Значення',
    ],
    'translation:generate' => [
        'description' => 'Згенерувати оновлені мовні файли JSON для використання у веб-інтерфейсі',
    ],
    'user:add' => [
        'description' => 'Додати локального користувача, вхід доступний лише при використанні mysql автентифікації',
        'arguments' => [
            'username' => "Ім'я користувача для входу",
        ],
        'options' => [
            'descr' => 'Опис користувача',
            'email' => 'Електронна пошта користувача',
            'password' => 'Пароль користувача, якщо не наданий, то буде запропоновано',
            'full-name' => "Повне ім'я користувача",
            'role' => 'Користувачеві буде назначено роль :roles',
        ],
        'password-request' => 'Будь ласка, введіть пароль користувача',
        'success' => 'Успішно додано користувача: :username',
        'wrong-auth' => 'Увага! Ви не зможете авторизуватися, оскільки не використовуєте MySQL авторизацію',
    ],
];
