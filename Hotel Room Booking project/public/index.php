<?php

require __DIR__.'/../boot/boot.php';

use Hotel\Room;
use Hotel\User;
use Hotel\RoomType;

$user = new User();
$token = $_COOKIE['user_token'];

// Get cities
$room = new Room();
$cities = $room->getCities();

// Get all room types
$type = new RoomType();
$allTypes = $type->getAllTypes();

?>

<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="utf-8">
        <meta name="description" contents="">
        <meta name="author" content="collegelink">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta http-equiv="X-UA-compatible" content="IE=edge">
        <meta name="robots" content="noindex,nofollow">
        <title>Home Page</title>
    </head>
    <body>
        <header>
            <div class="container">
                <p class="main-logo"><b>Hotels</b></p>
                <div class="primary-menu text-right">
                <ul>
                    <li>
                    <a href="index.php" target="">
                        <i class="fas fa-home"></i>
                        Home
                    </a>
                    </li>
                    <?php // Check for existing logged in user
                    if ($user->verifyToken($token)) {
                    ?>
                    <li>
                    <a href="profile.php" target="">
                        <i class="fas fa-user"></i>
                        Profile
                    </a>
                    </li>
                    <li>
                    <a href="logout.php" target="">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Sign out</span>
                    </a>
                    </li>
                    <?php
                    } else {
                    ?>
                    <li>
                    <a href="register.php" target="">
                        Sign Up
                    </a>
                    <a href="login.php" target="">
                        Log In
                    </a>
                    </li>
                    <?php
                    }
                    ?>
                </ul>
                </div>
            </div>
        </header>

        <main class="main-content view_hotel page-home">

            <!-- Main section start -->
            <section class="hero">

                <!-- This is the page's title -->
                <h1>Find your room!</h1>

                <!-- Form section start -->
                <form name="searchForm" action="list.php" onsubmit="return validateForm()">
                    <fieldset class="introduction" id="form-introduction">
                        
                        <div class="form-group city" title="City">
                            <label for="sel1"></label>
                            <select name="city" class="form-control" id="sel1" data-placeholder="City" required>
                                <option value="" selected>City</option>
                                <?php
                                    foreach ($cities as $city) {
                                ?>
                                    <option value="<?php echo $city; ?>"><?php echo $city; ?></option>
                                <?php
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group room" title="Room">
                        <label for="sel1"></label>
                        <select class="form-control" id="sel2" name="room_type" data-placeholder="Room Type">
                        <option value="" selected>Room Type</option>
                            <?php
                                foreach ($allTypes as $roomType) {
                            ?>
                                <option value="<?php echo $roomType['type_id']; ?>"><?php echo $roomType['title']; ?></option>
                            <?php
                                }
                            ?>
                        </select>
                        </div>
                        
                        <div class="form-group">
                            <label style="color:white;" for="check-in">Check-in date</label>
                            <input type="date" class="form-control" id="check-in" name="check_in_date" placeholder="Check-in Date" required>
                        </div>
                        <div class="form-group">
                            <label style="color:white;" for="check-out">Check-out date</label>
                            <input type="date" class="form-control" id="check-out" name="check_out_date" placeholder="Check-out Date" required>
                        </div>
                        <p id="check_in_date_error" class="text-danger"></p>
                        <p id="check_out_date_error" class="text-danger"></p>



                        <div class="action">
                            <button type="submit">Search</button>
                        </div>
                    </fieldset>
                </form>
            </section>
        </main>
        <footer>
            <p><b>(c)</b> Copyright Konstantinos Tsimvrakidis 2022</p>
        </footer>

        

        <link rel="stylesheet" href="assets/css files/fontawesome.min.css" />
        <link href="styles-index.css" type="text/css" rel="stylesheet" />
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/jquery.validate.min.js"></script>
      
        <script type="text/javascript">

            $(document).ready(function() {
                $('form').validate();
            });

            var check_in_date = document.forms["searchForm"]["check_in_date"];
            var check_out_date = document.forms["searchForm"]["check_out_date"];
            // var city = document.forms["searchForm"]["city"];

            var check_in_date_error = document.getElementById("check_in_date_error");
            var check_out_date_error = document.getElementById("check_out_date_error");
            // var city_error = document.forms["searchForm"]["city_error"];

            function validateForm() {
                if (check_in_date.value === "") {
                    check_in_date_error.textContent = "Please enter a check-in Date."
                    check_in_date.focus();
                    return false;
                }
                if (check_out_date.value === "") {
                    check_out_date_error.textContent = "Please enter a check-out Date."
                    check_out_date.focus();
                    return false;
                }
                // if (city.value === "") {
                //     city_error.textContent = "Please select a city."
                //     city.focus();
                //     return false;
                // }
            }
            check_in_date.addEventListener("input", function () {
                check_in_date_error.textContent = "";
            });

            check_out_date.addEventListener("input", function () {
                check_out_date_error.textContent = "";
            });
            
            // city.addEventListener("input", function () {
            //     city_error.textContent = "";
            // });
        </script>
      

    </body>
</html>

