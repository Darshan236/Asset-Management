<?php
require 'core/init.php';

// Check if the user is logged in
if(logged_in() === false){
    session_destroy();
    header('Location:index.php');
    exit();
} 

// Retrieve data from the materials_assign table
$result = $con->query("SELECT * FROM materials_assign");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>View Assignments</title>
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" type="text/css" media="screen" href="css/screen.css">
    <link rel="stylesheet" href="css/home.css" />
</head>
<body>
    <div id="page">
        <header>
            <a title="asset" href="materials.php">
                <div class="logo">
                    <img src="images/logo.png" height="66px" weight="66px" />
            </a>
            <span id="title">Asset Management System</span>
        </div>
        <nav>
            <label for="email">Welcome <?php echo $user_data['first_name']; ?> </label>
            <a href="home.php"><input type="image" src="images/icons/home.png" title="Home" value="home " style="margin-left:10px;"/></a>
            <a href="profile.php"><input type="image" src="images/icons/user.png" title="Profile" value="settings " style="margin-left:10px;"/></a>
            <a href="logout.php"><input type="image" src="images/icons/logout.png" title="Logout" value="Sign Out" style="margin-left:10px;"/></a>
        </nav>
    </header>

    <div class="content-center">
        <div id="topic">Materials Assign</div>
        <a href="view_assign_export.php"><div id="add-new">Export</div></a>
        <table border="1">
            <tr>
                <th>Material ID</th>
                <th>Item Names</th>
                <th>Lab Name</th>
                <th>Assign Number</th>
                <th>Faculty Name</th>
                <th>Faculty Assign Number</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                // Display data in a table
                while($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . $row["material_id"] . '</td>';
                    echo '<td>' . $row["item_names"] . '</td>';
                    echo '<td>' . $row["lab_name"] . '</td>';
                    echo '<td>' . $row["assign_number"] . '</td>';
                    echo '<td>' . $row["faculty_name"] . '</td>';
                    echo '<td>' . $row["faculty_assign_number"] . '</td>';
                    echo '</tr>';
                }
            } else {
                // If no rows are returned, display a message
                echo '<tr><td colspan="6">No data found.</td></tr>';
            }
            ?>
        </table>
    </div>
</div>
</body>
</html>
