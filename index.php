<?php
require_once("auth-helpers.php");

if(!isLoggedIn()) {
  header("Location: guestuser.php");
  exit;
} else {
  redirectToHomePage();
}
