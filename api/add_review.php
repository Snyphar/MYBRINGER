<?php
session_start();
include '../db_connect.php';
// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the required fields are set in the POST data
    if(!isset($_SESSION['id'])){
        header("Location: ../login.php");
    }
    if (isset($_POST['uid']) && isset($_POST['review']) && isset($_POST['star'])) {
        // Extract the values from the POST data
        $uid = $_POST['uid'];
        $review = $_POST['review'];
        $star = $_POST['star'];

        

        

        // Prepare and bind the SQL statement
        $stmt = $conn->prepare("INSERT INTO review (uid,review_id, review, star) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiss", $uid,$_SESSION['id'], $review, $star);

        // Execute the statement
        if ($stmt->execute()) {
            echo "Review submitted successfully";
        } else {
            echo "Error: " . $conn->error;
        }

        // Close the statement and connection
        $stmt->close();
        $conn->close();
        header("Location: ../profile.php?id={$uid}&section=review-section");
    } else {
        // Required fields are not set, handle the error
        echo "Error: Required fields are not set";
    }
} else {
    // Method not allowed, handle the error
    echo "Error: Method not allowed";
}
?>
