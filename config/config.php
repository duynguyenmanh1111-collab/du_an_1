<?php

if (!defined('BASE_PATH')) {
    define('BASE_PATH', realpath(dirname(__FILE__) . '/../'));
}

defined('BASE_URL') or define('BASE_URL', 'http://localhost/website_ql_tour/');

return [
    'db' => [
        'host' => 'localhost',
        'name' => 'website_ql_tour',
        'user' => 'root',
        'pass' => '',
        'charset' => 'utf8mb4',
    ],
];