<?php
ob_start();

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require_once __DIR__ . '/../common/db/queryBuilder.php';
require_once __DIR__ . '/../common/utils/jwt.php';

$method = $_SERVER['REQUEST_METHOD'];
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$path = trim(preg_replace('/.*?server\.php\//', '', $path), '/');

try {
    switch ("$method $path") {
        case 'GET ':
            http_response_code(200);
            echo json_encode(['message' => 'API is running']);
            break;
        case 'GET events/search':
            require_once 'endpoints/events/search.php';
            break;
        case 'GET attendees/search':
            require_once 'endpoints/attendees/search.php';
            break;
        case 'GET events/attendees/download':
            require_once __DIR__ . "/controllers/events/download-attendees.php";
            break;
        case 'POST events/register':
            require_once __DIR__ . '/controllers/events/register.php';
            break;
        case 'POST events/unregister':
            require_once __DIR__ . '/controllers/events/unregister.php';
            break;
        default:
            http_response_code(404);
            echo json_encode(['error' => 'Endpoint not found']);
            break;
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
