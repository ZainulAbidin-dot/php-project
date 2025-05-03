<?php
require_once('Models/Database.php');
require_once('Models/UserDataSet.php');
require_once('Models/FacilityDataSet.php');

$pageNumber = 1;

$view = new stdClass();
$view->pageTitle = "Dashboard - EcoBuddy System";

$facilityDataSet = new FacilityDataSet();
$view->facilityDataSet = $facilityDataSet->fetchAllFacilitiesPagination($pageNumber);

// send a results count to the view to show how many results were retrieved
if (count($view->facilityDataSet) == 0)
{
    $view->dbMessage = "No results";
}
else
{
    $view->dbMessage = count($view->facilityDataSet) . " result(s)";
}

// Load the home page view
require_once('Views/guestuser.phtml');
