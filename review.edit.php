<?php
require_once('Models/Database.php');
require_once('Models/ReviewDataSet.php');
require_once('auth-helpers.php');

if(!isLoggedIn()) {
    redirectToLoginPage(); // Redirect to the login page if not logged in
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $review = $_POST['review'];
    $review_id = $_POST['review_id'];
    $facilityId = $_POST['facility_id'];

    try {
        $reviewDataSet = new ReviewDataSet();
        $isUpdated = $reviewDataSet->updateReview([
            'id' => $review_id,
            'review' => $review,
        ]);


        header("Location: facility.view.php?facilityId=$facilityId");

    } catch (Exception $e) {
        $errorMessage = 'An error occurred: ' . $e->getMessage();
        echo $errorMessage;
    }
}

