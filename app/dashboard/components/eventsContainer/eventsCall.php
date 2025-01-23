<?php
ob_start();

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once __DIR__ . '/../../../common/db/queryBuilder.php';
include_once __DIR__ . '/../../../common/db/tables.php';

$limit = 12;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$events = $queryBuilder->select(EVENTS_TABLE, "*", [], $limit, $offset);
$totalEvents = $queryBuilder->select(EVENTS_TABLE, "COUNT(*) as count");
$totalPages = ceil($totalEvents[0]['count'] / $limit);

$response = [
    'events' => $events,
    'totalPages' => $totalPages,
    'currentPage' => $page,
];

ob_clean(); // Clear any unintended output
echo json_encode($response);
ob_end_flush(); // Send the output and turn off output buffering
exit;
