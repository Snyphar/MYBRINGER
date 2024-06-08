<?php
session_start();
include "../db_connect.php";

// Check if a file was uploaded
if (!isset($_SESSION['id'])) {
    echo json_encode(array('success' => false, 'message' => 'You are not logged in!'));
} else if ($_FILES['image']) {
    // Get the uploaded image
    $file = $_FILES['image'];

    // Check if the file is an image
    if (exif_imagetype($file['tmp_name'])) {
        // Load the image
        $image = imagecreatefromstring(file_get_contents($file['tmp_name']));

        // Get image dimensions
        $width = imagesx($image);
        $height = imagesy($image);

        // Calculate the new width based on the aspect ratio
        $newWidth = $width * (250 / $height);
        $newHeight = 250;

        // Create a new image with the resized dimensions
        $resizedImage = imagecreatetruecolor($newWidth, $newHeight);

        // Resize the image
        imagecopyresampled($resizedImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

        // Save the resized image as a base64 string
        ob_start();
        imagejpeg($resizedImage);
        $imageData = ob_get_contents();
        ob_end_clean();
        $base64Image = 'data:image/jpeg;base64,' . base64_encode($imageData);

        // Generate a unique file name
        $fileName = uniqid() . '.jpg';

        // Save the image file to a directory
        $uploadDirectory = '../uploads/';
        $filePath = $uploadDirectory . $fileName;
        imagejpeg($resizedImage, $filePath);

        // Insert the file name into the database
        $userId = $_SESSION['id'];
        $insertQuery = "UPDATE users SET profile_pic = '$fileName' WHERE id = $userId";
        if (mysqli_query($conn, $insertQuery)) {
            // Output success message with image URL
            $_SESSION['profile_pic'] = $fileName;
            echo json_encode(array('success' => true, 'imageUrl' => $fileName));
        } else {
            // Error in inserting file name into database
            echo json_encode(array('success' => false, 'message' => 'Error in updating profile picture.'));
        }

        // Free up memory
        imagedestroy($image);
        imagedestroy($resizedImage);
    } else {
        // Not an image file
        
        echo json_encode(array('success' => false, 'message' => 'Uploaded file is not an image.'));
    }
} else {
    // No file uploaded
    echo json_encode(array('success' => false, 'message' => 'No file uploaded.'));
}
?>
