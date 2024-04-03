<?php
require 'core/init.php';

// Check if asset ID is provided in the URL
if(isset($_GET['id'])) {
    // Retrieve the asset ID from the URL
    $asset_id = $_GET['id'];

    // Fetch the file path from the database based on the asset ID
    $document_query = mysqli_query($con, "SELECT transaction_file FROM materials WHERE id = $asset_id");

    // Check if the asset exists and has a document associated with it
    if(mysqli_num_rows($document_query) > 0) {
        $document_data = mysqli_fetch_assoc($document_query);
        $file_path = $document_data['transaction_file'];

        // Check if the file path is not empty
        if(!empty($file_path)) {
            // Check if the file exists
            if(file_exists($file_path)) {
                // Set appropriate headers for file display
                header('Content-Type: application/pdf'); // Modify the content type based on the file type
                header('Content-Disposition: inline; filename="'.basename($file_path).'"');
                header('Content-Transfer-Encoding: binary');
                header('Accept-Ranges: bytes');
                @readfile($file_path);
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
