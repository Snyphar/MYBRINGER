<?php
// Start the session
session_start();

include 'db_connect.php';

// Initialize response array
$response = array();

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Set parameters
        $post_type = $_POST['post_type'];
        $from_location = $_POST['from_location'];
        $to_location = $_POST['to_location'];
        $parcel_type = $_POST['parcel_type'];
        $parcel_size = $_POST['parcel_size'];
        $weight = $_POST['weight'];
        $weight_scale = 0;
        $details = $_POST['details'];

        $pickup_date_start = $_POST['pickup_date_start'];
        $pickup_date_end = $_POST['pickup_date_end'];
        $dropoff_date_start = $_POST['dropoff_date_start'];
        $dropoff_date_end = $_POST['dropoff_date_end'];



        // Initialize an array to store empty fields
        $empty_fields = [];

        // Check each field for emptiness
        if ($post_type === "") {
            $empty_fields[] = "Post Type";
        }
        if ($from_location === "") {
            $empty_fields[] = "From Location";
        }
        if ($to_location === "") {
            $empty_fields[] = "To Location";
        }
        if ($parcel_type === "") {
            $empty_fields[] = "Parcel Type";
        }
        if ($parcel_size === "") {
            $empty_fields[] = "Parcel Size";
        }
        if ($weight === "") {
            $empty_fields[] = "Weight";
        }
        if ($weight_scale === "") {
            $empty_fields[] = "Weight Scale";
        }
        if ($details === "") {
            $empty_fields[] = "Details";
        }
        if ($pickup_date_start === "") {
            $empty_fields[] = "Pickup Date Start";
        }
        if ($pickup_date_end === "") {
            $empty_fields[] = "Pickup Date End";
        }
        if ($dropoff_date_start === "") {
            $empty_fields[] = "Dropoff Date Start";
        }
        if ($dropoff_date_end === "") {
            $empty_fields[] = "Dropoff Date End";
        }
        

        // Check if any fields are empty
        if (!empty($empty_fields)) {
            // At least one field is empty, create an error message
            $error_message = "The following fields cannot be empty: " . implode(", ", $empty_fields);
            // You can handle this error message accordingly, like displaying it on the form
            $response['success'] = false;
            $response['message'] = "Error: " . $error_message;
        } else {
            // All fields are filled, proceed with your logic here
            // Do something if everything is filled
            // Prepare and execute the SQL statement
            $stmt = $conn->prepare("INSERT INTO post (from_location, to_location, parcel_type, parcel_size, weight, weight_scale, details, pickup_date_start, pickup_date_end, dropoff_date_start, dropoff_date_end,uid,post_type) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssddddsssssdd", $from_location, $to_location, $parcel_type, $parcel_size, $weight, $weight_scale, $details, $pickup_date_start, $pickup_date_end, $dropoff_date_start, $dropoff_date_end, $_SESSION['id'], $post_type);

            if ($stmt->execute()) {
                $response['success'] = true;
                $response['message'] = "New record created successfully";
            } else {
                throw new Exception("Error: " . $stmt->error);
            }

            // Close statement
            $stmt->close();
        }

        
    } catch (Exception $e) {
        $response['success'] = false;
        $response['message'] = "Error: " . $e->getMessage();
    }
}

// Close connection
$conn->close();

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
