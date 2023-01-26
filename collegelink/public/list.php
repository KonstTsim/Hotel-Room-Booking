<?php

require __DIR__.'/../boot/boot.php';

use Hotel\Room;
use Hotel\RoomType;
// use DateTime;

//Initialize Room service
$room = new Room();

// Get all cities
$cities = $room->getCities();

// // Get number of guests
$guests = $room->getGuests();

// // Get all room types
$type = new RoomType();
$allTypes = $type->getAllTypes();

// Get page parameters
$selectedGuests = $_REQUEST['count_of_guests'];
$selectedCity = $_REQUEST['city'];
$selectedTypeId = $_REQUEST['room_type'];
$checkInDate = $_REQUEST['check_in_date'];
$checkOutDate = $_REQUEST['check_out_date'];
$minAmount = isset($_REQUEST['minAmount']) ? $_REQUEST['minAmount'] : 0;
$maxAmount = isset($_REQUEST['maxAmount']) ? $_REQUEST['maxAmount'] : PHP_INT_MAX;

// Search for room
$allAvailableRooms = $room->search(new DateTime($checkInDate), new DateTime($checkOutDate), $selectedCity, $selectedTypeId);

// Filter by price range
$filteredRooms = array_filter($allAvailableRooms, function($r) use ($minAmount, $maxAmount) {
  return $r['price'] >= $minAmount && $r['price'] <= $maxAmount;
});

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
        <main class="main-content view_hotel page-home">
            <nav></nav>

            <!-- Main section start -->
            <section class="hero">
            
                <div class="container">
                    <aside class="hotel-search box inline-block align-top">
                        <form name="AsideSearchForm" class="AsideSearchForm" action="list.php" onsubmit="return validateForm()">
                            <fieldset class="introduction" id="formSearch">
                                <div class="form-group text-center"> 
                                    <div class="plainText"><strong>Find the Perfect Hotel!</strong> </div>
                                    <div class="form-group GuestsNo">
                                        <label for="sel1"></label>
                                        <select class="form-control" name="count_of_guests" id="sel1" title="Guests" data-placeholder="Number of guests">
                                          <option value="" disabled selected>Number of Guests</option>
                                            <?php
                                                foreach ($guests as $guestNumber) {
                                            ?>
                                                <option <?php echo $selectedGuests == $guestNumber ? 'selected="selected"' : ''; ?> value="<?php echo $guestNumber; ?>"><?php echo $guestNumber; ?></option>
                                                
                                            <?php
                                                 }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group roomType">
                                        <label for="sel2"></label>
                                        <select class="form-control" id="sel2" name="room_type" title="RoomType" data-placeholder="Room Types">
                                          <option value="" disabled selected>Room Type</option>
                                            <?php
                                                foreach ($allTypes as $roomType) {
                                            ?>
                                                <option <?php echo $selectedTypeId == $roomType['title'] ? 'selected="selected"' : ''; ?> value="<?php echo $roomType['type_id']; ?>"><?php echo $roomType['title']; ?></option>
                                                
                                            <?php
                                                 }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group City">
                                        <label for="sel3"></label>
                                        <select class="form-control" id="sel3" name="city" title="City" data-placeholder="City">
                                            <option value="" disabled selected>City</option>
                                            <?php
                                                foreach ($cities as $city) {
                                            ?>
                                                <option <?php echo $selectedCity == $city ? 'selected="selected"' : ''; ?> value="<?php echo $city; ?>"><?php echo $city; ?></option>
                                            <?php
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="check-in">Check-in</label>
                                        <input type="date" value="<?php echo $checkInDate; ?>" class="form-control" id="check-in" name="check_in_date" placeholder="Check-in Date">
                                    </div>
                                    <p id="check_in_date_error" class="text-danger"></p>
                                    <div class="form-group">
                                        <label for="check-out">Check-out</label>
                                        <input type="date" value="<?php echo $checkOutDate; ?>" class="form-control" id="check-out" name="check_out_date" placeholder="Check-out Date">
                                    </div>
                                    <p id="check_out_date_error" class="text-danger"></p>
                                    
                                    <label for="priceRange">Price range:</label>
                                    <div id="slider-range"></div>
                                    <input type="text" id="amount" style="text-align:center;" readonly>
                                    <input type="hidden" id="minAmount" name="minAmount" value="0">
                                    <input type="hidden" id="maxAmount" name="maxAmount" value="500">
                                        

                                <div class="action">
                                    <button style="border-radius:8px;" class="button-search"><a type="submit">Search</a></button>
                                </div>
                        </form>
                    </aside>
                    
                    <!-- Available Rooms! -->

                    <section class="hotel-list box inline-block align-top" id="hotel-list">
                        <header class="page-title">
                            <h2>Search Results</h2>
                        </header>

                        <?php
                            foreach ($filteredRooms as $availableRoom) {
                        ?>
                        <article class="hotel">
                            <aside class="media">
                                <img src="assets/images/rooms/<?php echo $availableRoom['photo_url']; ?>" alt="Room image preview" width="100%" height="auto">
                            </aside>
                            <main class="info">
                                <h4 class="uppercase"><?php echo $availableRoom['name']; ?><br>
                                    <small><?php echo sprintf('%s, %s', $availableRoom['city'], $availableRoom['area']); ?></small>
                                </h4>
                                <p><?php echo $availableRoom['description_short']; ?></p>
                                <section class="room-info">
                                    <div class="container-room-info">
                                        <div class="guests_number">
                                                <span class="fa fa-user"></span>
                                                <span><?php echo $availableRoom['count_of_guests'];?></span>
                                                <br>
                                                <span>Count of Guests</span>
                                        </div>
                                        <div class="room_type">
                                                <span class="fa fa-bed"></span>
                                                <span><?php echo $availableRoom['type_id'];?></span>
                                                <br>
                                                <span>Room Type</span>
                                        </div>
                                        <div class="void"></div>
                                        <div class="void"></div>
                                        <div class="price">
                                                <span>Price per night</span>
                                                <br>
                                                <i class="fa fa-euro-sign"></i>
                                                <span><?php echo $availableRoom['price'];?></span>
                                        </div>
                                        
                                    </div>
                                </section>
                                <div class="text-right">
                                    <button class="room_img"><a href="room.php?room_id=<?php echo $availableRoom['room_id']."&check_in_date=".$checkInDate."&check_out_date=".$checkOutDate; ?>" class="btn btn-brick button-profile_page">Go to Room Page</a></button>
                                </div>
                            </main>
                            <div class="clear"></div>
                        </article>
                        <?php
                            }
                        ?>

                        <?php
                            if ($selectedGuests > $selectedTypeId){
                        ?>
                        <h2><strong>You may need to consider choosing a bigger room!</strong></h2>
                        <hr>
                        <?php
                            } else {
                            if (count($allAvailableRooms) == 0){
                        ?>
                        <h2><strong>There are no rooms available!</strong></h2>
                        <hr>
                        <?php
                            }
                        }
                        ?>
                            
                    </section>
                </div>
            </section>
            <!-- Main section end -->
        </main>
        <footer>
            <p>(c) Copyright Konstantinos Tsimvrakidis 2022</p>
        </footer>

        <link rel="stylesheet" href="assets/css files/fontawesome.min.css" />
        <link href="styles-list.css" type="text/css" rel="stylesheet" />
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous"> -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="/resources/demos/style.css">
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
        <script src="assets/pages/search.js"></script>
        
        <script type="text/javascript">
        $( function() {
            $( "#slider-range" ).slider({
            range: true,
            min: 0,
            max: 500,
            values: [ 0, 500 ],
            slide: function( event, ui ) {
                $( "#amount" ).val( "€" + ui.values[ 0 ] + " - €" + ui.values[ 1 ] );
                $( "#minAmount" ).val(ui.values[ 0 ]);
                $( "#maxAmount" ).val(ui.values[ 1 ]);
            }
            });
            $( "#amount" ).val( "€" + $( "#slider-range" ).slider( "values", 0 ) +
            " - €" + $( "#slider-range" ).slider( "values", 1 ) );
        } );

        $("#slider-range").on("slide", function() {
            $("form").submit();
        });
        </script>


        <script type="text/javascript">
            var check_in_date = document.forms["AsideSearchForm"]["check_in_date"];
            var check_out_date = document.forms["AsideSearchForm"]["check_out_date"];

            var check_in_date_error = document.getElementById("check_in_date_error");
            var check_out_date_error = document.getElementById("check_out_date_error");

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
                check_in_date.addEventListener("input", function () {
                check_in_date_error.textContent = "";
            });

            check_out_date.addEventListener("input", function () {
                check_out_date_error.textContent = "";
            });
            }
        </script>


    </body>
</html>
