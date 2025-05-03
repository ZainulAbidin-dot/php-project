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
    // Validate the password
    if (strlen($password) < 12) {
        $errorMessage = 'Password must be at least 12 characters long.';
    } elseif (!preg_match('/[A-Z]/', $password)) {
        $errorMessage = 'Password must include at least one uppercase letter.';
    } elseif (!preg_match('/[a-z]/', $password)) {
        $errorMessage = 'Password must include at least one lowercase letter.';
    } elseif (!preg_match('/[0-9]/', $password)) {
        $errorMessage = 'Password must include at least one number.';
    } elseif (!preg_match('/[\W_]/', $password)) {
        $errorMessage = 'Password must include at least one symbol.';
    }

    // If there's an error, stop further execution
    if (!empty($errorMessage)) {
        $view->errorMessage = $errorMessage;
        require_once('Views/signup.phtml');
        exit;
    }

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
        $view->errorMessage = $errorMessage;
    } else {
        $user = $userDataSet->addUser($_POST['username'], $_POST['password'], 'user');

        // set the user in the session
        $_SESSION['user'] = $user->toObject();

        header('Location: guestuser.php'); // Redirect to the dashboard page
        exit;
    }
}

// Load the signup page view
require_once('Views/signup.phtml');
