<?php

require __DIR__ .'/../boot/boot.php';

use Hotel\User;

// Check for existing logged in user
if (!empty(User::getCurrentUserId())) {
    header('Location: /collegelink/public/index.php'); die;
}

?>

<!DOCTYPE>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="robots" content="noindex,nofollow">
        <title>Sign Up</title>
        <style type="text/css">
            body {
                background: #333;
            }
        </style>
        <script src="assets/js/scripts.js" type="text/javascript"></script>
    </head>
    <body>
        <header>
            <div class="container">
                <p class="main-logo"><b>Hotels</b></p>
                <div class="primary-menu text-right">
                    <ul>
                        <li>
                            <a style="color: white;" href="index.php" target="">
                                <i class="fas fa-home"></i>
                                Home
                            </a>
                        </li>
                        <li>
                            <a style="color: white;" href="login.php" target="">
                                Sign In
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </header>
        <main class="main-content">
            <nav></nav>
            
            <section class="signup">
                <form method="post" action="actions/register.php">
                    <?php if (!empty($_GET['error'])) { ?>
                    <div class="">Register Error</div>
                    <?php } ?>
                    <fieldset class="introduction" id="form-introduction">
                        <div class="form-group">
                            <label for="name"><span>*</span>Name:</label>
                            <input name="name" style="color: black;" id="name" value="" placeholder="ex. John" type="text" required data-name data-chart data-mywebsite-name>
                        </div>
                        <div class="form-group email">
                            <label for="emailAddress"><span>*</span>E-mail:</label>
                            <input name="email" style="color: black;" id="emailAddress" value="" placeholder="ex. abc@example.com" type="email" required>
                        </div>
                        <div class="form-group email">
                            <label for="emailAddress"><span>*</span>Confirm E-mail:</label>
                            <input name="email_repeat" style="color: black;" id="confirmemailAddress" value="" placeholder="ex. abc@example.com" type="email" required>
                        </div>
                        <div class="form-group password">
                            <label for="formPassword"><span>*</span>Password:</label>
                            <input style="color: black;" name="formPassword" id="formPassword" value="" type="password" required>
                        </div>
                        <div class="action text-center">
                            <button type="submit">Sign Up</button>                        
                        </div>
                        
                    </fieldset>
                </form>
            </section>
        </main>
        <footer>
            <p>(c) Copyright Konstantinos Tsimvrakidis 2022</p>
        </footer>

        <link rel="stylesheet" href="assets/css files/fontawesome.min.css" />
        <link href="styles-register.css" type="text/css" rel="stylesheet" />
        <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous"> -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    </body>
</html>