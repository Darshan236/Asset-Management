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
    <?php $id=$_GET['id'];
    $asset_data=asset_data($con,$id);?>

    <div class="content-center">
        <div id="topic"><h3>Purchase Update</div>
        <!-- <?php echo $asset_data['title'];?></h3> -->


            <table border=0>
                <form action="" method="post">
                <tr>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Supplier Name</th>
                </tr>
                <tr>
                    <td><input style="text-align: center" type="text" value="<?php echo $asset_data['title'];?>" name="title"></td>
                    <td><input style="text-align: center" type="text" value="<?php echo $asset_data['category'];?>" name="category"></td>
                    <td><input style="text-align: center" type="number" value="<?php echo $asset_data['quantity'];?>" name="quantity"></td>
                    <td><input style="text-align: center" type="number" value="<?php echo $asset_data['price'];?>" name="price"></td>
                    <td><input style="text-align: center" type="text" value="<?php echo $asset_data['supplier_name'];?>" name="supplier_name"></br></td>
                </tr>
                <tr>
                    
                    <th>Acadamic Year</th>
                    <th>Assign</th>
                </tr>
                <tr>
                   
                    <td><input style="text-align: center" type="text" value="<?php echo $asset_data['acadamic_year'];?>" name="acadamic_year"></td>
                    <td><input style="text-align: center" type="text" value="<?php echo $asset_data['assign'];?>" name="assign"></td>
                    <td><input type="submit" name="update" value="update"></td>
                </th>
                </form>
            </table>

        <?php
            if(isset($_POST['update'])===true and empty($_POST['update'])=== false){
                $update_data = array(

                    'title'     => $_POST['title'],
                    'category'  => $_POST['category'],
                    'quantity'  => $_POST['quantity'],
                    'price'  => $_POST['price'],
                    'supplier_name'   => $_POST['supplier_name'],
                    'acadamic_year'  => $_POST['acadamic_year']
                );


                update_assets($con,$update_data,$id);
                header('Location:home.php');
                exit();

            }



        ?>

    </div>

</div>
</body>
</html>