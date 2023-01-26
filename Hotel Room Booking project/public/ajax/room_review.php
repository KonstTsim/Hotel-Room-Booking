<?php

use Hotel\User;
use Hotel\Review;

//boot application
require_once __DIR__ . '/../../boot/boot.php';


// Return to home page if not a post request
if (strtolower($_SERVER['REQUEST_METHOD']) != 'post') {
    echo "This is a post script.";
    die;
}

// If no user is logged in, return to main page
if (empty(User::getCurrentUserId())) {
    echo "No current user for this operation.";
    die;
}

// Check if room id is given
$roomId = $_REQUEST['room_id'];
if (empty($roomId)) {
    echo "No room is given for this operation.";
    die;
}

// Verify csrf
$csrf = $_REQUEST['csrf'];
if (empty($csrf) || !User::verifyCsrf($csrf)) {
    echo "This is an invalid request";
    return;
}

// Add review
$review = new Review();
$review->insert($roomId, User::getCurrentUserId(), $_REQUEST['rate'], $_REQUEST['comment']);

// Get all reviews
$roomReviews = $review->getReviewsByRoom($roomId);
$counter = count($roomReviews);

// Load user
$user = new User();
$userInfo = $user->getByUserId(User::getCurrentUserId());
?>

<div class="room-reviews">
    <h4>
        <span><?php echo sprintf('%d. %s', $counter, $userInfo['name']); ?></span>
        <div class="div-reviews">
        <?php
            for ($i = 1; $i <= 5; $i++) {
                if($_REQUEST['rate'] >= $i) {
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
    <h5>Created at: <?php echo (new DateTime())->format('Y-m-d H:i:s'); ?></h5>
    <p><?php echo $_REQUEST['comment']; ?></p>
</div>


