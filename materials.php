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
    <title>Asset Management System</title>
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
        <div id="topic">Materials Assets</div>
        <a href="add.php"><div id="add-new">Purchase</div></a><a href="recouring.php"><div id="add-new">Recouring</div></a><a href="export1.php"><div id="add-new">Export</div></a>
        <table border="0">
            <tr>
                <th>Bill-No</th>
                <th>Supplier Name</th>
                <th>Date</th>
                <th>Items</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total price</th>
                <th>Assign</th>
            </tr>
            <?php
            $id = $user_data['id'];
            $result = getMaterials($con, $user_data["id"]);
            $i = 1;
            while($row = $result->fetch_assoc()) {
                echo "<tr style='background-color:";
                if ($i % 2 == 0) {
                    echo "#f2f2f2";
                } else {
                    echo "white";
                }
                $i++;
                echo "'>";
                echo "<td style='text-align: center'>" . $row["bill_no"] . "</td>";
                echo "<td style='text-align: center'>" . $row["supplier_name"] . '</td>';
                echo '<td style="text-align: center">' . $row['transaction_date'] . '</td>';
                echo '<td style="text-align: center">' . $row['item_names'] . '</td>'; // Corrected array key
                echo '<td style="text-align: center">' . $row['quantity'] . '</td>'; // Assuming quantity is the correct column name
                echo '<td style="text-align: center">' . $row['rates'] . '</td>'; // Assuming rate is the correct column name
                // Assuming you want the total price to be quantity * rate
                echo '<td style="text-align: center">' . 'Rs ' . $row['quantity'] * $row['rates'] . '</td>'; 
                // Assuming you want to display the assign column value here, update as necessary
                echo '<td style="text-align: center">' . $row['Assign'] . '</td>';
                echo "<td style='text-align: center'>
                        <a href=\"delete1.php?delete_id=".$row['id']."\"><img src='images/icons/delete.ico' height='24'/></a>
                        <a href=\"update1.php?id=".$row['id']."\"><img src='images/icons/edit.png' alt='' height='24'/></a>
                        <a href=\"assign1.php?item_name=".$row['item_names']."\"><img src='images/icons/assign.png' alt='' height='24'/></a>
                    </td>";
                
                echo '</tr>';
            }
            ?>
        </table>
    </div>
</div>
</body>
</html>
