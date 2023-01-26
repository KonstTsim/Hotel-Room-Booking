<?php

require __DIR__. '/../boot/boot.php';

use Hotel\Room;
use Hotel\Favorite;
use Hotel\Review;
use Hotel\User;
use Hotel\Booking;

//Initialize Room service
$room = new Room();
$favorite = new Favorite();

// Check for room id
$roomId = $_REQUEST['room_id'];
if (empty($roomId)){
    header('Location: index.php');
    return;
}

// Load room info
$roomInfo = $room->get($roomId);
if (empty($roomInfo)){
    header('Location: index.php');
    return;
}

// Get current user Id
$userId = User::getCurrentUserId();


// Check if room is favorite for current user
$isFavorite = $favorite->isFavorite($roomId, $userId);


// Load all reviews
$review = new Review();
$allReviews = $review->getReviewsByRoom($roomId);

// Check for booking room
$checkInDate = $_REQUEST['check_in_date'];
$checkOutDate = $_REQUEST['check_out_date'];
$alreadyBooked = empty($checkInDate) || empty($checkOutDate);
if (!$alreadyBooked) {
    // Look for bookings
    $booking = new Booking();
    $alreadyBooked = $booking->isBooked($roomId, $checkInDate, $checkOutDate);
}


?>



<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="robots" content="noindex,nofollow">
        <title>Room page</title>
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
                            <a href="index.php" target="">
                                <i class="fas fa-home"></i>
                                Home
                            </a>
                        </li>
                        <li>
                            <a href="Profile.php" target="">
                                <i class="fas fa-user"></i>
                                Profile
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </header>


        <div class="container container-hero">
            
            <form class="changedate" action="room.php?room_id=<?php echo $roomId."&check_in_date=".$checkInDate."&check_out_date=".$checkOutDate; ?>">
                <input type="hidden" name="room_id" value="<?php echo $roomId; ?>">    
                <div class="form-group">
                    <label for="check-in"><b>Change the check-in date</b></label>
                    <input type="date" class="form-control" id="check-in" name="check_in_date" placeholder="Check-in Date">
                </div>
                <div class="form-group">
                    <label for="check-out"><b>Change the check-out date</b></label>
                    <input type="date" class="form-control" id="check-out" name="check_out_date" placeholder="Check-out Date">
                </div>
                <div>
                <button class="go fa fa-arrow-right"><a href="room.php?room_id=<?php echo $roomId."&check_in_date=".$checkInDate."&check_out_date=".$checkOutDate; ?>" ></a></button>
    
                <!-- <button type="submit" class="go fa fa-arrow-right"></button> -->
                </div>
            </form>
            <br>
            <hr>

            <!-- Title -->
            <section>
                <div class="title">
                    <?php echo sprintf('%s - %s, %s', $roomInfo['name'], $roomInfo['city'], $roomInfo['area']) ?> |    
                    <div class="title-reviews">
                        <span>Reviews:</span>
                        <?php
                            $roomAvgReview = $roomInfo['avg_reviews'];
                            for ($i = 1; $i <= 5; $i++) {
                                if($roomAvgReview >= $i) {
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
                    </div>
                    <div class="title-reviews" id="favorite">
                        <form name="favoriteForm" method="post" id="favoriteForm" class="favoriteForm" action="actions/favorite.php">
                            <input type="hidden" name="room_id" value="<?php echo $roomId; ?>">
                            <input type="hidden" name="is_favorite" value="<?php echo $isFavorite ? '1' : '0'; ?>">
                            <div class="search_stars_div">
                                <ul class="fav_star">
                                    <li>|</li>
                                    <li class="star fa fa-heart <?php echo $isFavorite ? 'selected' : ''; ?>" id="fav"></li>
                                </ul>
                            </div>
                        </form>
                    </div>
                    <div class="title-price">Per Night: <?php echo $roomInfo['price'];?>€</div>
                </div>
            </section>

            <!-- Photo -->
            <section class="room-photo">
                    <?php   if ($roomInfo['room_id'] == 1) {
                                ?>
                                <img alt="Room Name" class="room-image" src="assets/images/rooms/room-1.jpg">
                                <?php
                            } elseif ($roomInfo['room_id'] == 2) {
                                ?>
                                <img alt="Room Name" class="room-image" src="assets/images/rooms/room-2.jpg">
                                <?php
                            } elseif ($roomInfo['room_id'] == 3) {
                                ?>
                                <img alt="Room Name" class="room-image" src="assets/images/rooms/room-3.jpg">
                                <?php
                            } elseif ($roomInfo['room_id'] == 4) {
                                ?>
                                <img alt="Room Name" class="room-image" src="assets/images/rooms/room-4.jpg">
                                <?php
                            } elseif ($roomInfo['room_id'] == 5) {
                                ?>
                                <img alt="Room Name" class="room-image" src="assets/images/rooms/room-5.jpg">
                                <?php
                            } elseif ($roomInfo['room_id'] == 6) {
                                ?>
                                <img alt="Room Name" class="room-image" src="assets/images/rooms/room-6.jpg">
                                <?php
                            } elseif ($roomInfo['room_id'] == 7) {
                                ?>
                                <img alt="Room Name" class="room-image" src="assets/images/rooms/room-7.jpg">
                                <?php
                            } elseif ($roomInfo['room_id'] == 8) {
                                ?>
                                <img alt="Room Name" class="room-image" src="assets/images/rooms/room-8.jpg">
                                <?php
                            } elseif ($roomInfo['room_id'] == 9) {
                                ?>
                                <img alt="Room Name" class="room-image" src="assets/images/rooms/room-9.jpg">
                                <?php
                            } elseif ($roomInfo['room_id'] == 10) {
                                ?>
                                <img alt="Room Name" class="room-image" src="assets/images/rooms/room-10.jpg">
                                <?php
                            } ?>      
            </section>

            <!-- Info -->
            <section class="room-info">
                <div class="container-room-info">
                    <div class="guests_number">
                            <span class="fa fa-user"></span>
                            <span><?php echo $roomInfo['count_of_guests'];?></span>
                            <br>
                            <span>Count of Guests</span>
                    </div>
                    <div class="room_type">
                            <span class="fa fa-bed"></span>
                            <span><?php echo $roomInfo['type_id'];?></span>
                            <br>
                            <span>Room Type</span>
                    </div>
                    <div class="parking">
                            <i class="fa fa-car"></i>
                            <span><?php echo $roomInfo['parking'];?></span>
                            <br>
                            <span>Parking</span>
                    </div>
                    <div class="wifi">
                            <i class="fa fa-wifi"></i>
                            <span><?php if ($roomInfo['wifi'] == 0) {
                                            echo "No";
                                        } else{
                                            echo "Yes";
                                        }
                                    ?></span>
                            <br>
                            <span>Wifi</span>
                    </div>
                    <div class="pet">
                            <i class="fa fa-paw"></i>
                            <span><?php if ($roomInfo['pet_friendly'] == 0) {
                                            echo "No";
                                        } else{
                                            echo "Yes";
                                        }
                                    ?></span>
                            <br>
                            <span>Pet Friendly</span>
                    </div>
                </div>
            </section>

            <!-- Room description -->
            <section>
                <div class="container-room-description">
                    <h3><b>Room Description</b></h3>  
                    <br>
                        <p class="description"><?php echo $roomInfo['description_long'] ?></p>
                        <button class="toggle-description-button">Show more</button>
            </div>                   
            </section>

            <!-- links -->
            <br>
            <div class="links">
                <?php
                    if ($alreadyBooked) {
                ?>
                    <span style="background-color:red; color:white; font-weight: 600;" class="btn btn-brick button-disabled">Already Booked</span>
                <?php   
                    } else {
                ?>
                    <form name="bookingForm" method="post" action="actions/book.php">
                        <input type="hidden" name="room_id" value="<?php echo $roomId ?>">
                        <input type="hidden" name="check_in_date" value="<?php echo $checkInDate; ?>">
                        <input type="hidden" name="check_out_date" value="<?php echo $checkOutDate; ?>">
                        <button class="book-button" type="submit">Book Now</button>
                    </form>
                <?php
                    }
                ?>
            </div>    
            <br>
            <hr>
            <div id="googleMap" style="width:100%;height:400px;" class="googlemaps"></div>     
            <hr>

            <!-- Reviews -->
            <div class="caption">
                <h3>Reviews</h3>
                <br>
                <div id="room-reviews-container">
                    <?php
                        foreach (array_reverse($allReviews) as $counter => $review) {
                    ?>
                        <div class="room-reviews">
                            <h4>
                                <span><?php echo sprintf('%d. %s', $counter + 1, $review['user_name']); ?></span>
                                <div class="div-reviews">
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
                                </div>
                            </h4>
                            <h5>Created at: <?php echo $review['created_time']; ?></h5>
                            <p><?php echo htmlentities($review['comment']); ?></p>
                        </div>
                    <?php
                        }
                    ?>
                </div>
            </div>
            <hr>
            <div class="caption caption-room">
                <h3>Add review</h3>
                <br>
                <form name="reviewForm" class="reviewForm" method="post" action="actions/review.php">
                    <input type="hidden" name="room_id" value="<?php echo $roomId ?>">
                    <input type="hidden" name="csrf" value="<?php echo User::getCsrf(); ?>">
                    <h4>
                        <fieldset class="rating">   
                            <input type="radio" id="star5" name="rate" value="5" />
                            <label class = "full" for="star5" title="Awesome - 5 stars"></label>
                            <input type="radio" id="star4" name="rate" value="4" />
                            <label class = "full" for="star4" title="Pretty good - 4 stars"></label>
                            <input type="radio" id="star3" name="rate" value="3" />
                            <label class = "full" for="star3" title="Meh - 3 stars"></label>
                            <input type="radio" id="star2" name="rate" value="2" />
                            <label class = "full" for="star2" title="Kinda bad - 2 stars"></label>
                            <input type="radio" id="star1" name="rate" value="1" />
                            <label class = "full" for="star1" title="Sucks big time - 1 star"></label>
                        </fieldset>
                    </h4>
                    <br>
                    <div class="floating-label-form-group controls">
                        <textarea name="comment" id="reviewField" class="form-control_landing review-textarea" placeholder="Review" data-validation-required-message="Please enter a review."></textarea>
                    </div>
                    <div class="form-group_landing">
                        <button class="submit-button" type="submit">Submit</button>
                    </div>
                </form>
            </div>

        </div>
        <footer>
            <p>(c) Copyright Konstantinos Tsimvrakidis 2022</p>
        </footer>
    </body>
        
    <link rel="stylesheet" href="assets/css files/fontawesome.min.css" />
    <link rel="stylesheet" href="assets/css files/fontawesome.min.css" />
    <link href="styles-room.css" type="text/css" rel="stylesheet" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAGuGnuryqXwhgDytzFf6kn99vVAasw6jM"></script>
    <script src="assets/pages/room.js"></script>
    
    <script>
    function myMap() {
    var mapProp= {
    center:new google.maps.LatLng(51.508742,-0.120850),
    zoom:5,
    };
    var map = new google.maps.Map(document.getElementById("googleMap"),mapProp);
    }
    </script>

    <script>
        const toggleButton = document.querySelector('.toggle-description-button');
        const description = document.querySelector('.description');

        toggleButton.addEventListener('click', function() {
        // Toggle the 'full' class on the description
        description.classList.toggle('full');
        // Update the button text
        if (description.classList.contains('full')) {
            toggleButton.textContent = 'Show less';
        } else {
            toggleButton.textContent = 'Show more';
        }
        });
    </script>

    <script>
        var element = document.querySelector('.star');
        element.addEventListener('click', function toggleFavorite(e) {
            e.target.classList.toggle('selected');
        });
    </script>

    <script type="text/javascript">
        var element = document.querySelector('#favoriteForm');
        element.addEventListener('click', function(event) {
            event.preventDefault();
            this.submit();
        });
    </script>

    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY&callback=myMap"></script>