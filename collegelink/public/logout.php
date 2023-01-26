<?php


require __DIR__.'/../boot/boot.php';

use Hotel\User;

session_start();

// Unset session variables
unset($_SESSION['user_id']);
unset($_COOKIE['user_token']);

// Destroy session
session_destroy();

// Delete cookie
setcookie('user_token', '', time() - 3600);


// Redirect to login page
header('Location: login.php');
exit;
