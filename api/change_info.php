<?php
// Include database connection
session_start();
include '../db_connect.php';

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if required fields are set
    if (isset($_POST['tab_type'])) {
        $tabType = $_POST['tab_type'];
        
        // Assuming you have a session or some other way to identify the user
        $userId = $_SESSION['id'];

        // Update database based on tab type
        switch ($tabType) {
            case 'personal':
                $sql = "UPDATE users SET first_name=?, last_name=?, occupation=?, country=?, city=?, zip=?, address=? WHERE id=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssssssii", $_POST['first_name'], $_POST['last_name'], $_POST['occupation'], $_POST['country'], $_POST['city'], $_POST['address'], $_POST['zip'], $userId);
                break;
            case 'contact':
                $sql = "UPDATE users SET email=?, contact_no=? WHERE id=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssi", $_POST['email'], $_POST['contact_no'], $userId);
                break;
            case 'social':
                $sql = "UPDATE users SET facebook=?, instagram=?, linkedin=? WHERE id=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sssi", $_POST['facebook'], $_POST['instagram'], $_POST['linkedin'], $userId);
                break;
            default:
                // Invalid tab type
                echo "Invalid tab type";
                exit;
        }

        // Execute the prepared statement
        if ($stmt->execute()) {
            // Update session variables if update is successful
            switch ($tabType) {
                case 'personal':
                    $_SESSION['first_name'] = $_POST['first_name'];
                    $_SESSION['last_name'] = $_POST['last_name'];
                    $_SESSION['occupation'] = $_POST['occupation'];
                    $_SESSION['country'] = $_POST['country'];
                    $_SESSION['city'] = $_POST['city'];
                    $_SESSION['address'] = $_POST['address'];
                    $_SESSION['zip'] = $_POST['zip'];
                    break;
                case 'contact':
                    $_SESSION['email'] = $_POST['email'];
                    $_SESSION['contact_no'] = $_POST['contact_no'];
                    break;
                case 'social':
                    $_SESSION['facebook'] = $_POST['facebook'];
                    $_SESSION['instagram'] = $_POST['instagram'];
                    $_SESSION['linkedin'] = $_POST['linkedin'];
                    break;
            }
            header("Location: ../profile.php");
        } else {
            echo "Error updating record: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
        // Close the database connection
        $conn->close();
    } else {
        // Required field missing
        echo "Tab type not provided";
    }
} else {
    // Invalid request method
    echo "Invalid request method";
}
?>
