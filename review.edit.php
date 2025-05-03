<?php
require_once('Models/Database.php');
require_once('Models/ReviewDataSet.php');

session_start(); 

if (!isset($_SESSION['loggedIn']) || !$_SESSION['loggedIn']) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $review = $_POST['review'];
    $userId = $_SESSION['userId'];
    $id = $_POST['id']; 

    $reviewDataSet = new ReviewDataSet();

    try {
        $isUpdated = $reviewDataSet->updateReview($id, $userId, $review);
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

