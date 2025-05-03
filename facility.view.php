<?php
require_once('Models/Database.php');
require_once('Models/FacilityDataSet.php');
require_once('Models/ReviewDataSet.php');

session_start(); // Start session to manage logged-in users

// Check if the user is logged in
// if (!isset($_SESSION['loggedIn']) || !$_SESSION['loggedIn']) {
//     header('Location: index.php'); // Redirect to login page if not logged in
//     exit;
// }

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $view = new stdClass();
    $view->pageTitle = "View Facility - EcoBuddy System";
    $errorMessage = '';
    $successMessage = '';

    // Handle CRUD operations
    $facilityDataSet = new FacilityDataSet();
    $reviewsDataSet = new ReviewDataSet();

    // Check if a facility ID is provided
    if (!isset($_GET['facilityId'])) {
        header('Location: dashboard.php');
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

    // $userId = $_SESSION['userId'];
    $reviews = $reviewsDataSet->fetchAllReviews();
    // echo reviews;
    $view->reviews = $reviews; // Pass the reviews to the view
} 


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the updated facility details from the form
    $review = $_POST['review'];
    $userId = $_SESSION['userId'];

    // Handle CRUD operations
    $reviewDataSet = new ReviewDataSet();

    try {
        $isUpdated = $reviewDataSet->addReview($userId, $review);
        // if ($isUpdated) {
        //     $successMessage = 'Facility updated successfully!';
        // } else {
        //     $errorMessage = 'Failed to update the facility.';
        // }
        
        header('Location: /guestuser.php'); // Redirect to the dashboard
        exit;
    } catch (Exception $e) {
        $errorMessage = 'An error occurred: ' . $e->getMessage();
        echo $errorMessage;
    }
}



// Load the edit facility view
require_once('Views/facilities/facility-form.view.phtml');