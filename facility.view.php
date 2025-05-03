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
    $view->pageTitle = "View Facility - EcoBuddy System";
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


// Load the edit facility view
require_once('Views/facilities/facility-form.view.phtml');