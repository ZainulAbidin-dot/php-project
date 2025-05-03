<?php

session_start(); // Start session to manage logged-in users

function isUserLoggedInAndAdmin(): bool {
  
  $user = $_SESSION['user'] ?? null;

  return $user && $user['role'] === 'admin';
}

function isLoggedIn(): bool {
  return isset($_SESSION['user']);
}

function redirectToLogin() {
  header('Location: signin.php'); // Redirect to login page if not logged in
  exit;
}


function redirectToHomePage() {
  $is_admin = $_SESSION['user']['role'] === 'admin';
  
  if ($is_admin) {
    header('Location: dashboard.php'); 
  } else {
    header('Location: guestuser.php'); 
  }
}

function getUser() {
  return $_SESSION['user'] ?? null; 
}