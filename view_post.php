<?php
// Start the session
session_start();
include "db_connect.php";


// Initialize variables
$post_results = null;
$num_rows = 0;

// Check if the request method is GET and if 'id' is set
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {

    if (isset($_SESSION['id']) && isset($_GET['noid'])) {
        $notification_id = intval($_GET['noid']);
    
        // Prepare the SQL statement to prevent SQL injection
        
        $updateNotificationSql = "UPDATE post_notification JOIN post ON post_notification.post_id = post.id SET post_notification.seen = 1 WHERE post_notification.id = ".$notification_id." AND post.uid = ".$_SESSION['id']." AND post_notification.seen = 0;";
        
                            
        $conn->query($updateNotificationSql);
        
        
    }
    $post_id = intval($_GET['id']);

    // Prepare the SQL statement to prevent SQL injection
    
    $sql = "SELECT post.id AS post_id, users.id AS user_id, post.*, users.*, TIMESTAMPDIFF(SECOND, post.created_at, NOW()) AS time_elapsed_seconds FROM post JOIN users ON post.uid = users.id WHERE post.id = ".$post_id;

    $post_results = $conn->query($sql);
    
    
} else {
    // Fetch all posts if 'id' is not set
    header("Location: index.php");
    
}




?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courier</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script defer src="./JS/countries.js"></script>

    <style>
        body {
            font-family: Helvetica, Arial, sans-serif;
        }

        .card-header h4 {
            font-family: Helvetica, Arial, sans-serif;
        }

        .card-header span {
            font-family: Helvetica, Arial, sans-serif;
        }
        .rounded-buttons .btn {
            border-radius: 20px; /* Adjust the border-radius value for desired roundness */
        }
        .cover-section {
            background-image: url('./assets/images/blulaggon_cover.jpg'); /* Your background image URL */
            background-size: cover;
            padding-bottom: 80px;
            
            margin: 0;
            
        }
        
        .typing-effect {
            font-size: 3em;
            text-align: center;
            overflow: hidden;
            border-right: .15em solid orange;
            white-space: nowrap;
            margin: 0 auto;
            letter-spacing: .15em;
            animation: typing 3.5s steps(40, end), blink-caret .75s step-end infinite;
        }

        /* The typing effect animation */
        @keyframes typing {
            from {
                width: 0;
            }
            to {
                width: 100%;
            }
        }

        /* The blinking cursor animation */
        @keyframes blink-caret {
            from, to {
                border-color: transparent;
            }
            50% {
                border-color: orange;
            }
        }
        .transparent {
            background-color: rgba(255, 255, 255, 0.0); /* Set background color with transparency */
            
        }
        .transparent-header {
            background-color: transparent !important; /* Important to override default Bootstrap styling */
        }
        header-option-btn{
            border-radius: 50%;
        }
        .navbar-profile-image {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            object-fit: cover;
        }

        .post-card {
            margin-top: 20px; /* Add 20px top margin */
            border: 1px solid #ced4da; /* Add 1px border */
            border-radius: 8px; /* Add rounded corners */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Add shadow */
        }
        
        .card-body {
            padding-top: 20px; /* Add 20px top padding to the card body */
        }

        .popup {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0,0,0,0.4);
        }

        


        .popup-content {
        background-color: #fefefe;
        margin: 20% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        }

        .form-row {
        display: flex;
        flex-wrap: wrap;
        }

        .form-group {
        flex: 0 0 50%; /* Each element takes 50% width */
        margin-bottom: 10px;
        }

        button {
        background-color: #007bff;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        }

        button:hover {
        background-color: #0056b3;
        }

        .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
        }

        .close:hover,
        .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
        }
        select{
            border-radius:10px;
            height:20px;
            width:200px;
            
        }
        .btn-parcel-type:hover,
        .btn-parcel-type:active {
            background-color: #018CA2;
            color: white;
            border-color: #015F6A;
        }
        .btn-parcel-type{
            background-color: #fff;
            border-color: black;
            color: black;
        }
        .rounded-buttons .btn {
            border-radius: 30px; /* Adjust the border radius as needed */
        }
        .rounded-buttons .btn.btn-filled {
            background-color: #007bff; /* Change the background color as needed */
            color: #fff; /* Change the text color as needed */
        }
        .rounded-buttons .btn.btn-filled:hover {
            background-color: #0056b3; /* Change the hover background color as needed */
        }

        .rating {
            unicode-bidi: bidi-override;
            direction: rtl; /* Change direction to right-to-left */
            text-align: left; /* Align text to left */
        }

        .rating > input {
            display: none;
        }

        .rating > label {
            float: right; /* Float labels to the right */
            padding: 0 0.1em;
            font-size: 21px; /* Adjusted font-size to make stars 30% smaller */
            color: #888;
            cursor: default;
        }

        .rating > label:before {
            content: "\2605"; /* Star icon */
        }

        .rating > input:checked ~ label,
        .rating:not(:checked) > label:hover,
        .rating:not(:checked) > label:hover ~ label {
            color: #1877F2; /* Color of selected/starred icons */
        }

        .rating > input:checked + label:hover,
        .rating > input:checked ~ label:hover,
        .rating > label:hover ~ input:checked ~ label,
        .rating > input:checked ~ label:hover ~ label {
            color: #1877F2; /* Color of hovered icons when selected */
        }

        .rate {
            float: left;
            height: 26px;
            padding: 0 ;
        }
        .rate:not(:checked) > input {
            position:absolute;
            top:-9999px;
        }
        .rate:not(:checked) > label {
            float:right;
            width:1em;
            overflow:hidden;
            white-space:nowrap;
            cursor:pointer;
            font-size:20px;
            color:#ccc;
        }
        .rate:not(:checked) > label:before {
            content: '★ ';
        }
        .rate > input:checked ~ label {
            color: #ffc700;    
        }
        .rate:not(:checked) > label:hover,
        .rate:not(:checked) > label:hover ~ label {
            color: #1877F2;  
        }
        .rate > input:checked + label:hover,
        .rate > input:checked + label:hover ~ label,
        .rate > input:checked ~ label:hover,
        .rate > input:checked ~ label:hover ~ label,
        .rate > label:hover ~ input:checked ~ label {
            color: #c59b08;
        }
        .post-card-footer {
            display: flex;
            justify-content: space-between;
            padding: 10px;
            background-color: #f8f9fa;
        }
        .button-container, .number-container {
            display: flex;
            padding:0;
            align-items: center;
        }
        .button-container .btn {
            margin-right: 10px;
            
            display: flex;
            align-items: center;
        }
        .number-container p {
            margin: 0;
            font-weight: bold;
            color: gray;
        }
        .comment-post {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 15px;
        }

        .comment-item {
            display: flex;
            align-items: flex-start;
        }

        .comment-item img {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .comment-item div {
            flex: 1;
        }

        .comment-item b {
            color: #333;
        }

        .comment-item p {
            margin-top: 5px;
            color: #666;
        }

        .comment-box {
            margin-top: 10px;
            border-radius: 20px;
            overflow: hidden;
            border: 1px solid #ccc; /* Add gray border */
        }

        .comment-box textarea {
            width: calc(100% - 20px);
            padding: 10px;
            border: none;
            outline: none;
            resize: none;
            border-radius: 20px;
        }
        .comment-button-container {
            display: flex;
            justify-content: flex-end; /* Align button to the left */
        }
        .comment-button {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 20px;
            padding: 8px 15px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 10px; /* Adjust the margin */
            
        }

        .comment-button:hover {
            background-color: #0056b3;
        }

        .liked-icon {
            color: #007bff;
        }

        
        

        
    </style>
</head>
<body >
<?php include 'navbar.php'; ?>



<div class="container-fluid">
    
    <div class="row pt-4">
        
        <div class="col-md-8 col-sm-8 pb-2 pt-4 offset-md-2" style="max-width: 800px;">
                      
            <?php
            while($row=$post_results->fetch_assoc()):
            
            ?>
            
            <div class="card post-card   post-type-<?php echo $row['post_type']?>" style="max-width: 700px;">
                <div class="card-header d-flex justify-content-between transparent-header">
                    <div>
                        <div class="d-flex align-items-center">
                            <?php
                            
                            if(isset($row['profile_pic']) && !empty($row['profile_pic'])) {
                        
                                $post_profile_pic = "uploads/{$row['profile_pic']}";
                            } else {
                                $post_profile_pic = "assets/images/no_person.jpg";
                            }
                            ?>
                            <a style="text-decoration: none;color: inherit;" href="<?php echo "./profile.php?id=".$row['id']?>">
                            <img src="<?php echo $post_profile_pic; ?>" alt="" style="width: 50px; height: 50px; border-radius: 50%;" />
                            </a>
                            <?php
                                // Assuming $row['created_at'] contains a datetime string like "Y-m-d H:i:s"
                                $created_at = strtotime($row['created_at']);
                                $current_time = time();

                                // Calculate the difference in seconds
                                $time_elapsed = $row['time_elapsed_seconds'];
                                

                                // Define time intervals in seconds
                                $minute = 60;
                                $hour = $minute * 60;
                                $day = $hour * 24;
                                $week = $day * 7;
                                $month = $day * 30;
                                $year = $day * 365;
                                
                                // Calculate elapsed time in human-readable format
                                if ($time_elapsed < $minute) {
                                    $elapsed_result = ($time_elapsed <= 1) ? "just now" : $time_elapsed . " seconds ago";
                                } elseif ($time_elapsed < $hour) {
                                    $elapsed_result = round($time_elapsed / $minute) . " minutes ago";
                                } elseif ($time_elapsed < $day) {
                                    $elapsed_result = round($time_elapsed / $hour) . " hours ago";
                                } elseif ($time_elapsed < $week) {
                                    $elapsed_result = round($time_elapsed / $day) . " days ago";
                                } elseif ($time_elapsed < $month) {
                                    $elapsed_result = round($time_elapsed / $week) . " weeks ago";
                                } elseif ($time_elapsed < $year) {
                                    $elapsed_result = round($time_elapsed / $month) . " months ago";
                                } else {
                                    $elapsed_result = round($time_elapsed / $year) . " years ago";
                                }

                                
                            ?>
                            <div>
                                <a style="text-decoration: none;color: inherit;font-size:18px;" href="<?php echo "./profile.php?id=".$row['id']?>"><?php echo $row['first_name']." ".$row['last_name']?></a>
                                <p class="mb-0" style="font-size: 10px;"><?php echo $elapsed_result; ?></p>
                            </div>
                            
                        </div>
                    </div>
                    <div>
                        <button class="btn btn-transparent btn-borderless p-0">...</button>
                        <button class="btn btn-transparent btn-borderless p-0"><b>X</b></button>
                    </div>
                </div>
                <div class="card-body text-center">
                    <?php
                    $post_type = $row['post_type'];
                    if ($post_type == 0):
                    ?>
                    <h5 class='card-title'><b>I want to send</b></h5>
                    <?php
                    elseif ($post_type == 1) :
                    ?>
                    <h5 class='card-title'><b>I want to receive</b></h5>
                    <?php
                    elseif ($post_type == 2):
                    ?>
                    <h5 class='card-title'><b>I want to carry</b></h5>
                    <?php
                    else:
                    ?>
                        
                    
                    <?php
                    endif;
                    ?>
                    <div>
                    <div class="row mx-auto text-center justify-content-center">
                        <div class="col-8 offset-3 text-left">
                            <p>From : <?php echo $row['from_location']?></p>
                            <p>To : <?php echo $row['to_location']?></p>
                            <p>Pickup : (<?php echo $row['pickup_date_start']?> - <?php echo $row['pickup_date_end']?>)</p>
                            <p>Drop of : (<?php echo $row['dropoff_date_start']?> - <?php echo $row['dropoff_date_end']?>)</p>
                            <?php
                            $parcel_type = $row['parcel_type'];
                            if ($parcel_type == 0) {
                                echo '<p>Parcel type : Document</p>';
                            } elseif ($parcel_type == 1) {
                                echo '<p>Parcel type : Product</p>';
                            } elseif ($parcel_type == 2) {
                                echo '<p>Parcel type : Food</p>';
                            } else {
                                // Handle any other cases
                                echo '<p>Parcel type : Others</p>';
                            }
                            ?>
                            <?php
                            $parcel_size = array("Small","Medium","Large","Extra Large");
                            $weight_scales = array("Kg","Gram","Lbs");
                            ?>
                            <p>Parcel Size: <?php echo $parcel_size[$row['parcel_size']]; ?></p>
                            <p>Weight Allowance: <?php echo $row['weight'];?> <?php echo $weight_scales[$row['weight_scale']]; ?></p>
                            
                            
                        </div>
                    </div>
                    
                    
                    
                    

                    </div>

                    <?php
                    if (!empty($row["details"])):
                    ?>
                        
                            <p class="text-left"><?php echo $row["details"]?></p>
                        
                    <?php endif; ?>
                    
                    
                    
                    
                </div>
                <div class="card-footer">
                    <div class="button-container post-card-footer">
                        
                        <?php
                        $likeIdString = $row['like_id'];

                        // Check if the user has already liked the post
                        $likeIds = explode(",", $likeIdString);
                        
                        $sql = "SELECT comments.*, users.first_name, users.id, users.last_name, users.profile_pic FROM comments LEFT JOIN users ON comments.uid = users.id WHERE comments.post_id = ".$row["post_id"];
                        $comments_results = $conn->query($sql);
                        $num_comments = $comments_results->num_rows;

                        $userLiked = isset($_SESSION["id"]) && in_array($_SESSION["id"], $likeIds);
                        ?>
                        <a class="btn like-btn" href="#" role="button" data-target="<?php echo $row["post_id"]?>">
                        
                            <i class="fas fa-thumbs-up <?php echo $userLiked ? 'liked-icon' : '' ?>"></i>
                            
                        </a>
                        <a class="btn comment-btn" href="#" role="button" data-target="<?php echo $row["post_id"]?>">
                            <i class="fas fa-comments"></i> 
                        </a>
                        <a class="btn share-btn" href="#" role="button">
                            <i class="fas fa-share"></i>
                        </a>
                    </div>
                    <div class="number-container post-card-footer">
                    <p><small>Likes: <span class="like-count" id="like-count-<?php echo $row["post_id"]?>"><?php echo count($likeIds)-1;?></span></small></p>
                        <p><small>Comments: <span  id="comment-count-<?php echo $row["post_id"]?>"><?php echo $num_comments;?></span></small></small></p>
                        <p><small>Shares: 3</small></p>
                    </div>
                </div>
                <div class="comment-post" style="display:none;" data-post-id="<?php echo $row['post_id']; ?>" id="comments-<?php echo $row['post_id']; ?>">
                    <div id='comment-list-<?php echo $row['post_id']; ?>'>
                        <?php
                        while($comment_row=$comments_results->fetch_assoc()):
                            if(!empty($comment_row['profile_pic'])) {
                    
                                $comment_profile_pic = "uploads/{$comment_row['profile_pic']}";
                            } else {
                                $comment_profile_pic = "assets/images/no_person.jpg";
                            }
                        ?>
                        <div class="comment-item">
                            <img src="<?php echo $comment_profile_pic; ?>" alt="" style="width: 30px; height: 30px; border-radius: 50%;" />
                            <div>
                                <b><?php echo ucfirst(strtolower($comment_row['first_name']))." ".ucfirst(strtolower($comment_row['last_name']))?></b>
                                <p><?php echo $comment_row['comment']; ?></p>
                            </div>
                        </div>
                        <?php
                        endwhile;
                    ?>
                    </div>
                    
                    <div class="comment-box" >
                        <textarea id="comment-box-<?php echo $row['post_id']; ?>" rows="3" placeholder="Write a comment..."></textarea>
                    </div>
                    <div class="comment-button-container">
                        <button class="comment-button">Comment</button>
                    </div>
                </div>




            </div>
            <?php endwhile; ?>
            
        </div>
    </div>
</div>

<div id="countryPopup" class="popup">
  <div class="popup-content">
    <span class="close" onclick="closePopup()">&times;</span>
    <h2 class="select-type-title">Select Country and City</h2>
    <form class="align-items-center">
        <input type="hidden" id="destination_type" value="0">
      <div class="form-row">
        <div class="form-group">
          <label for="country">Country:</label>
          <select id="countrySelect" onchange="updateCityDropdown()">
            <option value="">Select</option>
            
            <!-- Add more countries here -->
          </select>
        </div>
        <div class="form-group">
          <label for="city">City:</label>
          <select id="citySelect">
            <option value="">Select</option>
            
            <!-- Add more cities here -->
          </select>
        </div>
      </div>
      <button class="align-item-right" type="button" onclick="submitSelection()">Submit</button>
    </form>
  </div>
</div>




<!-- Bootstrap JS dependencies -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- swiper js -->
<link
    rel="stylesheet"
    href="https://unpkg.com/swiper@8/swiper-bundle.min.css"
/>
<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>



<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script>
    var pickup_date_start = null;
    var pickup_date_end = null;
    var dropoff_date_start = null;
    var dropoff_date_end = null;
    var pickup_country = null;
    var pickup_city = null;
    var dropoff_country = null;
    var dropoff_city = null;

    function openPopup(destination_type_val) {
        console.log("popup open");
        document.getElementById('countryPopup').style.display = 'block';
        document.getElementById('destination_type').value = destination_type_val;
        loadCountries();
    }

    function closePopup() {
        document.getElementById('countryPopup').style.display = 'none';
    }

    function submitSelection() {
        var country = document.getElementById('countrySelect').value;
        var city = document.getElementById('citySelect').value;
        var destination_type = document.getElementById('destination_type').value;
        
        if(destination_type == '0'){
            $("#fromValue").html(city +", "+ country);
            $("#from_country").val(country);
            $("#from_city").val(city);
        }
        else{
            $("#toValue").html(city +", "+ country);
            $("#to_country").val(country);
            $("#to_city").val(city);
        }
        console.log("Country selected:", country);
        console.log("City selected:", city);
        console.log("Select type selected:", destination_type);
       
        // You can add further actions here, like submitting the form or processing the selection.
        closePopup(); // Close the popup after submission if needed
    }

    function loadCountries() {
        const countrySelect = document.getElementById('countrySelect');

        // Populate country dropdown
        const option = document.createElement('option');
        option.value = "";
        option.textContent = "--";
        countrySelect.appendChild(option);
        for (const country in countries) {
            const option = document.createElement('option');
            option.value = country;
            option.textContent = country;
            countrySelect.appendChild(option);
        }
    }
    function updateCityDropdown() {
        const countrySelect = document.getElementById('countrySelect');
        const citySelect = document.getElementById('citySelect');
        const selectedCountry = countrySelect.value;

        // Clear existing options
        citySelect.innerHTML = '';

        // Populate city dropdown based on the selected country
        const cities = countries[selectedCountry];
        const option = document.createElement('option');
        option.value = "";
        option.textContent = "--";
        citySelect.appendChild(option);
        if (cities) {
            for (const city of cities) {
                const option = document.createElement('option');
                option.value = city;
                option.textContent = city;
                citySelect.appendChild(option);
            }
        }
    }
    $('#pickup_date_range').daterangepicker({
    autoUpdateInput: false,
    locale: {
        cancelLabel: 'Clear'
    }
    });
    $('#pickup_date_range').on('apply.daterangepicker', function(ev, picker) {
        $('#pickup_date_range_val').text(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
        pickup_date_start = picker.startDate.format('YYYY-MM-DD');
        $("#pickup_date_start").val(pickup_date_start)
        console.log(pickup_date_start);
        pickup_date_end = picker.endDate.format('YYYY-MM-DD');
        $("#pickup_date_end").val(pickup_date_end)
        console.log(pickup_date_end);
    });
    $('#pickup_date_range').on('cancel.daterangepicker', function(ev, picker) {
    $('#pickup_date_range_val').text('Choose a Date');
    });

    $('#destination_date_range').daterangepicker({
    autoUpdateInput: false,
    locale: {
        cancelLabel: 'Clear'
    }
    });
    $('#destination_date_range').on('apply.daterangepicker', function(ev, picker) {
        $('#destination_date_range_val').text(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
        dropoff_date_start = picker.startDate.format('YYYY-MM-DD');
        $("#dropoff_date_start").val(dropoff_date_start)
        console.log(dropoff_date_start);
        dropoff_date_end = picker.endDate.format('YYYY-MM-DD');
        $("#dropoff_date_end").val(dropoff_date_end)
        console.log(dropoff_date_end);
    });
    $('#destination_date_range').on('cancel.daterangepicker', function(ev, picker) {
    $('#destination_date_range_val').text('Choose a Date');
    });

</script>
<script>
    $(document).ready(function() {
        $('#postForm').submit(function(event) {
            // Prevent the default form submission
            event.preventDefault();
            console.log("sending rqest...");
            console.log($('input[name="weight"]').val());
            // Get form data
            var formData = {
                from_location: $('#fromValue').text(),
                to_location: $('#toValue').text(),
                parcel_type: $('input[name="parcel_type"]:checked').val(),
                weight: $('input[name="weight"]').val(),
                weight_scale: $('input[name="weight_scale"]').val(),
                details: $('textarea[name="details"]').val(),
                post_type: $('input[name="post_type"]:checked').val(),
                pickup_date_start: pickup_date_start,
                pickup_date_end: pickup_date_end,
                dropoff_date_start: dropoff_date_start,
                dropoff_date_end: dropoff_date_end,
                // Add more form fields if needed
            };

            // Send the POST request
            // Send the POST request
            $.ajax({
                type: 'POST',
                url: window.location.href, // Endpoint URL
                data: formData,
                
            });

        });
    });


    function showPosts(post_type_show) {
        if(post_type_show){
            console.log(post_type_show);
            $('.post-type-0').hide();
            $('.post-type-1').hide();
            $('.post-type-2').hide();

            $('.'+post_type_show).show();
        }   
        else{
            $('.post-type-0').show();
            $('.post-type-1').show();
            $('.post-type-2').show();
        }
        
    }
    $(document).ready(function() {
        $('.like-btn').on('click', function(event) {
            event.preventDefault(); // Prevent the default action

            // Find the target like count span using data attribute
            var target = $(this).data('target');
            console.log(target);
            var likeCountSpan = $('#like-count-' + target);

            // Send a POST request to the server to add a like
            $.post('./api/add_like.php', { id: target }, function(response) {
                // Assuming the response is JSON
                var result = JSON.parse(response);
                
                if (result.success === 1) {
                    // Like added successfully, update the like count
                    likeCountSpan.text(result.likes);
                    $(this).find('.fa-thumbs-up').addClass('liked-icon');
                    $(this).find('.fa-thumbs-up').css('color', '#007bff');
                } else if (result.success === 0) {
                    // Failed to add like, display an error message
                    alert(result.message);
                } else if (result.success === -1) {
                    // User not logged in, redirect to login page
                    window.location.href = 'login.php';
                }
            }).fail(function() {
                alert('Error adding like. Please try again.');
            });
        });
        $('.comment-btn').on('click', function(event) {
            event.preventDefault(); // Prevent the default action

            // Find the target like count span using data attribute
            var target = $(this).data('target');
            console.log(target);
            var CommentsDiv = $('#comments-' + target);
            
            CommentsDiv.toggle();
            
        });
    });
    $(document).ready(function() {
    

    // Handle post request when comment button is clicked
    $('.comment-button').on('click', function() {
        console.log("clciekd");
        var postId = $(this).closest('.comment-post').data('post-id'); // Get the post ID
        console.log(postId);
        console.log('#comment-box-'+postId);
        var commentBox = $('#comment-box-'+postId)
        var commentText = commentBox.val().trim();
        console.log(commentText);
        if (commentText !== '' && postId) {
            $.post('./api/add_comment.php', { postId: postId, comment: commentText }, function(response) {
                response_json = JSON.parse(response);
                if (response_json.success) {
                    // Comment added successfully
                    console.log('Comment added successfully.');

                    // Append the new comment to the comment list
                    var newComment = '<div class="comment-item">' +
                                        '<img src="<?php echo $profile_pic; ?>" alt="" style="width: 30px; height: 30px; border-radius: 50%;" />' +
                                        '<div>' +
                                            '<b><?php echo ucfirst(strtolower($_SESSION['first_name']))." ".ucfirst(strtolower($_SESSION['last_name']))?></b>' +
                                            '<p>' + commentText + '</p>' +
                                        '</div>' +
                                    '</div>';
                    
                    $('#comment-list-'+postId).append(newComment);
                    commentBox.val('');
                    var commentCountSpan = $('#comment-count-' + postId);
                    var currentCommentCount = parseInt(commentCountSpan.text()); // Parse the current comment count as an integer
                    var newCommentCount = currentCommentCount + 1; // Increment the comment count

                    // Update the text of the comment count span with the new count
                    commentCountSpan.text(newCommentCount);
                } else {
                    // Comment failed to add
                    console.error('Failed to add comment.');
                }
            }).fail(function() {
                // Handle errors
                console.error('Error posting comment.');
            });
        }
    });
    
});



</script>
</body>
</html>
