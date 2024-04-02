<?php
require 'core/init.php';

if(logged_in() === false){
    session_destroy();
    header('Location:index.php');
    exit();
} 

if(isset($_GET['delete_id'])) {
    $asset_id = $_GET['delete_id'];

    if(deleteAsset($con, $asset_id)) {
        header('Location: materials.php');
        exit();
    } else {
        echo "Error deleting asset.";
    }
} else {
    echo "Asset ID not provided.";
    exit();
}

function deleteAsset($con, $asset_id) {
    $query = "DELETE FROM materials WHERE id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $asset_id);
    return $stmt->execute();
}
?>
