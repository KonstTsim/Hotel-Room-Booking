<?php

require __DIR__.'/../../boot/boot.php';

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