<?php
session_start();
include '../db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get post data
    $postId = isset($_POST['postId']) ? intval($_POST['postId']) : 0;
    $commentText = isset($_POST['comment']) ? $_POST['comment'] : '';

    // Check if user is logged in
    if (!isset($_SESSION['id'])) {
        echo json_encode([
            "success" => 0,
            "message" => "User not logged in"
        ]);
        exit;
    }

    // Validate post ID and comment text
    if ($postId <= 0 || empty($commentText)) {
        echo json_encode([
            "success" => 0,
            "message" => "Invalid post ID or comment"
        ]);
        exit;
    }

    // Get the user ID of the commenter
    $userId = $_SESSION['id'];

    // Insert the comment into the database
    $stmt = $conn->prepare("INSERT INTO comments (post_id, uid, comment) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $postId, $userId, $commentText);


    // Check if the post_id exists in the post_notification table
    $checkNotificationSql = "SELECT * FROM post_notification WHERE post_id = $postId AND post_type = 1";
    $checkNotificationResult = $conn->query($checkNotificationSql);
    

    if ($checkNotificationResult->num_rows > 0) {
        $total_comments = $checkNotificationResult->num_rows;
        // Post_id exists, update the message
        $updateNotificationSql = "UPDATE post_notification SET message = '".$_SESSION['first_name']." and ".($total_comments-1)." others commented your post', seen = 0 WHERE post_id = $postId";
        
        $conn->query($updateNotificationSql);
    } else {
        // Post_id does not exist, insert a new notification
        $insertNotificationSql = "INSERT INTO post_notification (post_id, post_type, message, seen) VALUES ($postId, 1, '".$_SESSION['first_name']." commented your post.', 0)";
        $conn->query($insertNotificationSql);
    }

    if ($stmt->execute()) {
        echo json_encode([
            "success" => 1,
            "comment" => $commentText
        ]);
    } else {
        echo json_encode([
            "success" => 0,
            "message" => "Failed to add comment"
        ]);
    }

    $stmt->close();
} else {
    echo json_encode([
        "success" => 0,
        "message" => "Invalid request method"
    ]);
}

$conn->close();
?>
