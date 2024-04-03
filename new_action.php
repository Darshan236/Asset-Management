<?php
require 'core/init.php';

// Check if asset ID is provided in the URL
if(isset($_GET['id'])) {
    // Retrieve the asset ID from the URL
    $asset_id = $_GET['id'];

    // Fetch the file path from the database based on the asset ID
    $document_query = mysqli_query($con, "SELECT file_path FROM assets WHERE id = $asset_id");

    // Check if the asset exists and has a document associated with it
    if(mysqli_num_rows($document_query) > 0) {
        $document_data = mysqli_fetch_assoc($document_query);
        $file_path = $document_data['file_path'];

        // Check if the file path is not empty
        if(!empty($file_path)) {
            // Log the file path for debugging
            echo "File Path: " . $file_path;

            // Check if the file path already includes the base path
            if(strpos($file_path, 'D:/DARSHAN/xampp/htdocs/Assets-management-system-in-php-master/uploads/') !== 0) {
                // If not, concatenate the base path
                $full_path = 'D:/DARSHAN/xampp/htdocs/Assets-management-system-in-php-master/uploads/' . $file_path;
            } else {
                // Otherwise, use the file path as is
                $full_path = $file_path;
            }

            // Log the full path for debugging
            echo "Full Path: " . $full_path;

            // Check if the file exists
            if(file_exists($full_path)) {
                // Set appropriate headers for file display
                header('Content-Type: application/pdf'); // Modify the content type based on the file type
                header('Content-Disposition: inline; filename="'.basename($full_path).'"');
                header('Content-Transfer-Encoding: binary');
                header('Accept-Ranges: bytes');
                @readfile($full_path);
                exit;
            } else {
                echo "Document not found!";
            }
        } else {
            echo "File path is empty!";
        }
    } else {
        echo "Asset not found!";
    }
} else {
    echo "Asset ID not provided!";
}
?>
