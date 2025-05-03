<?php
require_once("auth-helpers.php");

if(!isLoggedIn()) {
  header("Location: signin.php");
  exit;
} else {
  redirectToHomePage();
}
