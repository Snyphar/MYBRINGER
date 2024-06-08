<?php
// Start the session
session_start();
if(isset($_SESSION['id'])){
    header("Location: index.php");
}

// Other PHP code goes here
?>
<!DOCTYPE html>
<html lang="en">
<?php
include 'db_connect.php';
// Check if the form is submitted
$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include the database connection file
    include 'db_connect.php';

    // Get the form values
    $email = $_POST['email'];
    $password = $_POST['password']; // Assuming the input name is 'password'
    $password_hash = md5($_POST['password']);
    
    echo $email;
    echo $password;

    // Prepare and execute the SQL query to retrieve user from database
    $sql = "SELECT * FROM users WHERE email = ? AND password = ? AND (auth_id IS NULL OR auth_id = '')";
    $stmt = $conn->prepare($sql);

    // Bind parameters
    $stmt->bind_param("ss", $email, $password_hash);

    // Execute the statement
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // Check if user exists and password matches
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['id'] = $row['id'];
        $_SESSION['first_name'] = $row['first_name'];
        $_SESSION['last_name'] = $row['last_name'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['contact_no'] = $row['contact_no'];
        $_SESSION['nid'] = $row['nid'];
        $_SESSION['passport'] = $row['visa_no'];
        $_SESSION['visa_no'] = $row['visa_no'];
        $_SESSION['country'] = $row['country'];
        $_SESSION['city'] = $row['city'];
        $_SESSION['occupation'] = $row['occupation'];
        $_SESSION['address'] = $row['address'];
        $_SESSION['facebook'] = $row['facebook'];
        $_SESSION['instagram'] = $row['instagram'];
        $_SESSION['linkedin'] = $row['linkedin'];
        $_SESSION['created_at'] = $row['created_at'];
        $_SESSION['profile_pic'] = $row['profile_pic'];
        $_SESSION['zip'] = $row['zip'];
        $_SESSION['verified'] = $row['verified'];

        if($_SESSION['verified']){
            header("Location: index.php");
        }
        else{
            header("Location: verification.php");
        }

        
        
        
    } else {
        // User not found, display error message
        $error = "Invalid email or password!";
    }
}
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

        .center {
            text-align: center;
        }
        
        

        
    </style>
</head>

<body >

<?php include 'navbar.php'; ?>

<div class="container-fluid cover-section">
    <div class="container mt-3 typing-conatiner pt-5">
        <div class="typing-effect transparent">
            Send, receive, and carry parcels.
        </div>
    </div>
    
    <div class="container mt-5">
        <div class="card">
            <div class="card-body">
                <h1>Login </h1>

                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <p><?php echo $error?></p>
                    <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email address</label>
                    <input type="email" name='email' name class="form-control p-4" id="exampleInputEmail1" aria-describedby="emailHelp" required>
                    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                    </div>
                    <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input type="password" name='password' class="form-control p-4" id="exampleInputPassword1" required>
                    </div>
                    <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input " id="exampleCheck1">
                    <label  class="form-text">Check me out</label>
                    </div>
                    <div class="mb-3">
                    
                    <label  class="form-text">Don't have an account? <a href="signup.php">Sign up</a> here.</label>
                    </div>
                    <button type="submit" class="btn btn-primary p-3 w-100" style="font-size: 20px;">Submit</button>
                </form>
                <div class="center mt-5">
                    <p>OR</p>
                    <a href="oauth1.php" class=" w-100">
                        <img src="./images/icons/google.png" alt="Google logo" height="20"> Login with Google
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>





<!-- Bootstrap JS dependencies -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
