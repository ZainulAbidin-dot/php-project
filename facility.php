<?php
require_once('Models/Database.php');
require_once ('Models/FacilityDataSet.php');

session_start(); // Start session to manage logged-in users

// Check if the user is logged in
if (!isset($_SESSION['loggedIn']) || !$_SESSION['loggedIn']) {
    header('Location: index.php'); // Redirect to login page if not logged in
    exit;
}

$view = new stdClass();
$view->pageTitle = "Add New Facility - EcoBuddy System";
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
    $contributor = $_SESSION['username'];

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