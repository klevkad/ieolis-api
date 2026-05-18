<?php

return [

    'acconage' => [
        'driver'         => 'oracle',
        'tns'            => env('DB_TNS', 'EOLISDB'),
        'host'           => env('DB_HOST_PROD', ''),
        'port'           => env('DB_PORT', '1521'),
        'database'       => env('DB_DATABASE_PROD', ''),
        'username'       => 'ACCONAGE',
        'password'       => 'ACCONAGEOracle01',
        'charset'        => env('DB_CHARSET', 'AL32UTF8'),
        'prefix'         => env('DB_PREFIX', ''),
        'prefix_schema'  => env('DB_SCHEMA_PREFIX', 'ACCONAGE'),
        'edition'        => env('DB_EDITION', 'ora$base'),
        'server_version' => env('DB_SERVER_VERSION', '11g'),
//        'options'        => [ PDO::ATTR_CASE => PDO::CASE_UPPER ]
    ],

    'archive' => [
        'driver'         => 'oracle',
        'tns'            => env('DB_TNS', 'EOLISDB'),
        'host'           => env('DB_HOST_PROD', ''),
        'port'           => env('DB_PORT', '1521'),
        'database'       => env('DB_DATABASE_PROD', ''),
        'username'       => 'ARCHIVE',
        'password'       => 'ARCHIVEOracle01',
        'charset'        => env('DB_CHARSET', 'AL32UTF8'),
        'prefix'         => env('DB_PREFIX', ''),
        'prefix_schema'  => env('DB_SCHEMA_PREFIX', 'ARCHIVE'),
        'edition'        => env('DB_EDITION', 'ora$base'),
        'server_version' => env('DB_SERVER_VERSION', '11g'),
//        'options'        => [ PDO::ATTR_CASE => PDO::CASE_UPPER ]
    ],

    'booking' => [
        'driver'         => 'oracle',
        'tns'            => env('DB_TNS', 'EOLISDB'),
        'host'           => env('DB_HOST_PROD', ''),
        'port'           => env('DB_PORT', '1521'),
        'database'       => env('DB_DATABASE_PROD', ''),
        'username'       => env('DB_USERNAME_PROD', ''),
        'password'       => env('DB_PASSWORD_PROD', ''),
        'charset'        => env('DB_CHARSET', 'AL32UTF8'),
        'prefix'         => env('DB_PREFIX', ''),
        'prefix_schema'  => env('DB_SCHEMA_PREFIX', 'BOOKING'),
        'edition'        => env('DB_EDITION', 'ora$base'),
        'server_version' => env('DB_SERVER_VERSION', '11g'),
//        'options'        => [ PDO::ATTR_CASE => PDO::CASE_UPPER ]
    ],

    'eco' => [
        'driver'         => 'oracle',
        'tns'            => env('DB_TNS', 'EOLISDB'),
        'host'           => env('DB_HOST_PROD', ''),
        'port'           => env('DB_PORT', '1521'),
        'database'       => env('DB_DATABASE_PROD', ''),
        'username'       => 'ECO',
        'password'       => 'ECOOracle01',
        'charset'        => env('DB_CHARSET', 'AL32UTF8'),
        'prefix'         => env('DB_PREFIX', ''),
        'prefix_schema'  => env('DB_SCHEMA_PREFIX', 'EOLIS'),
        'edition'        => env('DB_EDITION', 'ora$base'),
        'server_version' => env('DB_SERVER_VERSION', '11g'),
//        'options'        => [ PDO::ATTR_CASE => PDO::CASE_UPPER ]
    ],

    'eolis' => [
        'driver'         => 'oracle',
        'tns'            => env('DB_TNS', 'EOLISDB'),
        'host'           => env('DB_HOST_PROD', ''),
        'port'           => env('DB_PORT', '1521'),
        'database'       => env('DB_DATABASE_PROD', ''),
        'username'       => 'EOLIS',
        'password'       => 'EolisOracle01',
        'charset'        => env('DB_CHARSET', 'AL32UTF8'),
        'prefix'         => env('DB_PREFIX', ''),
        'prefix_schema'  => env('DB_SCHEMA_PREFIX', 'EOLIS'),
        'edition'        => env('DB_EDITION', 'ora$base'),
        'server_version' => env('DB_SERVER_VERSION', '11g'),
//        'options'        => [ PDO::ATTR_CASE => PDO::CASE_UPPER ]
    ],

    'etf' => [
        'driver'         => 'oracle',
        'tns'            => env('DB_TNS', 'EOLISDB'),
        'host'           => env('DB_HOST_PROD', ''),
        'port'           => env('DB_PORT', '1521'),
        'database'       => env('DB_DATABASE_PROD', ''),
        'username'       => 'ETF',
        'password'       => 'ETFOracle01',
        'charset'        => env('DB_CHARSET', 'AL32UTF8'),
        'prefix'         => env('DB_PREFIX', ''),
        'prefix_schema'  => env('DB_SCHEMA_PREFIX', 'ETF'),
        'edition'        => env('DB_EDITION', 'ora$base'),
        'server_version' => env('DB_SERVER_VERSION', '11g'),
//        'options'        => [ PDO::ATTR_CASE => PDO::CASE_UPPER ]
    ],

    'parc' => [
        'driver'         => 'oracle',
        'tns'            => env('DB_TNS', 'EOLISDB'),
        'host'           => env('DB_HOST_PROD', ''),
        'port'           => env('DB_PORT', '1521'),
        'database'       => env('DB_DATABASE_PROD', ''),
        'username'       => 'PARC',
        'password'       => 'PARCOracle01',
        'charset'        => env('DB_CHARSET', 'AL32UTF8'),
        'prefix'         => env('DB_PREFIX', ''),
        'prefix_schema'  => env('DB_SCHEMA_PREFIX', 'PARC'),
        'edition'        => env('DB_EDITION', 'ora$base'),
        'server_version' => env('DB_SERVER_VERSION', '11g'),
//        'options'        => [ PDO::ATTR_CASE => PDO::CASE_UPPER ]
    ],

    'transit' => [
        'driver'         => 'oracle',
        'tns'            => env('DB_TNS', 'EOLISDB'),
        'host'           => env('DB_HOST_PROD', ''),
        'port'           => env('DB_PORT', '1521'),
        'database'       => env('DB_DATABASE_PROD', ''),
        'username'       => 'TRANSIT',
        'password'       => 'TRANSITOracle01',
        'charset'        => env('DB_CHARSET', 'AL32UTF8'),
        'prefix'         => env('DB_PREFIX', ''),
        'prefix_schema'  => env('DB_SCHEMA_PREFIX', 'TRANSIT'),
        'edition'        => env('DB_EDITION', 'ora$base'),
        'server_version' => env('DB_SERVER_VERSION', '11g'),
//        'options'        => [ PDO::ATTR_CASE => PDO::CASE_UPPER ]
    ],
];
