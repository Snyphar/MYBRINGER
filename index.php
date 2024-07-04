<?php
// Start the session
session_start();
include "db_connect.php";

include_once("country_codes.php");

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


    <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@7.0.0/css/flag-icons.min.css"
    />
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
        .btn-parcel-type.active {
            
            background-color: #018CA2;
            color: white;
            border-color: #015F6;
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
            padding: 3px;
            
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

        .comment-item-username {
            color: #333;
        }

        .comment-item-text {
            margin-top: 5px;
            color: #666;
            max-width: 90%; /* Ensure it takes the full width of its parent by default */
            word-wrap: break-word; /* Break long words to wrap onto the next line */
            
            flex: 1; /* Allow it to take available space */
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
        .parent-div {
            position: relative;
            
        }
        .search-card {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            
            
            
            z-index: 1000;
            
        }
        .search-card-body{
            max-height: 400px;
            overflow-y: auto;
        }
        .search-row:hover{
            background-color: #ccc;
        }

        
        

        
    </style>
    <link rel="stylesheet" href="./css/style.css">
</head>
<body >
<?php include 'navbar.php'; ?>


<div class="container-fluid cover-section">
    <div class="container mt-3 typing-conatiner pt-5">
        <div class="typing-effect transparent">
            Send, receive, and carry parcels.
        </div>
    </div>
    
    <div class=" container-lg container-md-fluid conatiner-sm-fluid mt-5 parent-div">
        <form id="searchForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div class="card">
                <div class="card-body form-card">

                    <input type="hidden" id="from_country" name="from_country" value="">
                    <input type="hidden" id="to_country" name="to_country" value="">
                    <input type="hidden" id="from_city" name="from_city" value="">
                    <input type="hidden" id="to_city" name="to_city" value="">
                    <input type="hidden" id="pickup_date_start" name="pickup_date_start" value="">
                    <input type="hidden" id="pickup_date_end" name="pickup_date_end" value="">
                    <input type="hidden" id="dropoff_date_start" name="dropoff_date_start" value="">
                    <input type="hidden" id="dropoff_date_end" name="dropoff_date_end" value="">
                    <?php
                    $search_invalid = FALSE;
                    if ($_SERVER["REQUEST_METHOD"] == "POST" && ((!isset($_POST["from_country"]) || empty($_POST["from_country"])) || (!isset($_POST["to_country"]) || empty($_POST["to_country"])))):
                        $search_invalid = TRUE;
                    ?>
                    <div class="text-center">
                        <p class="text-danger">Search Must have atleast A location!</p>
                    </div>
                    <?php
                    endif;
                    ?>
                    <div class="d-flex justify-content-center form-row">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="post_type" id="inlineRadio1" value="0">
                            <label class="form-check-label" for="inlineRadio1"><b>I want to send</b></label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="post_type" id="inlineRadio2" value="1">
                            <label class="form-check-label" for="inlineRadio2"><b>I want to receive</b></label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="post_type" id="inlineRadio3" value="2">
                            <label class="form-check-label" for="inlineRadio3"><b>I want to carry</b></label>
                        </div>
                    </div>
                    <div class="row pt-4 form-row">
                        <div class="col-6  col-lg-3 form-col" onclick="openPopup(0)">
                            <div class="custom-input">
                                <label for="">From</label>
                                <div class="card form-item-card">
                                    
                                    <p id="fromValue" class="p-2">Select City</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-6  col-lg-3 form-col" onclick="openPopup(1)">
                            <div class="custom-input">
                                <label for="">To</label>
                                <div class="card form-item-card">
                                    
                                    <p id="toValue" class="p-2">Select City</p>
                                </div>
                            </div>
                            
                            
                        </div>
                        <div class="col-6 col-lg-3 form-col"  id="pickup_date_range">
                            <div class="custom-input">
                                <label for="">Pickup (Range)</label>
                                <div class="card form-item-card">
                                    
                                    <p id="pickup_date_range_val" class="p-2">Chose a date</p>
                                </div>
                            </div>
                            
                            
                        </div>
                        <div class="col-6 col-lg-3 form-col" id="destination_date_range">
                            <div class="custom-input">
                                <label for="">Drop off (Range)</label>
                                <div class="card form-item-card">
                                    
                                    <p id="destination_date_range_val" class="p-2">Chose a date</p>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <div class="d-flex justify-content-center parcel-type">
                        <div class="card parcel-type-card text-center mx-auto mt-4" style="max-width: 450px;">
                            <div class="card-title">
                                <label for="">Parcel Type</label>
                            </div>
                            <div class="card-body parcel-card-body">
                                <div class="btn-group-sm btn-group-toggle" data-toggle="buttons">
                                    <label class="btn btn-sm btn-parcel-type mr-3">
                                        <input  type="radio" name="parcel_type" id="option1" value="0" autocomplete="off"> Document
                                    </label>
                                    <label class="btn btn-parcel-type mr-3">
                                        <input type="radio" name="parcel_type" id="option2" value="1" autocomplete="off"> Product
                                    </label>
                                    <label class="btn btn-parcel-type mr-3">
                                        <input type="radio" name="parcel_type" id="option3" value="2" autocomplete="off"> Food
                                    </label>
                                    <label class="btn btn-parcel-type ">
                                        <input type="radio" name="parcel_type" id="option4" value="3" autocomplete="off"> Others
                                    </label>
                                </div>
                            </div>
                            
                        </div>
                        <div class="card parcel-type-card text-center mx-auto mt-4" style="max-width: 450px;">
                            <div class="card-title">
                                <label for="">Parcel Size</label>
                            </div>
                            <div class="card-body parcel-card-body">
                                <div class="btn-group-sm btn-group-toggle" data-toggle="buttons">
                                    <label class="btn btn-sm btn-parcel-type mr-2">
                                        <input type="radio" name="parcel_size" id="option1" value="0" autocomplete="off"> Small
                                    </label>
                                    <label class="btn btn-parcel-type mr-2">
                                        <input type="radio" name="parcel_size" id="option2" value="1" autocomplete="off"> Medium
                                    </label>
                                    <label class="btn btn-parcel-type mr-2">
                                        <input type="radio" name="parcel_size" id="option3" value="2" autocomplete="off"> Large
                                    </label>
                                    <label class="btn btn-parcel-type">
                                        <input type="radio" name="parcel_size" id="option4" value="3" autocomplete="off"> Extra Large
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-center d-flex pt-4 form-row">
                        <div class="row justify-content-center mx-auto">
                            
                            <div class="input-group ">
                            <label for="" class="pr-3"><b>Weight: </b></label>
                                <input type="number" name="weight"  class="form-control" style="max-width: 80px">
                                <div class="form-check form-check-inline ml-3">
                                    <input class="form-check-input" type="radio" name="weight_scale" id="inlineRadio1" value="0">
                                    <label class="form-check-label" for="inlineRadio1"><b>Kg</b></label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="weight_scale" id="inlineRadio1" value="1">
                                    <label class="form-check-label" for="inlineRadio1"><b>gm</b></label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="weight_scale" id="inlineRadio1" value="2">
                                    <label class="form-check-label" for="inlineRadio1"><b>lbs</b></label>
                                </div>
                                
                            </div>
                        </div>
                    </div>


                    
                    <div class="row justify-content-center mx-auto rounded-buttons mt-4">
                        <button type="submit" class="btn btn-filled btn-block" style="max-width: 200px;">Search</button>
                        
                        
                    </div>
                    <div class="row justify-content-center mx-auto rounded-buttons mt-2">
                        
                        <?php
                        if ($_SERVER["REQUEST_METHOD"] == "POST"):
                        ?>
                        <p>Not Satisfied with the result? <a href="./post.php">Post it here.</a></p>
                        <?php
                        endif;
                        ?>
                        
                    </div>
                    

                </div>
            </div>
        </form>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && !$search_invalid) {
            // Loop through each POST parameter and echo its key-value pair
        
        
            
            

            if(isset($_POST["from_country"])){
                $from_country = $_POST["from_country"];
            }
            
            if(isset($_POST["to_country"])){
                $to_country = $_POST["to_country"];
            }
            
            if(isset($_POST["from_city"])){
                $from_city = $_POST["from_city"];
            }
            
            if(isset($_POST["to_city"])){
                $to_city = $_POST["to_city"];
            }

            
            

            if(isset($_POST["pickup_date_start"])){
                $pickup_date_start = $_POST["pickup_date_start"];
            }
            
            if(isset($_POST["pickup_date_end"])){
                $pickup_date_end = $_POST["pickup_date_end"];
            }


            if(isset($_POST["dropoff_date_start"])){
                $dropoff_date_start = $_POST["dropoff_date_start"];
            }
            
            if(isset($_POST["dropoff_date_end"])){
                $dropoff_date_end = $_POST["dropoff_date_end"];
            }




            
            if(isset($_POST["parcel_type"])){
                $parcel_type = $_POST["parcel_type"];
            }
            
            if(isset($_POST["weight"])){
                $weight = $_POST["weight"];
            }
            
            if(isset($_POST["weight_scale"])){
                $weight_scale = $_POST["weight_scale"];
            }

            if(isset($from_country) && isset($from_city) && !empty($from_country) && !empty($from_city)){
                $from_location = $from_city.", ".$from_country;
            }
            if(isset($to_country) && isset($to_city) && !empty($to_country) && !empty($to_city)){
                $to_location = $to_city.", ".$to_country;
            }
            $isFilter = 0;
            $filter = "";

            if(isset($pickup_date_start) && !empty($pickup_date_start) && isset($pickup_date_end) && !empty($pickup_date_end)){
                if(empty($filter)){
                    $filter = " WHERE post.pickup_date_start >= '{$pickup_date_start}' AND post.pickup_date_end <= '{$pickup_date_end}'";
                } else {
                    $filter .= " AND post.from_location = '{$from_location}'";
                }
            }
            if(isset($dropoff_date_start) && !empty($dropoffp_date_start) && isset($dropoff_date_end) && !empty($dropoff_date_end)){
                if(empty($filter)){
                    $filter = " WHERE post.dropoff_date_start >= '{$dropoff_date_start}' AND post.dropoff_date_start <= '{$dropoff_date_start}'";
                } else {
                    $filter .= " AND post.from_location = '{$from_location}'";
                }
            }
            if(isset($from_location) && !empty($from_location)){
                if(empty($filter)){
                    $filter = " WHERE post.from_location = '{$from_location}'";
                } else {
                    $filter .= " AND post.from_location = '{$from_location}'";
                }
            }
            
            if(isset($to_location) && !empty($to_location)){
                if(empty($filter)){
                    $filter = " WHERE post.to_location = '{$to_location}'";
                } else {
                    $filter .= " AND post.to_location = '{$to_location}'";
                }
            }
            
            if(isset($parcel_type) && !empty($parcel_type)){
                if(empty($filter)){
                    $filter = " WHERE post.parcel_type = '{$parcel_type}'";
                } else {
                    $filter .= " AND post.parcel_type = '{$parcel_type}'";
                }
            }
            
            if(isset($weight) && isset($weight_scale) && !empty($weight) && !empty($weight_scale)){
                if(empty($filter)){
                    $filter = " WHERE weight = '{$weight}' AND post.weight_scale = '{$weight_scale}'";
                } else {
                    $filter .= " AND weight = '{$weight}' AND post.weight_scale = '{$weight_scale}'";
                }
            }
            

            $sql = "SELECT post.id AS post_id, users.id AS user_id, post.*, users.*, TIMESTAMPDIFF(SECOND, post.created_at, NOW()) AS time_elapsed_seconds FROM post JOIN users ON post.uid = users.id {$filter} ORDER BY post.created_at DESC;";


            $search_result = $conn->query($sql);
            $num_rows = $search_result->num_rows;

        
            
            
        }
        
        
        
        ?>
        
        
        
        <?php
        if(isset($search_result)):
        ?>
        
        <div class="row justify-content-center mx-auto rounded-buttons mt-2 search-card">
                        
            <div class="card">
                <div class="card-body search-card-body">
                    <?php
                    if($num_rows > 0):
                    ?>
                    <?php
                    while($row=$search_result->fetch_assoc()):
                    
                    ?>
                    <a href="./view_post.php?id=<?php echo $row['post_id']?>" style="text-decoration: none;color: inherit;">
                        <div class="row search-row">
                            <?php
                                
                            if(isset($row['profile_pic']) && !empty($row['profile_pic'])) {
                        
                                $post_profile_pic = "uploads/{$row['profile_pic']}";
                            } else {
                                $post_profile_pic = "assets/images/no_person.jpg";
                            }
                            ?>
                            <img class="mr-3" src="<?php echo $profile_pic; ?>" alt="" style="width: 40px; height: 40px; border-radius: 50%;" />
                            <?php
                            $post_type_arr = array("I want to send","I want to receive","I want to carry");
                            
                            ?>
                            
                            <div class="m-r-3">
                                <h5><?php echo $row['first_name']." ".$row['last_name']?> |<span><small class="grey"><?php echo $post_type_arr[$row['post_type']]?></small></span></h5>
                                <small><?php echo $row['from_location']?> - <?php echo $row['to_location']?> | <?php echo $row['pickup_date_end']?> - <?php echo $row['dropoff_date_start']?></small>
                            </div>
                            <div class="ml-3">
                                <?php
                                
                                $short_form = getCountryShortForm($_SESSION['country'], $country_codes);
                                $country_icon = "fi-".strtolower($short_form);
                                ?>
                                <p><span class="fi <?php echo $country_icon;?>"></span><?php echo $row['country']?></p>
                            </div>
                        </div>
                    </a>
                    <?php
                    endwhile;
                    ?>
                    <?php
                    endif;
                    ?>
                    
                    
                </div>
            </div>
            
        </div>
        <?php
        endif;
        ?>
    </div>
</div>



<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-3">
        <?php
     
            $sql = "SELECT post.id AS post_id, users.id AS user_id, post.*, users.*, TIMESTAMPDIFF(SECOND, post.created_at, NOW()) AS time_elapsed_seconds FROM post JOIN users ON post.uid = users.id ORDER BY post.created_at DESC;";
            $result = $conn->query($sql);
            $num_rows = $result->num_rows;
            ?>
            
            
            
            
            

            
        </div>
    </div>
    <div class="row pt-4">
        <div class="col-md-3 col-sm-12 pb pt-4 mt-2">
            <?php
                if(isset($_SESSION['id']) && !empty($_SESSION['profile_pic'])) {
                    
                    $profile_pic = "uploads/{$_SESSION['profile_pic']}";
                } else {
                    $profile_pic = "assets/images/no_person.jpg";
                }
            ?>
            <?php
            if (isset($_SESSION['id'])):
            ?>
               
            <div class="card pt-3 mt-5">
                <div class="text-center">
                    <img src="<?php echo $profile_pic; ?>" alt="" style="width: 150px; height: 150px; border-radius: 50%;" />
                    <h5><b><?php echo ucfirst(strtolower($_SESSION['first_name']))." ".ucfirst(strtolower($_SESSION['last_name']))?> </b></h5>
                    <p class="mb-1"><?php echo ucfirst(strtolower($_SESSION['occupation']))?></p>
                    <p class="mb-1"><?php echo ucfirst(strtolower($_SESSION['city']))?>, <?php echo ucfirst(strtolower($_SESSION['country']))?></p>
                    <div style="display: flex;justify-content: center;">
                        <div class="rate" >
                            <?php
                                // Assume $avg_star_int is the integer part of the average star rating
                                // and $avg_star is the exact average star rating
                                $sql = "SELECT AVG(star) AS avg_star FROM review WHERE uid = ".$_SESSION['id'];
                                $rating_results = $conn->query($sql);
                                
                                while($row=$rating_results->fetch_assoc()){
                                    
                                    $avg_star = $row['avg_star'];
                                    
                                }
                                $avg_star_int = intval($avg_star);
                                for ($i = 5; $i >= 1; $i--) {
                                    echo '<input type="radio" id="star'.$i.'" name="rating-sub" value="'.$i.'"';
                                    if ($avg_star_int == $i) {
                                        echo ' checked';
                                    } else {
                                        echo ' disabled';
                                    }
                                    echo ' />';
                                    echo '<label for="star'.$i.'" title="'.$i.' stars">'.$i.' stars</label>';
                                }
                            ?>
                        </div>
                        <script></script>
                    </div>
                    
                    
                </div>
                <div class="text-center">
                <?php
                    $datetime = new DateTime($_SESSION['created_at']);
                    $year = $datetime->format('Y');
                ?>
                
                <p class="mb-1 text-muted">Joined <?php echo $year?></p>
                </div>
            </div>
            <?php
            endif;
            ?>
        </div>
        <div class="col-md-8 col-sm-12 pb-2 pt-4" style="max-width: 800px;">
            
            <div class="row pl-3 rounded-buttons d-flex justify-content-center" style="max-width: 800px;">
                <button class="btn btn-outline-info fill-on-hover mr-2" onclick="showPosts('')">All Posts</button>
                <button class="btn btn-outline-info fill-on-hover mr-2" onclick="showPosts('post-type-0')">Sender</button>
                <button class="btn btn-outline-info fill-on-hover mr-2" onclick="showPosts('post-type-1')">Receiver</button>
                <button class="btn btn-outline-info fill-on-hover mr-2" onclick="showPosts('post-type-2')">Carrier</button>
            </div>
            
            <?php
            while($row=$result->fetch_assoc()):
            
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
                            <div class="pl-2">
                                <a style="text-decoration: none;color: inherit;font-size:18px;" href="<?php echo "./profile.php?id=".$row['id']?>"><p class="profile-name mb-0"><?php echo $row['first_name']." ".$row['last_name']?></p></a>
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
                            <?php
                            $parcel_type = $row['parcel_type'];
                            $parcel_type = ["Document","Product","Food"];
                            $parcel_size = array("Small","Medium","Large","Extra Large");
                            $weight_scales = array("Kg","Gram","Lbs");

                            $date = new DateTime($row['pickup_date_start']);
                            $row['pickup_date_start'] = $date->format('d-M-Y l');

                            $date = new DateTime($row['pickup_date_end']);
                            $row['pickup_date_end'] = $date->format('d-M-Y l');

                            $date = new DateTime($row['dropoff_date_start']);
                            $row['dropoff_date_start'] = $date->format('d-M-Y l');

                            $date = new DateTime($row['dropoff_date_end']);
                            $row['dropoff_date_end'] = $date->format('d-M-Y l');





                            ?>
                            <table>
                                <tr>
                                    <td>From</td>
                                    <td>:</td>
                                    <td class="pl-2"><?php echo $row['from_location']?></td>
                                </tr>
                                <tr>
                                    <td>To</td>
                                    <td>:</td>
                                    <td class="pl-2"><?php echo $row['to_location']?></td>
                                </tr>
                                <tr>
                                    <td>Pickup</td>
                                    <td>:</td>
                                    <td class="pl-2"><?php echo $row['pickup_date_start']?></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td class="pl-2"><?php echo $row['pickup_date_end']?></td>
                                </tr>
                                
                                <tr>
                                    <td>Drop of</td>
                                    <td>:</td>
                                    <td class="pl-2"><?php echo $row['dropoff_date_start']?></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td class="pl-2"><?php echo $row['dropoff_date_end']?></td>
                                </tr>
                                
                                <tr>
                                    
                                    <td>Parcel type</td>
                                    <td>:</td>
                                    <td class="pl-2"><?php echo $parcel_type[$row['parcel_type']]; ?></td>
                                </tr>
                                <tr>
                                    <td>Size</td>
                                    <td>:</td>
                                    <td class="pl-2"><?php echo $parcel_size[$row['parcel_type']]; ?></td>
                                </tr>
                                <tr>
                                    <td>Weight</td>
                                    <td>:</td>
                                    <td class="pl-2"><?php echo $row['weight'];?> <?php echo $weight_scales[$row['weight_scale']]; ?></td>
                                </tr>
                            </table>
                            
                            
                        </div>
                    </div>
                    
                    
                    
                    

                    </div>

                    <?php
                    if (!empty($row["details"])):
                    ?>
                        
                            <p class="text-left"><?php echo $row["details"]?></p>
                        
                    <?php endif; ?>
                
                <div class="button-container post-card-footer">
                    
                    <?php
                    $likeIdString = $row['like_id'];

                    // Check if the user has already liked the post
                    $likeIds = explode(",", $likeIdString);
                    
                    $sql = "SELECT comments.*, users.first_name, users.id as user_id, users.last_name, users.profile_pic FROM comments LEFT JOIN users ON comments.uid = users.id WHERE comments.post_id = ".$row["post_id"];
                    $comments_results = $conn->query($sql);
                    $num_comments = $comments_results->num_rows;

                    $userLiked = isset($_SESSION["id"]) && in_array($_SESSION["id"], $likeIds);
                    ?>
                    <div class="d-flex align-items-center ">
                        
                        <p class="pt-3 pl-0 ml-0"><small>Likes: <span class="like-count" id="like-count-<?php echo $row["post_id"]?>"><?php echo count($likeIds)-1;?></span></small></p>
                    </div>

                    
                    <div class="d-flex align-items-right ">
                        <p class="pt-3 pl-0 ml-0"><small>Comments: <span  id="comment-count-<?php echo $row["post_id"]?>"><?php echo $num_comments;?></span></small></small></p>
                        
                    </div>
                    
                    
                </div>
                <hr class="p-0 m-0">
                    
                <div class="button-container post-card-footer">
                        
                    
                    <div class="d-flex align-items-center ">
                        <a class="btn   like-btn pr-0" href="#" role="button" data-target="<?php echo $row["post_id"]?>">
                            
                            <i class="fas fa-thumbs-up <?php echo $userLiked ? 'liked-icon' : '' ?>" id="like-icon-<?php echo $row["post_id"]?>" style="font-size: 20px;"></i>
                            
                        </a>
                        <p class="pt-3 pl-0 ml-0"><small>Like</small></p>
                    </div>

                    <div class="d-flex align-items-center ">
                        <a class="btn comment-btn pr-0" href="#" role="button" data-target="<?php echo $row["post_id"]?>">
                            <i class="fas fa-comments"></i> 
                        </a>
                        <p class="pt-3 pl-0 ml-0"><small>Comment</small></small></p>
                    </div>
                    
                    <div class="d-flex align-items-center">
                        <a class="btn share-btn pr-0" href="#" role="button">
                            <i class="fas fa-share"></i>
                        </a>
                        <p class="pt-3 pl-0 ml-0"><small>Share</small></p>
                    </div>
                    
                    
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
                            <div class="comment-item-right container">
                                <a style="text-decoration: none;color: inherit;" href="<?php echo "./profile.php?id=".$comment_row['user_id']?>" ><b class="comment-item-username"><?php echo ucfirst(strtolower($comment_row['first_name']))." ".ucfirst(strtolower($comment_row['last_name']))?></a></b>
                                <p class="comment-item-text"><?php echo $comment_row['comment']; ?></p>
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

<div class="modal fade" id="warningModal" tabindex="-1" role="dialog" aria-labelledby="warningModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="warningModalLabel">Warning</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Please provide both From and To locations.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
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

            // Get form data
            var fromLocation = $('#fromValue').text();
            var toLocation = $('#toValue').text();

            if (!fromLocation || !toLocation) {
                console.log("nooooooooooooooo");
                $('#warningModal').modal('show');
                return;
            }
            
            var formData = {
                from_location: fromLocation,
                to_location: toLocation,
                parcel_type: $('input[name="parcel_type"]:checked').val(),
                weight: $('input[name="weight"]').val(),
                weight_scale: $('input[name="weight_scale"]').val(),
                details: $('textarea[name="details"]').val(),
                post_type: $('input[name="post_type"]:checked').val(),
                pickup_date_start: pickup_date_start,
                pickup_date_end: pickup_date_end,
                dropoff_date_start: dropoff_date_start,
                dropoff_date_end: dropoff_date_end,
            };

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
                    var likeIcon = $("#like-icon-"+ target);
                    likeIcon.addClass('liked-icon');
                    likeIcon.find('.fa-thumbs-up').css('color', '#007bff');
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
