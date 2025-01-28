<?php

if (!defined('ENV_CONFIG_LOADED')) {

    function loadEnv()
    {
        $path = __DIR__ . "/.env";
        if (!file_exists($path)) {
            throw new Exception("Env file not found at path: $path");
        }
        $envFile = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        if ($envFile === false) {
            throw new Exception("Unable to read .env file");
        }
        foreach ($envFile as $line) {
            if (strpos($line, '#') === 0 || empty(trim($line))) {
                continue;
            }
            if (strpos($line, '=') !== false) {
                [$key, $value] = explode('=', $line, 2);
                $key = trim($key);
                $value = trim($value, " \t\n\r\0\x0B\"'");
                if (!empty($key)) {
                    $_ENV[$key] = $value;
                    $_SERVER[$key] = $value;
                }
            }
        }
    }

    try {
        loadEnv();
        if (
            !isset($_ENV['DB_HOST']) || !isset($_ENV['DB_NAME']) ||
            !isset($_ENV['DB_USER']) || !isset($_ENV['DB_PASSWORD']) ||
            !isset($_ENV['JWT_SECRET'])
        ) {
            throw new Exception("Missing required environment variables");
        }
        define('DB_HOST', $_ENV['DB_HOST']);
        define('DB_NAME', $_ENV['DB_NAME']);
        define('DB_USER', $_ENV['DB_USER']);
        define('DB_PASSWORD', $_ENV['DB_PASSWORD']);
        define('JWT_SECRET', $_ENV['JWT_SECRET']);

        define('ENV_CONFIG_LOADED', true);
    } catch (Exception $e) {
        error_log("Environment configuration error: " . $e->getMessage());
        die("Configuration error occurred. Please check the server logs.");
    }
}
