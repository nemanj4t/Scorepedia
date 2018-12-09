<?php
/**
 * Created by PhpStorm.
 * User: Nemanja
 * Date: 9.12.2018.
 * Time: 18:03
 */

return [
    'ssl' => false,
    'connection' => 'default',
    'host'   => 'localhost',
    'port'   => '7474',
    'username' => env('DB_NEO_USERNAME', 'neo4j'),
    'password' => env('DB_NEO_PASSWORD', 'neo4j')
];