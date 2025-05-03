<?php
require_once('Models/Database.php');
require_once 'Models/UserDataSet.php';



session_start(); // Start session to manage logged-in users

$view = new stdClass();
$view->pageTitle = "Login - EcoBuddy System";
$errorMessage = '';

// Handle CRUD operations
$userDataSet = new UserDataSet();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the username and password from the form
    $username = $_POST['username'];
    $password = $_POST['password'];
    try {
        $user = $userDataSet->loginUser($username, $password);
        if ($user) {
            $_SESSION['loggedIn'] = true;
            $_SESSION['username'] = $user->getUsername(); // Assuming UserData has a getUsername() method
            header('Location: dashboard.php'); // Redirect to the dashboard
            exit;
        } else {
            $errorMessage = 'Invalid username or password';
        }
    } catch (Exception $e) {
        $errorMessage = 'An error occurred: ' . $e->getMessage();
    }
}
// Load the home page view
require_once('Views/index.phtml');
