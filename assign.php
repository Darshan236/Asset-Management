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
    <?php 
    $id = $_GET['id'];
    $asset_data = asset_data($con, $id);
    ?>

    <div class="content-center">
        <div id="topic"><h3><?php echo $asset_data['title'];?></h3></div>


            <table border=0>
                <form action="" method="post">
                <tr>
                    <th>Assign</th>
                </tr>
                <tr>
                    <td><input style="text-align: center" type="text" value="<?php echo $asset_data['assign'];?>" name="assign"></td>
                </tr>
                <tr>
                    <th>SW1</th>
                    <th>SW2</th>
                    <th>SW3</th>
                    <th>SW4</th>
                    <th>SW5</th>
                    <th>SW6</th>
                </tr>
                <tr>
                    <td><input style="text-align: center" type="text" value="<?php echo $asset_data['sw1'];?>" name="sw1"></td>
                    <td><input style="text-align: center" type="number" value="<?php echo $asset_data['sw2'];?>" name="sw2"></td>
                    <td><input style="text-align: center" type="number" value="<?php echo $asset_data['sw3'];?>" name="sw3"></td>
                    <td><input style="text-align: center" type="text" value="<?php echo $asset_data['sw4'];?>" name="sw4"></td>
                    <td><input style="text-align: center" type="number" value="<?php echo $asset_data['sw5'];?>" name="sw5"></td>
                    <td><input style="text-align: center" type="number" value="<?php echo $asset_data['sw6'];?>" name="sw6"></td>
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
                    <td><input style="text-align: center" type="text" value="<?php echo $asset_data['faculty1'];?>" name="faculty1"></td>
                    <td><input style="text-align: center" type="text" value="<?php echo $asset_data['faculty2'];?>" name="faculty2"></td>
                    <td><input style="text-align: center" type="text" value="<?php echo $asset_data['faculty3'];?>" name="faculty3"></td>
                    <td><input style="text-align: center" type="text" value="<?php echo $asset_data['faculty4'];?>" name="faculty4"></td>
                    <td><input style="text-align: center" type="text" value="<?php echo $asset_data['faculty5'];?>" name="faculty5"></td>
                    <td><input style="text-align: center" type="text" value="<?php echo $asset_data['faculty6'];?>" name="faculty6"></td>
                </tr>
                <tr>
                    <td><input type="submit" name="update" value="Assign"></td>
                </tr>
                </form>
            </table>

        <?php
            if(isset($_POST['update']) && !empty($_POST['update'])){
                $update_data = array(
                    'assign'   => $_POST['assign'],
                    'sw1'      => $_POST['sw1'],
                    'sw2'      => $_POST['sw2'],
                    'sw3'      => $_POST['sw3'],
                    'sw4'      => $_POST['sw4'],
                    'sw5'      => $_POST['sw5'],
                    'sw6'      => $_POST['sw6'],
                    'faculty1' => $_POST['faculty1'],
                    'faculty2' => $_POST['faculty2'],
                    'faculty3' => $_POST['faculty3'],
                    'faculty4' => $_POST['faculty4'],
                    'faculty5' => $_POST['faculty5'],
                    'faculty6' => $_POST['faculty6']
                );

                update_assets($con, $update_data, $id);
                header('Location:home.php');
                exit();
            }
        ?>

    </div>

</div>
</body>
</html>
