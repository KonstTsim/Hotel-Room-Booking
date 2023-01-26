<?php

require __DIR__. '/../boot/boot.php';

use Hotel\Favorite;
use Hotel\Review;
use Hotel\User;
use Hotel\Booking;

// Check for room logged in user
$userId = User::getCurrentUserId();
if (empty($userId)) {
    header('Location: index.php');
    return;
}

// Get all favorites
$favorite = new Favorite();
$userFavorites = $favorite->getListByUser($userId);

// Get all reviews
$review = new Review();
$userReviews = $review->getListByUser($userId);

// Get all user bookings
$booking = new Booking();
$userBookings = $booking->getListByUser($userId);


?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="robots" content="noindex,nofollow">
        <title>Hotel List</title>
        <style type="text/css">
            body {
                background: #333;
            }
        </style>
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
                        <!-- <li>
                            <a href="Profile.php" target="">
                                <i class="fas fa-user"></i>
                                Profile
                            </a>
                                
                        </li> -->
                    </ul>
                </div>
            </div>
        </header>
        <main class="main-content view_hotel page-home">
            <nav></nav>

            <!-- Main section start -->
            <section class="hero">
            
                <!-- Aside section -->
                <div class="container">
                    <div class="container-hero">
                        <aside class="hotel-search box">
                            <div class="aside-heading">Favorites</div>
                            <?php
                                if (count($userFavorites) > 0) {
                            ?> 
                                <ol>
                                    <?php
                                        foreach (array_reverse($userFavorites) as $favorite) {
                                    ?>
                                    <li>
                                        <a class="link" href="room.php?room_id=<?php echo $favorite['room_id']; ?>"><?php echo $favorite['name']; ?></a>
                                    </li>
                                    <?php
                                        }
                                    ?>
                                </ol>    
                            <?php   
                                } else {
                            ?>
                                <h4 class="alert-profile">You don't have any favorite Hotel !</h4>
                            <?php   
                                }
                            ?>
                                <div class="aside-heading">Reviews</div>
                                <?php
                                    if (count($userReviews) > 0) {
                                ?>
                                <ol>
                                <?php
                                    foreach ($userReviews as $review) {
                                ?>
                                    <li>
                                        <a class="link" href="room.php?room_id=<?php echo $review['room_id']; ?>"><?php echo $review['name']; ?></a>
                                        <br>
                                        <?php
                                            for ($i = 1; $i <= 5; $i++) {
                                                if($review['rate'] >= $i) {
                                                    ?>
                                                    <span class="fa fa-star checked"></span>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <span class="fa fa-star"></span>
                                                    <?php
                                                }
                                            }
                                        ?>
                                    </li>
                                <?php
                                    }
                                ?>
                                </ol> 
                                <?php
                                    } else {
                                ?>
                                <h4 class="alert-profile">You haven't made any reviews yet !</h4>
                                <?php
                                    }
                                ?>

                        </aside>

                        <section class="hotel-list box inline-block align-top">
                            <header class="page-title">
                                <h2>My Bookings</h2>
                            </header>

                            <?php
                                if (count($userBookings) > 0) {
                            ?>

                            <article class="hotel">
                                <?php
                                    foreach ($userBookings as $booking) {
                                ?>
                                <aside class="media">
                                <img src="assets/images/rooms/<?php echo $booking['photo_url']; ?>" alt="Room image" width="100%" height="auto">
                                </aside>

                                
                                <main class="info">
                                    <h4 class="uppercase"><?php echo $booking['name']; ?><br>
                                        <small><?php echo sprintf('%s, %s', $booking['city'], $booking['area']); ?></small>
                                    </h4>
                                    <p><?php echo $booking['description_short']; ?></p>
                                    <div class="text-right">
                                        <button class="room_img"><a href="room.php?room_id=<?php echo $booking['room_id']; ?>" class="btn btn-brick button-profile_page">Go to Room Page</a></button>
                                    </div>
                                    <br>
                                    
                                </main>
                                <div class="property-info">
                                    <div class="cost">
                                        <div class="price-tag"><b>Total Cost: </b><?php echo $booking['total_price']; ?>€</div>
                                    </div>
                                    
                                    <div class="checkin">
                                        <span data-toggle="tooltip" data-placement="left"><b>Check-in Date: </b><?php echo $booking['check_in_date']; ?></span>
                                    </div>
                                    <div class="checkout">
                                        <span data-toggle="tooltip" data-placement="left"><b>Check-out Date: </b><?php echo $booking['check_out_date']; ?></span>
                                    </div>
                                    <div class="room-type">
                                        <span data-toggle="tooltip" data-placement="right"><b>Type of Room: </b><?php echo $booking['room_type']; ?></span>
                                    </div>
                                </div>
                                <br>
                                <hr>
                                <br>                                

                                <?php
                                    }
                                ?>
                            </article>
                            <?php
                                } else {
                            ?>
                            <h4 class="alert-profile">You don't have any bookings !</h4>
                            <?php
                                }
                            ?>
                        </section>
                    </div>
                </div>
            </section>

       
            <!-- Main section end -->
        </main>
        <footer>
            <p>(c) Copyright Konstantinos Tsimvrakidis 2022</p>
        </footer>

        <link rel="stylesheet" href="assets/css files/fontawesome.min.css" />
        <link href="styles-profile.css" type="text/css" rel="stylesheet" />
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    </body>
</html>
