<?php
require_once('Models/Database.php');
require_once('Models/FacilityDataSet.php');
require_once('Models/ReviewDataSet.php');
require_once('auth-helpers.php');

$view = new stdClass();
$view->pageTitle = "View Facility - EcoBuddy System";
$errorMessage = '';
$successMessage = '';

// Handle CRUD operations
$facilityDataSet = new FacilityDataSet();
$reviewsDataSet = new ReviewDataSet();

$facilityId = $_GET['facilityId'];

// Check if a facility ID is provided
if (!isset($facilityId) || empty($facilityId)) {
    redirectToHomePage(); 
}

// Fetch the existing facility details
$facility = $facilityDataSet->fetchFacilityByID($facilityId);

if (!$facility) {
    $errorMessage = 'Facility not found.';
    echo $errorMessage;
    exit;
}

$view->facility = $facility; // Pass the facility details to the view
$view->reviews =  $reviewsDataSet->fetchReviewsByFacilityID($facility->getId());
$view->user = getUser();

// Load the edit facility view
require_once('Views/facilities/facility-form.view.phtml');