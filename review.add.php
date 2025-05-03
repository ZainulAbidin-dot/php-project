<?php
require_once('Models/Database.php');
require_once('Models/ReviewDataSet.php');

session_start(); // Start session to manage logged-in users

// Check if the user is logged in
if (!isset($_SESSION['loggedIn']) || !$_SESSION['loggedIn']) {
    header('Location: index.php'); // Redirect to login page if not logged in
    exit;
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

