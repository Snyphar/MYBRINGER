<?php
// Start the session
session_start();
include "db_connect.php";
// Other PHP code goes here
if (isset($_GET['id'])) {
    // Get the value of 'name' parameter
    $id = $_GET['id'];
    $user_id = $id;
    $sql = "SELECT * FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);

    // Bind parameters
    $stmt->bind_param("i", $id);

    // Execute the statement
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $user_row = $result->fetch_assoc();
        $user_data = $user_row;
    }
    else{
        header("Location: profile.php");
    }
}
else if(isset($_SESSION['id'])){
    $user_id = $_SESSION['id'];
    $user_data = $_SESSION;
} 
else{
    header("Location: login.php");
}

if (isset($_GET['section'])){
    $section = $_GET['section'];
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bootstrap Template</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@7.0.0/css/flag-icons.min.css"
    />

    <script defer src="./JS/countries.js"></script>
    

    <style>
        .profile-country-sm{
            
            position: absolute;
            top:0;
            right:10px;
        }
        .popup {
            display: none; /* Hidden by default */
            position: absolute;
            top: 40px; /* Adjust as needed */
            right: 0;
            background-color: white;
            border: 1px solid #ccc;
            padding: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }
        .fi {
            font-size: 25px; /* Adjust the font-size as needed */
        }
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
        
        
        .transparent {
            background-color: rgba(255, 255, 255, 0.0); /* Set background color with transparency */
            
        }
        .transparent-header {
            background-color: transparent !important; /* Important to override default Bootstrap styling */
        }
        header-option-btn{
            border-radius: 50%;
        }

        .profile-image {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
        }

        

        
        .main-options{
            font-size: 20px;
            margin-left: 30px;
        }
        .main-option-section{
            align-items: center;
            
        }
        .main-options-val{
            color: gray;
        }
        .navbar-profile-image {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            object-fit: cover;
        }
        .section-title,.section-btn{
            padding: 3px 5px;
            margin: 2px;
        }
        .section-btn{
            background-color: #ffffff;
            border: none;
            color: #333333;
            
            border-radius: 5px;
            transition: background-color 0.3s ease;
            width:100%;
            display: flex;
            justify-content: left;
            
            
        }
        .section-btn p {
            margin: 0; /* Remove margin from paragraph */
        }
        .section-btn:hover {
            background-color: #f0f0f0;
            border: 1px solid #cccccc;
        }
        .vertical-line {
            border-left: 1px solid #ccc;
            height: 100%;
            position: absolute;
            top: 0;
        }


        .section-content {
            display: none;
        }

        .section-content.active {
            display: block;
        }
        .underlined {
            border-bottom: 1px solid black;
            display: inline-block;
        }
        .rating-bar {
            background-color: #ccc; /* Grey color */
            height: 5px; /* Adjust height as needed */
            border-radius: 10px; /* Half of the height to achieve rounded corners */
             /* Adjust margin as needed */
            width: 200px;
        }
        .rating-bar-filled {
            background-color: black; /* Grey color */
            height: 5px; /* Adjust height as needed */
            border-radius: 10px; /* Half of the height to achieve rounded corners */
             /* Adjust margin as needed */
           
        }
        .rating-profile-image {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }

        .profile-container {
            position: relative;
            display: inline-block;
        }

        .change-button {
            position: absolute;
            bottom: 0;
            right: 0;
            width:20px;
            height:20px;
            border-radius: 50%;
            background-color: grey; /* Change this to desired background color */
            color: #fff; /* Change this to desired text color */
            border: none;
            padding:0;
            margin:0;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .change-button:hover {
            background-color: #0056b3; /* Change this to desired hover background color */
        }


        
        .edit-modal {
            display: none;
            justify-content: center;
            align-items: center;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Add a semi-transparent background */
            z-index: 1000; /* Ensure the modal appears on top */
        }
        .edit-modal-content {
            width: 80%; /* Adjust the width as needed */
            max-width: 800px; /* Set a maximum width if desired */
            background-color: #fff; /* Set a background color for the modal content */
            padding: 20px; /* Add padding to the modal content */
            border-radius: 8px; /* Add some border radius for a rounded appearance */
        }

        .bar-container {
            width: 100%;
            background-color: grey;
            border-radius: 5px;
            overflow: hidden;
            margin-bottom: 10px;
        }
        .bar {
            height: 20px;
            background-color: #148f31;
            text-align: right;
            padding-right: 5px;
            box-sizing: border-box;
            color: white;
            font-weight: bold;
            border-radius: 5px 0 0 5px;
        }
        /* .star:hover,
        .star.active {
            color: orange;
        } */

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
        .post-section {
            
            justify-content: center;
            
        }
        .post-card {
            margin-bottom: 20px; /* Adds some space between the cards */
        }

        .aligned-td {
            padding: 0;
            margin: 0;
            vertical-align: top;
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
        
        

        
        

        
    </style>
    <link rel="stylesheet" href="./css/style.css">
</head>
<body >

<?php include 'navbar.php'; ?>

<div class="container-fluid profile-container">
    <div class="card">


    
        <div class="card-body ">
            <div class="row">
                <div class="col-md-8">
                    
                    
                    <?php
                    include "country_codes.php";
                    $totalFields = 0;
                    $nonEmptyFieldsCounter = 0;
                    $avg_star = 0;
                    if(isset($user_row)){
                        $sql = "SELECT AVG(star) AS avg_star FROM review WHERE uid =".$user_row['id'];
                    }
                    else{
                        
                        $sql = "SELECT AVG(star) AS avg_star FROM review WHERE uid = ".$_SESSION['id'];
                    }
                    
                    $result = $conn->query($sql);
                    while($row=$result->fetch_assoc()){
                        $avg_star = $row['avg_star'];
                    }
                    $avg_star_int = intval($avg_star);

                    // Calculate percentage
                    $rating_percentage = ($avg_star / 5) * 100;
                    if(isset($user_row)){
                        if(isset($user_row['id']) && !empty($user_row['profile_pic'])) {
                    
                            $profile_pic = "uploads/{$user_row['profile_pic']}";
                        } else {
                            $profile_pic = "assets/images/no_person.jpg";
                        }
                        


                        
                        $short_form = getCountryShortForm($user_row['country'], $country_codes);
                        $country_icon = "fi-".strtolower($short_form);

                        

                        // Fetch each row
                        
                        // Iterate through each field in the row
                        foreach ($user_row as $field => $value) {
                            $totalFields++;
                            if (!empty($value)) {
                                $nonEmptyFieldsCounter++;
                            }
                        }
                        $percentage = number_format(($nonEmptyFieldsCounter/$totalFields)*100,2);
                        
                    }
                    else{
                        
                        
                        $short_form = getCountryShortForm($_SESSION['country'], $country_codes);
                        $country_icon = "fi-".strtolower($short_form);

                        foreach ($_SESSION as $field => $value) {
                            $totalFields++;
                            if (!empty($value)) {
                                $nonEmptyFieldsCounter++;
                            }
                        }
                        $percentage = number_format(($nonEmptyFieldsCounter/$totalFields)*100,2);
                
                        if(isset($_SESSION['id']) && !empty($_SESSION['profile_pic'])) {
                
                            $profile_pic = "uploads/{$_SESSION['profile_pic']}";
                        } else {
                            $profile_pic = "assets/images/no_person.jpg";
                        }
                    }
                    
                    ?>
                    <div class="profile-container">
                        <img src="<?php echo $profile_pic;?>" alt="Profile Image" class="profile-image">
                        <?php
                        if(!isset($user_row)):
                        
                        ?>
                        <button class="change-button" onclick="changeImage()">+</button>
                        <?php endif;?>

                    </div>
                    <h2 class="profile-fullname"><b><?php echo ucfirst(strtolower($user_data['first_name']))." ".ucfirst(strtolower($user_data['last_name']))?> </b></h2>
                    <p style="font-weight: 500;"><?php echo ucfirst(strtolower($user_data['occupation']))?> | <?php echo ucfirst(strtolower($user_data['city']))?> | <?php echo ucfirst(strtolower($user_data['country']))?></p>
                    <div style="width:30%" class="pb-2">
                        <div class='bar-container' >
                            <div class='bar' style='width: <?php echo $percentage;?>%'><?php echo $percentage;?>%</div>
                        </div>
                        
                    </div>
                    <?php
                    if(!isset($user_row)):
                    ?>
                    <a href="#" id="editInfo">Edit Info</a>
                    <?php
                    endif;
                    ?>
                    <div >
                        <div class="rate">
                        <?php
                            // Assume $avg_star_int is the integer part of the average star rating
                            // and $avg_star is the exact average star rating

                            for ($i = 5; $i >= 1; $i--) {
                                echo '<input type="radio" id="star'.$i.'" name="rating-main" value="'.$i.'"';
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
                    </div>
                    <?php
                    if(isset($user_row)):
                    ?>
                    <div class="mb-4">
                        <button class="btn btn-primary" id="addReview" onclick="showReviewModal()">Add a Review</button>
                    </div>
                    <div class="rounded-buttons">
                        <button class="btn btn-primary btn-sm fill-on-hover ">+connect</button>
                        <button class="btn btn-outline-primary btn-sm fill-on-hover">message</button>
                    </div>
                    <?php
                    endif
                    ?>
                    <p class="profile-country-sm" ><span  class="fi <?php echo $country_icon;?>" ></p>
                    <div class="popup" id="country-popup">
                        <?php echo $user_data['country']?>
                    </div>
                    
                    
                    
                    
                    

                </div>
                <div class="col-md-4">
                    <p class="profile-country-bg"><span class="fi <?php echo $country_icon;?>" ></span><?php echo $user_data['country']?></p>
                    
                    
                    <br>
                    <br>
                    <br>
                    <a href="<?php echo $user_data['facebook']?>" target="__blank">
                        <p><img src="./images/icons/facebook.png" class="mr-2" height=32 width=32 alt="">Facebook</p>
                    </a>
                    <a href="<?php echo $user_data['instagram']?>" target="__blank">
                        <p><img src="./images/icons/instagram.png" class="mr-2" height=30 width=30 alt="">Instagram</p>
                    </a>
                    <a href="<?php echo $user_data['linkedin']?>" target="__blank">
                        <p><img src="./images/icons/LinkedIN.png" class="mr-2" height=30 width=30 alt="">LinkedIn</p>
                    </a>

                    
                </div>
                
                
            </div>
        </div>




        <div class="main-option-section row p-3">
            <p><span class="main-options about">About</span></p>
            <p><span class="main-options post">Post</span></p>
            <p><span class="main-options review">Review</span></p>
            <p><span class="main-options">Following</span></p>
            <p><span class="main-options">Followers</span></p>
        </div>
    </div>
    <!-- About Section -->
    
    <div class="about-section card mt-4" style="">
        <div class="card-body about-body">
            
            <div class="row">
                <div class="col-4 position-relative about-section-col">
                    <h5 class="section-title mb-4"><b>About</b></h5>
                    <button class="section-btn mb-3" onclick="toggleSection('personal-info')">Personal Info</button>
                    <button class="section-btn mb-3" onclick="toggleSection('contact-info')">Contact Info</button>
                    <button class="section-btn mb-3" onclick="toggleSection('social-info')">Social Links</button>
                    
                    
                </div>
                <div class="col-8 about-section-col">
                <div class="section-content personal-info-section active ml-3">
                    <h5 class="underlined">Personal info</h5>
                    <table>
                        <tr>
                            <td class="aligned-td">
                                <p><b>Occupation: </b></p>
                            </td>
                            <td class="aligned-td">
                                <p class="ml-md-2 ml-sm-1"><?php echo $user_data['occupation']?></p>
                            </td>
                        </tr>
                        <tr>
                            <td class="aligned-td">
                                <p><b>Lives In: </b></p>
                            </td>
                            <td class="aligned-td">
                                <p class="ml-md-2 ml-sm-1"><?php echo $user_data['city']?>, <?php echo $user_data['country']?></p>
                            </td>
                        </tr>
                        <tr>
                            <td class="aligned-td">
                                <p><b>Address: </b></p>
                            </td>
                            <td class="aligned-td">
                                <p class="ml-md-2 ml-sm-1"><?php echo $user_data['address']?></p>
                            </td>
                        </tr>
                        <tr>
                            <td class="aligned-td">
                                <p><b>Zip Code: </b></p>
                            </td>
                            <td class="aligned-td">
                                <p class="ml-md-2 ml-sm-1"><?php echo $user_data['zip']?></p>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="section-content contact-info-section ml-3">
                    <h5 class="underlined">Contact info</h5>
                    <table>
                        <tr>
                            <td class="aligned-td">
                                <p><b>Email: </b></p>
                            </td >
                            <td class="aligned-td">
                                <p class="ml-md-2 ml-sm-1"><a class="media-links" href="mailto:<?php echo $user_data['email']?>"><?php echo $user_data['email']?></a></p>
                            </td>
                        </tr>
                        <tr>
                            <td class="aligned-td">
                                <p><b>Contact No: </b></p>
                            </td>
                            <td class="aligned-td">
                                <p class="ml-md-2 ml-sm-1"><a class="media-links" href="tel:<?php echo $user_data['contact_no']?>"><?php echo $user_data['contact_no']?></a></p>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="section-content social-info-section ml-3">
                    <h5 class="underlined">Social Media Info</h5>
                    <table>
                        <tr>
                            <td class="aligned-td">
                                <p><b>Instagram: </b></p>
                            </td>
                            <td class="aligned-td">
                                <p class="ml-md-2 ml-sm-1"><a class="media-links" href="<?php echo $user_data['instagram']?>"><?php echo $user_data['instagram']?></a></p>
                            </td>
                        </tr>
                        <tr>
                            <td class="aligned-td">
                                <p><b>Facebook: </b></p>
                            </td>
                            <td class="aligned-td">
                                <p class="ml-2"><a class="media-links" href="<?php echo $user_data['facebook']?>"><?php echo $user_data['facebook']?></a></p>
                            </td>
                        </tr>
                        <tr>
                            <td class="aligned-td">
                                <p><b>LinkedIn: </b></p>
                            </td>
                            <td class="aligned-td">
                                <p class="ml-md-2 ml-sm-1"><a class="media-links" class="mr-2" href="<?php echo $user_data['linkedin']?>"><?php echo $user_data['linkedin']?></a></p>
                            </td>
                        </tr>
                    </table>
                </div>
                    <div class="vertical-line"></div>
                </div>
            </div>
            
        </div>
        
    </div>
    
    <div class="post-section card mt-4" style="display: none;">
        <div class="card-body about-body">
            <h3>Post</h3>
            <?php
            $sql = "SELECT post.id AS post_id, users.id AS user_id, post.*, users.*, TIMESTAMPDIFF(SECOND, post.created_at, NOW()) AS time_elapsed_seconds FROM post JOIN users ON post.uid = users.id ORDER BY post.created_at DESC;";
            $result = $conn->query($sql);
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
                <a href="./view_post.php?id=<?php echo $row['post_id']; ?>" style="text-decoration: none; color: inherit;">
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
                </a>
                <hr class="p-0 m-0">
                    
                
                </div>
                
                




            </div>
            
            <?php endwhile; ?>
        </div>
        
    </div>

    <div class="review-section card mt-4" style="display: none;">
        <div class="card-body">
            <h3>Review</h3>
            <?php
            
            $sql = "SELECT review.*, users.id as user_id,users.first_name, users.last_name, users.country,users.profile_pic FROM review LEFT JOIN users ON review.review_id = users.id WHERE review.uid = {$user_id} ORDER BY id desc";
            $reviews = $conn->query($sql);
            $tot_review = $reviews->num_rows;
            
            ?>
            <p><small><b><?php echo $tot_review; ?> review avaialble for this profile</b></small></p>
            <div class="row pl-3">
                <div class="top-aligned">
                    <div class="rate">
                        <?php
                            // Assume $avg_star_int is the integer part of the average star rating
                            // and $avg_star is the exact average star rating

                            for ($i = 5; $i >= 1; $i--) {
                                echo '<input type="radio" id="star'.$i.'" name="rating-reviews" value="'.$i.'"';
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
                </div>
                <p class="top-aligned"><small><b><?php echo $avg_star;?></b></small></p>
            </div>

            <table class="mb-5">
                <?php
                $sql = "SELECT star, AVG(star) AS avg_star, COUNT(*) AS total FROM review WHERE uid = {$user_id} GROUP BY star ORDER BY star desc;";
                $result = $conn->query($sql);
                while($row=$result->fetch_assoc()):
                    
                ?>
                <tr>
                    
                    <td class="top-aligned"><small><?php echo $row['star']?> Star</small></td>
                    <td class="top-aligned">
                        <div class="rating-bar">
                            <div class="rating-bar-filled" style="width:<?php echo ($row['avg_star'] / 5) * 100; ?>%;"></div>
                        </div>
                    </td>
                    <td><small>(<?php echo $row['total']?>)</small></td>
                    
                </tr>
                <?php endwhile; ?>
                
            </table>
            <div class="reviews">
                <?php while($row=$reviews->fetch_assoc()):?>
                <div class="row review-card m-4">
                    
                    
                    <div class="review-card-title">
                        
                        <div class="d-flex">
                            <?php
                            
                            if(isset($row['profile_pic']) && !empty($row['profile_pic'])) {
                        
                                $review_profile_pic = "uploads/{$row['profile_pic']}";
                            } else {
                                $review_profile_pic = "assets/images/no_person.jpg";
                            }
                            ?>
                            <img src="<?php echo $review_profile_pic;?>" alt="Profile Image" class="rating-profile-image mr-2">
                            <div>
                                <p class="ml-2 mb-0"><b><?php echo ucfirst(strtolower($row['first_name']))." ".ucfirst(strtolower($row['last_name']))?></b></p>
                                <div class="country-info d-flex align-items-center"> <!-- Added container for country info -->
                                    <i class="fi fi-us" style="height: 15px;"></i> <!-- Country flag -->
                                    <span class="ml-1"><small><?php echo $row['country']?></small></span> <!-- Country name -->
                                </div>
                            </div>
                        </div>
                        
                        <div class="row pl-3" >
                            <div >
                                
                                <div class="rate">
                                <?php
                                    // Assume $avg_star_int is the integer part of the average star rating
                                    // and $avg_star is the exact average star rating

                                    for ($i = 5; $i >= 1; $i--) {
                                        echo '<input type="radio" id="star'.$i.'" name="rating'.$row['id'].'" value="'.$i.'"';
                                        if ($row['star'] == $i) {
                                            echo ' checked';
                                        } else {
                                            echo ' disabled';
                                        }
                                        echo ' />';
                                        echo '<label for="star'.$i.'" title="'.$i.' stars">'.$i.' stars</label>';
                                    }
                                ?>
                                </div>
                            </div>
                            <p><small><b><?php echo number_format($row['star'], 1);?></b> | <?php echo $row['date']?></small></p>
                        </div>
                        
                        <p><?php echo $row['review']?></p>

                    </div>

                    
                </div>
                <?php endwhile;?>
                
            </div>
            
        </div>
        
    </div>
    
    
    
    
  
    
</div>


<!-- Add this modal code before the closing </body> tag -->
<?php
if(!isset($user_row)):
?>
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Select Profile Image</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="file" id="imageInput" accept="image/*">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="uploadImage()">Upload</button>
            </div>
        </div>
    </div>
</div>

<div id="editModal" class="modal edit-modal">
    
  <div class="modal-content edit-modal-content" >
    
    <div class="container">
        <div class="modal-title">
            <h3>Edit Info</h3>
        </div>
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
            <button class="nav-link active" id="personal-tab" data-bs-toggle="tab" data-bs-target="#personal" type="button" role="tab" aria-controls="personal" aria-selected="true">Personal Info</button>
            </li>
            <li class="nav-item" role="presentation">
            <button class="nav-link " id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Contact Info</button>
            </li>
            <li class="nav-item" role="presentation">
            <button class="nav-link" id="social-tab" data-bs-toggle="tab" data-bs-target="#social" type="button" role="tab" aria-controls="social" aria-selected="false">Social Media</button>
            </li>
        </ul>
        <div class="tab-content mt-3 pl-3 pr-3" id="myTabContent">
            <div class="tab-pane fade show active" id="personal" role="tabpanel" aria-labelledby="personal-tab">
                <form method="post" action="./api/change_info.php">
                    <input type="hidden" name="tab_type" value="personal">
                    <div class="row mb-3">
                        
                        <label for="exampleInputEmail1" class="form-label">First Name*</label>
                        <input type="Name" name="first_name" class="form-control p-4"  aria-describedby="emailHelp" value="<?php echo $user_data['first_name'];?>" required>
                        
                    </div>
                    <div class="row  mb-3">
                        
                        <label for="exampleInputEmail1" class="form-label">Last Name*</label>
                        <input type="Name" name="last_name" class="form-control p-4" " aria-describedby="emailHelp" value="<?php echo $user_data['last_name'];?>" required>
                        
                    </div>
                    <div class="row  mb-3">
                        
                        <label for="exampleInputEmail1" class="form-label">Occupation*</label>
                        <input type="text" name="occupation" class="form-control p-4"  aria-describedby="emailHelp"  value="<?php echo $user_data['occupation'];?>" required>
                        
                       
                        
                    </div>
                    
                    <div class="row  mb-3">
                        
                        <div class="col-6 mb-3">
                        <label for="countrySelect" class="form-label">Country*</label>
                        <select id="countrySelect" name="country" class="form-select" onchange="updateCityDropdown()" value="<?php echo $user_data['country'];?>" >
                            <!-- Country options will be populated dynamically -->
                        </select>
                        </div>
                        <div class="col-6 mb-3">
                        <label for="citySelect" class="form-label">City*</label>
                        <select id="citySelect" name="city" class="form-select" onchange="applySelection()" >
                            <option value="">Select City</option>
                            <!-- City options will be populated dynamically based on the selected country -->
                        </select>
                        </div>
                        <div class="col-6 mb-3">
                        <label for="countrySelect" class="form-label">Zip Code*</label>
                        <input type="number" name="zip" class="form-control p-4"  aria-describedby="emailHelp"  value="<?php echo $user_data['zip'];?>" required>
                        </div>
                    
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Address*</label>
                        <textarea name="address" id="" cols="10"  class="form-control p-4"  value="<?php echo $user_data['contact_no'];?>" required></textarea>
                        <!-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> -->
                    </div>
                    

                    
                    

                    
                
                    <button type="submit" class="btn btn-primary p-3 w-100 mt-5" style="font-size: 20px;">Update Perosnal Info</button>
                </form>
            </div>
            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                <form method="post" action="./api/change_info.php">
                    <input type="hidden" name="tab_type" value="contact">
                    <div class="row  mb-3">
                        
                        <label for="exampleInputEmail1" class="form-label">Email address*</label>
                        <input type="email" name="email" class="form-control p-4"  aria-describedby="emailHelp"  value="<?php echo $user_data['email'];?>" required>
                       
                    </div>
                    <div class="row  mb-3">
                        
                        <label for="exampleInputEmail1" class="form-label">Contact No*</label>
                        <input type="tel" name="contact_no" class="form-control p-4"  aria-describedby="emailHelp" value="<?php echo $user_data['contact_no'];?>" required>
                        
                    </div>
                    
                    
                    
                
                    <button type="submit" class="btn btn-primary p-3 w-100 mt-5" style="font-size: 20px;">Update Contact Info</button>
                </form>
            </div>
            <div class="tab-pane fade" id="social" role="tabpanel" aria-labelledby="social-tab">
                <form method="post" action="./api/change_info.php">
                    <input type="hidden" name="tab_type" value="social">
                    <div class="row  mb-3">
                        
                        <label for="exampleInputEmail1" class="form-label">Facebook Profile Link*</label>
                        <input type="text" name="facebook" class="form-control p-4"  aria-describedby="emailHelp"  value="<?php echo $user_data['facebook'];?>" >
                        
                    </div>
                    <div class="row  mb-3">
                        
                        <label for="exampleInputEmail1" class="form-label">Instagram profile Link*</label>
                        <input type="text" name="instagram" class="form-control p-4"  aria-describedby="emailHelp" value="<?php echo $user_data['instagram'];?>" >
                        
                    </div>
                    <div class="row  mb-3">
                        
                        <label for="exampleInputEmail1" class="form-label">LinkedIn profile Link*</label>
                        <input type="text" name="linkedin" class="form-control p-4"  aria-describedby="emailHelp" value="<?php echo $user_data['linkedin'];?>" >
                        
                    </div>
                        
                        
                        
                    
                        <button type="submit" class="btn btn-primary p-3 w-100 mt-5" style="font-size: 20px;">Update Contact Info</button>
                </form>
            </div>
        </div>
        
    </div>
    
  </div>
</div>
<?php
else:
?>
<div class="modal fade" id="ReviewModal" tabindex="-1" aria-labelledby="ReviewModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="reviewForm" method="post" action="./api/add_review.php" >
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ReviewModalLabel">Write a Review</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    
                        <input type="hidden" class="form-control" id="uid" name="uid" value="<?php echo isset($user_row['id']) ? $user_row['id'] : ''; ?>">
                        <div class="form-group">
                            <label for="review">Review:</label>
                            <textarea class="form-control" id="review" name="review" rows="4"></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="star">Star Rating:</label>
                            <input type="number" class="form-control" id="star" name="star" min="1" max="5">
                        </div>
                        
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" >Submit Review</button>
                </div>
            </div>
        </form>
    </div>
    
</div>
<?php
endif;
?>












<!-- Bootstrap JS dependencies -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


<script>
    $(document).ready(function(){
        $(".main-options").click(function(){
            // Hide all sections
            $(".about-section, .post-section, .review-section").hide();
            
            // Get the class of the clicked link
            var sectionClass = $(this).attr("class").split(' ')[1];
            
            // Show the corresponding section
            $("." + sectionClass + "-section").show();
        });
        <?php
        if(isset($section)):
        ?>
        $(".about-section, .post-section, .review-section").hide();
        $("." + "<?php echo $section;?>").show();
        <?php
        endif;
        ?>
    });
    function toggleSection(section) {
        $('.section-content').each(function() {
            
            if ($(this).hasClass(section + '-section')) {
                $(this).toggleClass('active');
            } else {
                $(this).removeClass('active');
            }
        });
    }
    <?php
    if(!isset($user_row)):
    ?>

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


    function changeImage() {
        $('#imageModal').modal('show');
    }
    // Function to handle image upload
    function uploadImage() {
        // Get the selected image file
        var file = $('#imageInput')[0].files[0];

        // Check if a file is selected
        if (file) {
            var formData = new FormData();
            formData.append('image', file);

            // Make AJAX request
            $.ajax({
                url: 'api/change_profile_picture.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    // Assuming the response contains the new image URL
                    
                    var jsonObject = JSON.parse(response);
                    
                    if (jsonObject.success) {
                        // Update the profile image
                        console.log("Success");
                        console.log(jsonObject);
                        $('.profile-image').attr('src', "./uploads/"+jsonObject.imageUrl);
                        // Close the modal after updating the image
                        $('#imageModal').modal('hide');
                    } else {
                        alert('Failed to change profile picture. Please try again.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    alert('An error occurred while changing profile picture.');
                }
            });
        } else {
            // Handle case where no file is selected
            alert('Please select an image.');
        }
    }
    <?php
    else:
    ?>
    function showReviewModal() {
        $('#ReviewModal').modal('show');
    }
    <?php
    endif;
    ?>
    

    

</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var profileCountry = document.querySelector('.profile-country-sm');
        var popup = document.getElementById('country-popup');

        profileCountry.addEventListener('click', function() {
            if (popup.style.display === 'none' || popup.style.display === '') {
                popup.style.display = 'block';
            } else {
                popup.style.display = 'none';
            }
        });

        // Close the popup if clicked outside
        document.addEventListener('click', function(event) {
            if (!profileCountry.contains(event.target) && !popup.contains(event.target)) {
                popup.style.display = 'none';
            }
        });
    });
</script>

<!-- JavaScript to handle modal functionality -->
<script>
  // Get the modal
  var modal = document.getElementById("editModal");

  // Get the link that opens the modal
  var editLink = document.getElementById("editInfo");

  // Get the <span> element that closes the modal
  var closeBtn = document.getElementsByClassName("close")[0];

  // When the user clicks the link, open the modal
  editLink.onclick = function() {
    modal.style.display = "flex";
    loadCountries();
  }

  // When the user clicks on <span> (x), close the modal
  closeBtn.onclick = function() {
    modal.style.display = "none";
  }

  // When the user clicks anywhere outside of the modal, close it
  window.onclick = function(event) {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  }



    $(document).ready(function(){
        $('.nav-link').on('click', function(){
            // Remove active class from all tabs
            $('.nav-link').removeClass('active');
            // Add active class to the clicked tab
            $(this).addClass('active');
            // Hide all tab content
            $('.tab-pane').removeClass('show active');
            // Show the corresponding tab content
            var targetTab = $(this).attr('data-bs-target');
            $(targetTab).addClass('show active');
        });
    });
</script>

</body>
</html>
