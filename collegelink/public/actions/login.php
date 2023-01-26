<?php

//boot application
require_once __DIR__ . '/../../boot/boot.php';

use Hotel\User;

// Return to home page if not a post request
if (strtolower($_SERVER['REQUEST_METHOD']) != 'post'){
    header('Location: /');

    return;
}

// If there is already logged in user, return to main page
if (!empty(User::getCurrentUserId())) {
    header('Location: /');

    return;
}

// Verify user
// $user = new User();
// try {
//     if (!$user->verify($_REQUEST['email'], $_REQUEST['password'])) {
//         header('Location: /login.php?error=Could not verify user');

//         return;
//     }
// } catch (InvalidArgumentException $ex) {
//     header('Location: /login.php?error=No user exists with the given email');
    
//     return;
// }

// Create token as cookie for user, for 30 days
// Retrieve user
$userInfo = $user->getByEmail($_REQUEST['email']);

// Generate token
$token = $user->generateToken($userInfo['user_id']);

// Set cookie
setcookie('user_token', $token, time() + (30 * 24 * 60 * 60), '/');

// Return to home page
header('Location: /collegelink/public/index.php');


