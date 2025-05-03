<?php
require_once('Models/Database.php');
require_once ('Models/FacilityDataSet.php');
require_once('auth-helpers.php');
require_once('categories.php');

if(!isUserLoggedInAndAdmin()) {
    redirectToLogin(); 
}

$view = new stdClass();
$view->pageTitle = "Add New Facility - EcoBuddy System";
$view->categories = CATEGORIES;
$errorMessage = '';
$successMessage = '';

// Handle CRUD operations
$facilityDataSet = new FacilityDataSet();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the facility details from the form
    $facilityName = $_POST['facilityName'];
    $facilityCategory = $_POST['facilityCategory'];
    $facilityDescription = $_POST['facilityDescription'];
    $houseNumber = $_POST['houseNumber'];
    $streetName = $_POST['streetName'];
    $county = $_POST['county'];
    $town = $_POST['town'];
    $postcode = $_POST['postcode'];
    $longitude = $_POST['longitude'];
    $latitude = $_POST['latitude'];
    $contributor = getUser()['username']; // Assuming the contributor is the logged-in user

    try {
        // Add the new facility
        $isAdded = $facilityDataSet->addFacility($facilityName, $facilityCategory, $facilityDescription, $houseNumber, $streetName, $county, $town, $postcode, $longitude, $latitude, $contributor);
        if ($isAdded) {
            $successMessage = 'Facility added successfully!';
        } else {
            $errorMessage = 'Failed to add the facility.';
        }
        header('Location: dashboard.php'); // Redirect to the dashboard
        exit;
    } catch (Exception $e) {
        $errorMessage = 'An error occurred: ' . $e->getMessage();
        echo $errorMessage;
    }
}

// Load the add facility view
require_once('Views/facilities/facility-form.phtml');