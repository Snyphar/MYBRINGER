<?php
session_start();
include '../db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postId = isset($_POST['id']) ? intval($_POST['id']) : 0;
    // Assume the user ID is available via session or another method
    $userId = isset($_SESSION['id']) ? intval($_SESSION['id']) : 0;

    if ($postId > 0) {
        if ($userId > 0) {
            // Fetch the current like_id string
            $sql = "SELECT like_id FROM post WHERE id = $postId";
            $result = $conn->query($sql);

            if ($result) {
                $row = $result->fetch_assoc();
                $likeIdString = $row['like_id'];

                // Check if the user has already liked the post
                $likeIds = explode(",", $likeIdString);
                if (!in_array($userId, $likeIds)) {
                    // Add the new user ID to the like_id string
                    $likeIds[] = $userId;
                    $newLikeIdString = implode(",", $likeIds);
                    $total_likes = count($likeIds) - 1;
                    // Update the like_id string in the database
                    $updateSql = "UPDATE post SET like_id = '$newLikeIdString' WHERE id = $postId";
                    $updateResult = $conn->query($updateSql);
                    if ($updateResult) {
                        

                        // Check if the post_id exists in the post_notification table
                        $checkNotificationSql = "SELECT * FROM post_notification WHERE post_id = $postId AND post_type = 0";
                        $checkNotificationResult = $conn->query($checkNotificationSql);
                        

                        if ($checkNotificationResult->num_rows > 0) {
                            
                            // Post_id exists, update the message
                            $updateNotificationSql = "UPDATE post_notification SET message = '".$_SESSION['first_name']." and ".($total_likes-1)." others liked you post', seen = 0 WHERE post_id = $postId";
                            
                            $conn->query($updateNotificationSql);
                        } else {
                            // Post_id does not exist, insert a new notification
                            $insertNotificationSql = "INSERT INTO post_notification (post_id, post_type, message, seen) VALUES ($postId, 0, '".$_SESSION['first_name']." liked your post.', 0)";
                            $conn->query($insertNotificationSql);
                        }
                        echo json_encode([
                            "success" => 1,
                            "likes" => count($likeIds) - 1
                        ]);
                    } else {
                        echo json_encode([
                            "success" => 0,
                            "message" => "Failed to update like count"
                        ]);
                    }
                } else {
                    echo json_encode([
                        "success" => 0,
                        "message" => "User has already liked this post"
                    ]);
                }
            } else {
                echo json_encode([
                    "success" => 0,
                    "message" => "Failed to fetch post details"
                ]);
            }
        } else {
            echo json_encode([
                "success" => -1,
                "message" => "User not logged in"
            ]);
        }
    } else {
        echo json_encode([
            "success" => 0,
            "message" => "Invalid post ID"
        ]);
    }
} else {
    echo json_encode([
        "success" => 0,
        "message" => "Invalid request method"
    ]);
}

$conn->close();
?>
