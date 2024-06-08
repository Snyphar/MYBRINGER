<?php
// Start the session
session_start();
include "db_connect.php";



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
<div class="card">
    <div class="card-header">
        <div class="container">
            <div class="row rounded-buttons mt-4">
                <div class="pr-3">
                    <button class="btn btn-info btn-sm btn-info-filled btn-block" style="max-width: 100px; min-width:70px;">  All  </button>
                </div>
                <div class="pr-3">
                    <button class="btn btn-info btn-sm btn-info-filled btn-block" style="max-width: 150px;">My Posts</button>
                </div>
                <div class="pr-3">
                    <button class="btn btn-info btn-sm btn-info-filled btn-block" style="max-width: 150px;">Unread Posts</button>
                </div>
                <div class="pr-3">
                    <button class="btn btn-info btn-sm btn-info-filled btn-block" style="max-width: 150px;">Read All</button>
                </div>
                <div class="pr-3">
                    <button class="btn btn-info btn-sm btn-info-filled btn-block" style="max-width: 150px;">Unread Posts</button>
                </div>
                
                
                
                
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


</body>
</html>
