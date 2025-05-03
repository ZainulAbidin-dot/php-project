<?php
require_once('../Models/Database.php');
require_once('../Models/UserDataSet.php');
require_once('../Models/FacilityDataSet.php');

header('Content-Type: application/json');

$pageNumber = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$pageSize = 2; // Adjust as needed

$facilityDataSet = new FacilityDataSet();
$facilities = $facilityDataSet->fetchAllFacilitiesPagination($pageNumber, $pageSize);

// Check if there are more pages
$nextPage = count($facilities) === $pageSize ? $pageNumber + 1 : -1;

echo json_encode([
  'data' => $facilities,
  'nextPage' => $nextPage
]);