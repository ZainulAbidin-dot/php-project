<?php
require_once('Models/Database.php');
require_once('Models/FacilityDataSet.php');
require_once('auth-helpers.php');
require_once('categories.php');


if(!isUserLoggedInAndAdmin()) {
    redirectToLogin(); 
}

// Check if user is logged in and has the right role
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: signin.php'); // Redirect to login page if not logged in or not an admin
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $view = new stdClass();
    $view->pageTitle = "Edit Facility - EcoBuddy System";
    $errorMessage = '';
    $successMessage = '';

    // Handle CRUD operations
    $facilityDataSet = new FacilityDataSet();

    // Check if a facility ID is provided
    if (!isset($_GET['facilityId'])) {
        header('Location: dashboard.php'); // Redirect to dashboard if no facility ID is provided
        exit;
    }

    $facilityId = $_GET['facilityId'];

    // Fetch the existing facility details
    $facility = $facilityDataSet->fetchFacilityByID($facilityId);

    if (!$facility) {
        $errorMessage = 'Facility not found.';
        echo $errorMessage;
        exit;
    }

    $view->facility = $facility; // Pass the facility details to the view
    $view->categories = CATEGORIES;;
} 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the updated facility details from the form
    $facilityId = $_POST['id'];
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

    // Handle CRUD operations
    $facilityDataSet = new FacilityDataSet();

    try {
        // Update the facility
        $isUpdated = $facilityDataSet->updateFacility($facilityId, $facilityName, $facilityCategory, $facilityDescription, $houseNumber, $streetName, $county, $town, $postcode, $longitude, $latitude);

        header('Location: dashboard.php'); // Redirect to the dashboard
        exit;
    } catch (Exception $e) {
        $errorMessage = 'An error occurred: ' . $e->getMessage();
        echo $errorMessage;
    }
}

// Load the edit facility view
require_once('Views/facilities/facility-form.edit.phtml');