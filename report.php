<?php
require 'core/init.php';
error_reporting(0);

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
    <!-- Load Google Charts -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Category', 'Quantity'],
                <?php
                $id = $user_data['id'];
                $cat = array('Desktop', 'CPU', 'Mouse', 'Keyboard');
                foreach ($cat as $category) {
                    $count = getCount($con, $category, $id);
                    echo "['$category', $count],";
                }
                ?>
            ]);

            var options = {
                title: 'Category X Quantity'
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart'));

            chart.draw(data, options);
        }
    </script>
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
            <div id="topic">General Report</div>
            <div>
                <form action="" method="POST"></form>
                <table border=0>
                    <tr>
                        <th>Category</th>
                        <th>Quantity</th>
                        <th>Total price</th>
                    </tr>
                    <?php
                    $id = $user_data['id'];
                    $cat = array('Desktop', 'CPU', 'Mouse', 'Keyboard');
                    $tcount = 0;
                    $tprice = 0;
                    foreach($cat as $category) {
                        $count = getCount($con, $category, $id);
                        $tcount += $count;
                        $price = getPrice($con, $category, $id);
                        $tprice += $price;
                        echo "<tr>";
                        echo "<td style='text-align: center'>$category</td>";
                        echo "<td style='text-align: center'>$count</td>";
                        echo "<td style='text-align: center'>Rs $price</td>";
                        echo "</tr>";
                    }
                    ?>
                </table>
                <div class="summary" style="margin: 10% auto; text-align: center">
                    <h2>TOTAL ASSETS = <?php echo $tcount; ?></h2>
                    <h2>TOTAL ASSETS WORTH = Rs. <?php echo $tprice; ?> /=</h2>
                </div>
            </div>
            <!-- Container for the pie chart -->
            <div id="piechart" style="width: 900px; height: 500px;"></div>
        </div>
    </div>
</body>
</html>
