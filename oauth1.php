<?php
session_start();
include 'db_connect.php';

function loginUser($conn, $email, $auth_id) {
    // Prepare SQL statement
    $sql = "SELECT * FROM users WHERE email = ? AND auth_id = ?";
    $stmt = $conn->prepare($sql);

    // Bind parameters
    $stmt->bind_param("ss", $email, $auth_id);

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

        
        return true; // Login successful
    } else {
        return false; // Login failed
    }
}

// Google OAuth2 configuration
$clientID = '59451830227-lcgtmiq1ti8ek17mn94207ggg303ebin.apps.googleusercontent.com';
$clientSecret = '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';
$redirectUri = 'http://localhost:8000/Courier/oauth1.php';
$authUrl = 'https://accounts.google.com/o/oauth2/auth';
$tokenUrl = 'https://oauth2.googleapis.com/token';
$userInfoUrl = 'https://www.googleapis.com/oauth2/v1/userinfo';

// Step 1: Redirect users to Google's OAuth2 authorization endpoint
if (!isset($_GET['code'])) {
    $params = array(
        'client_id'     => $clientID,
        'redirect_uri'  => $redirectUri,
        'response_type' => 'code',
        'scope'         => 'email profile',
        'state'         => uniqid('', true), // Optionally, you can add state parameter for security
    );

    $authUrl .= '?' . http_build_query($params);
    header('Location: ' . $authUrl);
    exit;
}

// Step 2: Exchange authorization code for access token
if (isset($_GET['code'])) {
    $code = $_GET['code'];

    $tokenParams = array(
        'client_id'     => $clientID,
        'client_secret' => $clientSecret,
        'redirect_uri'  => $redirectUri,
        'code'          => $code,
        'grant_type'    => 'authorization_code',
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $tokenUrl);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($tokenParams));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    $accessToken = json_decode($response, true)['access_token'];

    // Step 3: Fetch user information using access token
    $userInfoUrl .= '?access_token=' . $accessToken;
    $userInfo = file_get_contents($userInfoUrl);
    $userData = json_decode($userInfo, true);

    echo $userInfo;
    echo $userData['email'];

    $first_name = $userData['given_name'];
    $last_name = $userData['family_name'];
    $email = $userData['email'];
    $profile_url = $userData['picture'];
    $fileName = '';
    $auth_id = $userData['id'];

    if (loginUser($conn, $email, $auth_id)) {
        // If login successful, redirect to index.php
        if($_SESSION['verified']){
            header("Location: index.php");
        }
        else{
            header("Location: verification.php");
        }
        
    }
    
    if(!empty($profile_url)){
        $imageContent = file_get_contents($profile_url);

        if ($imageContent !== false) {
            // Define the file path where you want to save the image
            $fileName = uniqid() . '.jpg';

            // Save the image file to a directory
            $uploadDirectory = 'uploads/';
            $filePath = $uploadDirectory . $fileName;
            // Save the image content to a file
            $saved = file_put_contents($filePath, $imageContent);
            
            if ($saved !== false) {
                echo "Image saved successfully to $filePath";
            } else {
                echo "Failed to save the image.";
            }
        } else {
            echo "Failed to fetch the image content.";
        }
    }

    // Prepare SQL statement to insert data into the users table
    $sql = "INSERT INTO users (first_name, last_name, auth_id, email, profile_pic) VALUES (?, ?, ?, ?, ?)";
    
    // Prepare the SQL statement
    $stmt = $conn->prepare($sql);

    // Bind parameters
    $stmt->bind_param("sssss", $first_name, $last_name, $auth_id, $email, $fileName);

    // Execute the statement
    if ($stmt->execute()) {
      // Registration successful
      // Trigger SweetAlert
      if (loginUser($conn, $email, $auth_id)) {
        // If login successful, redirect to index.php
        
        if($_SESSION['verified']){
            header("Location: index.php");
        }
        else{
            header("Location: verification.php");
        }
    } else {
        // If login failed, display an error message
        $error = "Login failed. Invalid email!";
    }
      
      
    } else {
        // Registration failed
        echo "Error: " . $conn->error;
    }


    
}
