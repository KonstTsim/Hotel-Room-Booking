<?php

//boot application
require_once __DIR__ . '/../../boot/boot.php';

use Hotel\User;

// Return to home page if not a post request
if (strtolower($_SERVER['REQUEST_METHOD']) != 'post'){
    header('Location: /');

    return;
}

// Create new user
$user = new User();
$user->insert($_REQUEST['name'], $_REQUEST['email'], $_REQUEST['password']);

// Retrieve user
$userInfo = $user->getByEmail($_REQUEST['email']);

// Generate token
$token = $user->generateToken($userInfo['user_id']);

// Set cookie
setcookie('user_token', $token, time() + (30 * 24 * 60 * 60), '/');

// Return to home page
header('Location: /collegelink/public/index.php');
