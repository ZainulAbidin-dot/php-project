<?php
require_once('Models/Database.php');
require_once('Models/FacilityDataSet.php');

session_start(); // Start session to manage logged-in users

// Check if the user is logged in
if (!isset($_SESSION['loggedIn']) || !$_SESSION['loggedIn']) {
    header('Location: index.php'); // Redirect to login page if not logged in
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
    $view->categories = ['Transportation', 'Energy', 'Waste', 'Water'];
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
        // if ($isUpdated) {
        //     $successMessage = 'Facility updated successfully!';
        // } else {
        //     $errorMessage = 'Failed to update the facility.';
        // }
        header('Location: dashboard.php'); // Redirect to the dashboard
        exit;
    } catch (Exception $e) {
        $errorMessage = 'An error occurred: ' . $e->getMessage();
        echo $errorMessage;
    }
}

// Load the edit facility view
require_once('Views/facilities/facility-form.edit.phtml');