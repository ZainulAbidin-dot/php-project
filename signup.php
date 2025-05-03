<?php
require_once('Models/Database.php');
require_once 'Models/UserDataSet.php';



session_start(); // Start session to manage logged-in users
$view = new stdClass();
$view->pageTitle = "Signup - EcoBuddy System";
$errorMessage = '';

// Handle CRUD operations
$userDataSet = new UserDataSet();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the username and password from the form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Connect to the database
    $db = Database::getInstance()->getdbConnection();

    // Check if the username already exists
    $sqlQuery = 'SELECT * FROM users WHERE username = :username';
    $statement = $db->prepare($sqlQuery);
    $statement->bindValue(':username', $username);
    $statement->execute();
    $existingUser = $statement->fetch(PDO::FETCH_ASSOC);

    if ($existingUser) {
        $errorMessage = 'Username already exists. Please choose a different one.';
    } else {
        $user = $userDataSet->addUser($_POST['username'], $_POST['password'], 'user');

        $_SESSION['loggedIn'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['role'] = 'user';
        $_SESSION['userId'] = $user->getId();
        header('Location: guestuser.php'); // Redirect to the dashboard page
        exit;
    }
}

// Load the signup page view
require_once('Views/signup.phtml');
