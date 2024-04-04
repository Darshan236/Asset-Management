<?php
require 'core/init.php';

// Check if user is logged in
if (logged_in() === false) {
    session_destroy();
    header('Location:index.php');
    exit();
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $id = $_POST['asset_id'];
    $sw1 = $_POST['sw1'];
    $sw2 = $_POST['sw2'];
    $sw3 = $_POST['sw3'];
    $sw4 = $_POST['sw4'];
    $sw5 = $_POST['sw5'];
    $sw6 = $_POST['sw6'];
    
    // Retrieve faculty names
    $faculty1 = $_POST['faculty1'];
    $faculty2 = $_POST['faculty2'];
    $faculty3 = $_POST['faculty3'];
    $faculty4 = $_POST['faculty4'];
    $faculty5 = $_POST['faculty5'];
    $faculty6 = $_POST['faculty6'];

    // Get quantity from the database
    $sqlQuantity = "SELECT quantity FROM materials WHERE id = '$id'";
    $resultQuantity = $con->query($sqlQuantity);
    $rowQuantity = $resultQuantity->fetch_assoc();
    $quantity = $rowQuantity['quantity'];

    // Calculate total SW value
    $totalSw = $sw1 + $sw2 + $sw3 + $sw4 + $sw5 + $sw6;

    // Check if total SW value exceeds quantity
    
    if ($totalSw > $quantity) {
        echo '<span style="color: red;">Error: Total SW value exceeds quantity</span>';
    }
    else {
     // Construct the UPDATE query
    $sql = "UPDATE materials SET sw1 = '$sw1', sw2 = '$sw2', sw3 = '$sw3', sw4 = '$sw4', sw5 = '$sw5', sw6 = '$sw6', assign = '$totalSw', faculty1 = '$faculty1', faculty2 = '$faculty2', faculty3 = '$faculty3', faculty4 = '$faculty4', faculty5 = '$faculty5', faculty6 = '$faculty6' WHERE id = '$id'";

    // Execute the query
    if ($con->query($sql) === TRUE) {
    // Redirect to materials.php after successful update
    header('Location: materials.php');
    exit();
    } else {
    echo "Error updating data: " . $con->error;
}
}

}

// Retrieve current values from the database
$id = $_GET['id'];
$sql = "SELECT sw1, sw2, sw3, sw4, sw5, sw6,faculty1,faculty2,faculty3,faculty4,faculty5,faculty6 FROM materials WHERE id = '$id'";
$result = $con->query($sql);
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Asset Management System</title>
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" type="text/css" media="screen" href="css/screen.css">
    <link rel="stylesheet" href="css/home.css" />
</head>
<body>
<div id="page">
<header>
        <a title="asset" href="home.php">
            <div class="logo">
                <img src="images/logo.png" height="66px" weight="66px" />
                <span id="title">Asset Management System</span>
            </div>
        </a>

        <nav>
            <label for="email">Welcome <?php echo $user_data['first_name']; ?> </label>
            <a href="home.php"><input type="image" src="images/icons/home.png" title="Home" value="home " style="margin-left:10px;"/></a>
            <a href="profile.php"><input type="image" src="images/icons/user.png" title="Profile" value="settings " style="margin-left:10px;"/></a>
            <a href="logout.php"><input type="image" src="images/icons/logout.png" title="Logout" value="Sign Out" style="margin-left:10px;"/></a>
        </nav>

    </header>

    <div class="content-center">
        <div id="topic">Assign SW1 to SW6</div>
        <form action="" method="post">
            <input type="hidden" name="asset_id" value="<?php echo $id; ?>">
            <table border="0">
                <tr>
                    <th>SW1</th>
                    <th>SW2</th>
                    <th>SW3</th>
                    <th>SW4</th>
                    <th>SW5</th>
                    <th>SW6</th>
                </tr>
                <tr>
                    
                    <td><input type="text" name="sw1" value="<?php echo $row['sw1']; ?>"></td>
                    <td><input type="number" name="sw2" value="<?php echo $row['sw2']; ?>"></td>
                    <td><input type="number" name="sw3" value="<?php echo $row['sw3']; ?>"></td>
                    <td><input type="text" name="sw4" value="<?php echo $row['sw4']; ?>"></td>
                    <td><input type="number" name="sw5" value="<?php echo $row['sw5']; ?>"></td>
                    <td><input type="number" name="sw6" value="<?php echo $row['sw6']; ?>"></td>
                    
                </tr>
                <tr>
                    <th>Faculty Name1</th>
                    <th>Faculty Name2</th>
                    <th>Faculty Name3</th>
                    <th>Faculty Name4</th>
                    <th>Faculty Name5</th>
                    <th>Faculty Name6</th>    
                </tr>
                <tr>
                    <td><input type="text" name="faculty1" value="<?php echo $row['faculty1']; ?>"></td>               
                    <td><input type="text" name="faculty2" value="<?php echo $row['faculty2']; ?>"></td>
                    <td><input type="text" name="faculty3" value="<?php echo $row['faculty3']; ?>"></td>
                    <td><input type="text" name="faculty4" value="<?php echo $row['faculty4']; ?>"></td>
                    <td><input type="text" name="faculty5" value="<?php echo $row['faculty5']; ?>"></td>
                    <td><input type="text" name="faculty6" value="<?php echo $row['faculty6']; ?>"></td>

                </tr>
                
            </table>
            <input type="submit" name="update" value="Assign">
        </form>
    </div>
</div>
</body>
</html>
