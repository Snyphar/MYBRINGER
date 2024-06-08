<?php
// Start the session
session_start();

// Other PHP code goes here
?>
<!DOCTYPE html>
<html lang="en">
<?php
include 'db_connect.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $contact_no = $_POST['contact_no'];
    $gender = $_POST['gender'];
    $country = $_POST['country'];
    $city = $_POST['city'];
    $address = $_POST['address'];
    $zip = $_POST['zip'];
    $password = md5($_POST['password']); // Hash the password for security
    

    // Prepare SQL statement to insert data into the users table
    $sql = "INSERT INTO users (first_name, last_name, gender, email, contact_no, country, city, address, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    // Prepare the SQL statement
    $stmt = $conn->prepare($sql);

    // Bind parameters
    $stmt->bind_param("ssdssssss", $first_name, $last_name, $gender, $email, $contact_no, $country, $city, $address, $password);

    // Execute the statement
    if ($stmt->execute()) {
      // Registration successful
      // Trigger SweetAlert
      $registered = TRUE;
      
    } else {
        // Registration failed
        echo "Error: " . $conn->error;
    }
    
    
    
}

// Close the connection
$conn->close();
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courier</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

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

        
        

        
    </style>
    <!-- favicon -->
    <link rel="icon" href="./Imgs/icons/Vector.png" />

    <!-- script tag -->
    <script defer src="js/script.js"></script>
    <script defer src="js/countries.js"></script>

    <!-- ScrollReveal -->
    <script src="https://unpkg.com/scrollreveal"></script>

    <!-- swiper js -->
    <link
      rel="stylesheet"
      href="https://unpkg.com/swiper@8/swiper-bundle.min.css"
    />

    <!-- SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- SweetAlert JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <?php
    // Check if the registration was successful
    
    ?>
    
</head>
<body onload="loadCountries()">
<?php include'navbar.php'; ?>


<div class="container-fluid cover-section">
    <div class="container mt-3 typing-conatiner pt-5">
        <div class="typing-effect transparent">
            Send, receive, and carry parcels.
        </div>
    </div>
    
    <div class="container mt-5">
        <div class="card">
            <div class="card-body">
                <h1>Register Account   </h1>

                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="row">
                      <div class="col-6 mb-3">
                        <label for="exampleInputEmail1" class="form-label">First Name*</label>
                        <input type="Name" name="first_name" class="form-control p-4" id="exampleInputEmail1" aria-describedby="emailHelp" required>
                        <!-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> -->
                      </div>
                      <div class="col-6 mb-3">
                        <label for="exampleInputEmail1" class="form-label">Last Name*</label>
                        <input type="Name" name="last_name" class="form-control p-4" id="exampleInputEmail1" aria-describedby="emailHelp" required>
                        <!-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> -->
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-6 mb-3">
                        <label for="exampleInputEmail1" class="form-label">Email address*</label>
                        <input type="email" name="email" class="form-control p-4" id="exampleInputEmail1" aria-describedby="emailHelp" required>
                        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                      </div>
                      <div class="col-6 mb-3">
                        <label for="exampleInputEmail1" class="form-label">Contact No*</label>
                        <input type="tel" name="contact_no" class="form-control p-4" id="exampleInputEmail1" aria-describedby="emailHelp" required>
                        <!-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> -->
                      </div>
                    </div>
                    
                    <div class="row">
                      
                      <div class="col-4 mb-3">
                        <label for="countrySelect" class="form-label">Country*</label>
                        <select id="countrySelect" name="country" class="form-select" onchange="updateCityDropdown()" required>
                            <!-- Country options will be populated dynamically -->
                        </select>
                      </div>
                      <div class="col-4 mb-3">
                        <label for="citySelect" class="form-label">States/City*</label>
                        <select id="citySelect" name="city" class="form-select" onchange="applySelection()" required>
                            <option value="">Select City</option>
                            <!-- City options will be populated dynamically based on the selected country -->
                        </select>
                      </div>
                      
                    
                    </div>
                    <div class="row">
                      <div class="col-4 mb-3">
                        <label for="countrySelect" class="form-label">Gender*</label><br>
                        <select  name="gender" class="form-select" required>
                            <option value="0">Male</option>
                            <option value="1">Female</option>
                            <option value="2">Others</option>
                        </select>
                      </div>
                      <div class="col-4 mb-3">
                        <label for="citySelect" class="form-label">ZIP Code*</label>
                        <input type="number" name="zip" class="form-control p-4" id="" required>
                      </div>
                    </div>
                    <div class="mb-3">
                      <label for="exampleInputEmail1" class="form-label">Address*</label>
                      <textarea name="address" id="" cols="10"  class="form-control p-4" required></textarea>
                      <!-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> -->
                    </div>
                    <div class="row">
                      <div class="mb-3 col-6">
                        <label for="exampleInputPassword1" class="form-label">Password*</label>
                        <input type="password" name="password" class="form-control p-4" id="exampleInputPassword1" required>
                      </div>
                      <div class="mb-3 col-6">
                        <label for="exampleInputPassword1" class="form-label">Retype Password*</label>
                        <input type="password" class="form-control p-4" id="exampleInputPassword1" required>
                      </div>
                    </div>
    
                   
                    
    
                    <div id="emailHelp" class="form-text">Already have an account ! <a href="login.php"> Login  </a>.</div>
                
                    <button type="submit" class="btn btn-primary p-3 w-100 mt-5" style="font-size: 20px;">Register</button>
                  </form>
            </div>
        </div>
    </div>
</div>





<!-- Bootstrap JS dependencies -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<?php
if ($registered){
  echo '<script>
          Swal.fire({
              icon: "success",
              title: "Registration Successful!",
              text: "You have successfully registered.",
              confirmButtonText: "OK"
          }).then((result) => {
              // Redirect to login page after user clicks OK
              if (result.isConfirmed || result.isDismissed) {
                  window.location.href = "login.php";
              }
          });
      </script>';
}
?>
</body>
</html>
