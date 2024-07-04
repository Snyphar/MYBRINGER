<?php
// Start the session
session_start();
if(!isset($_SESSION['id'])){
    header("Location: login.php");
}
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

        .comment-item-text {
            margin-top: 5px;
            color: #666;
            max-width: 90%; /* Ensure it takes the full width of its parent by default */
            word-wrap: break-word; /* Break long words to wrap onto the next line */
            
            flex: 1; /* Allow it to take available space */
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
    
    <div class="container-lg container-md-fluid conatiner-sm-fluid mt-5 parent-div">
    <form id="postForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div class="card">
                <div class="card-body form-card">
                    <input type="hidden" id="from_country" name="from_country" value="" required>
                    <input type="hidden" id="to_country" name="to_country" value="" required>
                    <input type="hidden" id="from_city" name="from_city" value="" required>
                    <input type="hidden" id="to_city" name="to_city" value="" required>
                    <input type="hidden" id="pickup_date_start" name="pickup_date_start" value="" required>
                    <input type="hidden" id="pickup_date_end" name="pickup_date_end" value="" required>
                    <input type="hidden" id="dropoff_date_start" name="dropoff_date_start" value="" required>
                    <input type="hidden" id="dropoff_date_end" name="dropoff_date_end" value="" required>
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
                    <div class="text-center d-flex pt-4 form-row">
                        <label for="" class="pr-3">Details:</label>
                        <div class="input-group ">
                            
                            <textarea class="form-control" name="details"></textarea>
                            
                            
                        </div>
                    </div>
                    


                    
                    <div class="row justify-content-center mx-auto rounded-buttons mt-4">
                        <button type="submit" class="btn btn-filled btn-block" style="max-width: 200px;">Post</button>
                        
                        
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
<!-- Success Modal -->
<div class="modal" id="successModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Success!</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" >
                <p id="successMessage">Your post has been submitted successfully.</p>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="goToIndexBtn">Go to Index</button>
            </div>
        </div>
    </div>
</div>
<!-- Error Modal -->
<div class="modal" id="errorModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Error!</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p id="errorMessage"></p>
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
        }
        else{
            $("#toValue").html(city +", "+ country);
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
        console.log(pickup_date_start);
        pickup_date_end = picker.endDate.format('YYYY-MM-DD');
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
        console.log(dropoff_date_start);
        dropoff_date_end = picker.endDate.format('YYYY-MM-DD');
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
                parcel_size: $('input[name="parcel_size"]:checked').val(),
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
                url: 'submit_post.php', // Endpoint URL
                data: formData,
                success: function(response) {
                    // Check if the response indicates success
                    if (response.success) {
                        // Show success modal
                        $('#successModal').modal('show');
                        
                        // Handle redirection on clicking the "Go to Index" button
                        $('#goToIndexBtn').click(function() {
                            // Redirect to index page
                            window.location.href = 'index.php';
                        });
                    } else {
                        // Show error modal with the reason
                        $('#errorMessage').text(response.message);
                        $('#errorModal').modal('show');
                    }
                },
                error: function(xhr, status, error) {
                    // Handle error
                    console.error(xhr.responseText);
                    // Show generic error modal
                    $('#errorMessage').text('Error occurred while submitting the form. Please try again.');
                    $('#errorModal').modal('show');
                }
            });

        });
    });
</script>


</body>
</html>
