<?php
require 'core/init.php';

if(logged_in() === false){
    session_destroy();
    header('Location:index.php');
    exit();
} 
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
            <a title="asset" href="home.php">
                <div class="logo">
                    <img src="images/logo.png" height="66px" weight="66px" />
                </div>
            </a>
            <span id="title">Asset Management System</span>
            <nav>
                <label for="email">Welcome <?php echo $user_data['first_name']; ?> </label>
                <a href="home.php"><input type="image" src="images/icons/home.png" title="Home" value="home " style="margin-left:10px;"/></a>
                <a href="profile.php"><input type="image" src="images/icons/user.png" title="Profile" value="settings " style="margin-left:10px;"/></a>
                <a href="logout.php"><input type="image" src="images/icons/logout.png" title="Logout" value="Sign Out" style="margin-left:10px;"/></a>
            </nav>
        </header>

        <div class="content-center">
            <div id="topic">Assigned Assets</div>
            <a href="assign_export.php"><div id="add-new">Export</div></a>
            <table border=1>
                <tr>
                    <th>ID</th>
                    <th>sw1</th>
                    <th>faculty1</th>
                    <th>sw2</th>
                    <th>faculty2</th>
                    <th>sw3</th>
                    <th>faculty3</th>
                    <th>sw4</th>
                    <th>faculty4</th>
                    <th>sw5</th>
                    <th>faculty5</th>
                    <th>sw6</th>
                    <th>faculty6</th>
                </tr>
                <?php
                // Fetch data from the assets table
                $result = $con->query("SELECT * FROM assets");

                // Check if there are any rows returned
                if ($result->num_rows > 0) {
                    // Loop through each row and display data in the table
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["id"] . "</td>";
                        echo "<td>" . $row["sw1"] . "</td>";
                        echo "<td>" . $row["faculty1"] . "</td>";
                        echo "<td>" . $row["sw2"] . "</td>";
                        echo "<td>" . $row["faculty2"] . "</td>";
                        echo "<td>" . $row["sw3"] . "</td>";
                        echo "<td>" . $row["faculty3"] . "</td>";
                        echo "<td>" . $row["sw4"] . "</td>";
                        echo "<td>" . $row["faculty4"] . "</td>";
                        echo "<td>" . $row["sw5"] . "</td>";
                        echo "<td>" . $row["faculty5"] . "</td>";
                        echo "<td>" . $row["sw6"] . "</td>";
                        echo "<td>" . $row["faculty6"] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='13'>No data found</td></tr>";
                }
                ?>
            </table>
        </div>
    </div>
</body>
</html>
