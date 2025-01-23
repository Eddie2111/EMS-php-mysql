<?php

#$dotenv = file_get_contents('../../.env');


# $lines = explode("\n", $dotenv);
# $env = [];
#foreach ($lines as $line) {
#    $parts = explode('=', $line, 2);
#    if (count($parts) === 2) {
#        $env[trim($parts[0])] = trim($parts[1]);
#    }
#}

// since not implemented, will use the following configs

$DB_HOST= 'db';
$DB_USER= 'mysql';
$DB_PASSWORD= "mysql";
$DB_NAME= 'event_management';

define('JWT_SECRET', '8futj-9i3kd-0ormv-1zmoqw');

?>