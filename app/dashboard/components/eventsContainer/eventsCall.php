<?php
ob_start();
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
include_once __DIR__ . '/../../../common/db/queryBuilder.php';
include_once __DIR__ . '/../../../common/db/tables.php';

// Pagination parameters
$limit = 12;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Sorting parameters with validation
$allowedSortFields = ['title', 'startDate'];
$sort = isset($_GET['sort']) && in_array($_GET['sort'], $allowedSortFields) ? $_GET['sort'] : 'startDate';
$direction = isset($_GET['direction']) && strtolower($_GET['direction']) === 'desc' ? 'DESC' : 'ASC';

// Construct the ORDER BY clause with proper escaping
$orderBy = "`$sort` $direction";

// Get sorted events with order by clause
$events = $queryBuilder->select(EVENTS_TABLE, "*", [], $limit, $offset, $orderBy);
$totalEvents = $queryBuilder->select(EVENTS_TABLE, "COUNT(*) as count");
$totalPages = ceil($totalEvents[0]['count'] / $limit);

$response = [
    'events' => $events,
    'totalPages' => $totalPages,
    'currentPage' => $page,
];

ob_clean();
echo json_encode($response);
ob_end_flush();
exit;
