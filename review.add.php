<?php
require_once('Models/Database.php');
require_once('Models/ReviewDataSet.php');
require_once('auth-helpers.php');

if(!isLoggedIn()) {
    redirectToLoginPage(); // Redirect to the login page if not logged in
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $review = $_POST['review'];
    $facilityId = $_POST['facility_id'];
    $userId = getUser()['id'];

    // Handle CRUD operations
    $reviewDataSet = new ReviewDataSet();

    try {
        $isUpdated = $reviewDataSet->addReview([
            'user_id' => $userId,
            'facility_id' => $facilityId,
            'review' => $review
        ]);

        header("Location: facility.view.php?facilityId=$facilityId");

        exit;
    } catch (Exception $e) {
        $errorMessage = 'An error occurred: ' . $e->getMessage();
        echo $errorMessage;
    }
}

