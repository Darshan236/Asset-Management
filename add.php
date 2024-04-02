<?php require 'core/init.php';

function addAsset($con, $asset_data) {
    $fields='`' .implode('`,`' ,array_keys($asset_data)) . '`';
    $data = '\'' . implode('\', \'' ,$asset_data ) . '\' ';

    mysqli_query($con,"INSERT INTO assets($fields) VALUES ($data)");
}

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
    <link rel='stylesheet' href='css/input_form.css'>
    <script src="js/activation.js"></script>
    <script>
        function validateForm() {
            var quantity = document.forms["add-asset"]["quantity"].value;
            if (!isnum(quantity)) {
                alert("Invalid quantity");
                return false;
            }

            var price = document.forms["add-asset"]["price"].value;
            if (!isnum(price)) {
                alert("Invalid price");
                return false;
            }
        }

        // Returns true if @val contains only numbers. false otherwise.
        function isnum(val) {
            return /^[0-9]+$/.test(val.replace('.',''));    // competible with floating point values
        }
    </script>
</head>
<body>
<div id="page">
        <header>
            <a title="asset" href="">
                <div class="logo">
                    <img src="images/logo.png" height="66px" weight="66px" />
                    <span id="title">Asset Management System</span>
                </div>
            </a>

            <nav>


                <label for="email"><?php echo $user_data['first_name']; ?> </label>
                <a href="home.php"><input type="image" src="images/icons/home.png" title="Home" value="home " style="margin-left:10px;"/></a>
                <a href="profile.php"><input type="image" src="images/icons/user.png" name="setting" value="settings " style="margin-left:10px;font-weight:bold;"/></a>
                <a href="logout.php"><input type="image" src="images/icons/logout.png" name="logout" value="Sign Out" style="margin-left:10px;font-weight:bold;"/></a>

            </nav>
        </header>
    <br><br>

<?php


            if(empty($_POST['add_asset'])===false) {

                $reuired_fields = array('title', 'category', 'quantity', 'price');
                foreach ($_POST as $key => $value) {
                    if (empty($value) && in_array($key, $reuired_fields) === true) {
                        $errors[]='Fields marked with asterisk are required';
                        break 1;
                    }
                }
            }
?>

        <h2><center>Enter Your Data</center></h2>
<?php
            if (isset($_GET['success']) && empty($_GET['success'])) {
                echo '<center> inserted successfully!!!! </center><br>';
                echo '<center><a href="home.php">View Results</a>'."    ". '<a href="add.php">Add item</a></center>';
            }else {

            if (empty($_POST) === false and empty($errors)===true) {
                //$dt=date();
                $asset_data = array(
                    'userid'    => $user_data['id'],
                    'title'     => $_POST['title'],
                    'category'  => $_POST['category'],
                    'quantity'  => $_POST['quantity'],
                    'address'  => $_POST['address'],
                    'price'     => $_POST['price'],
                    'acadamic_year'     => $_POST['acadamic_year'],
                    'po_no'     => $_POST['po_no'],
                    'po_date'     => $_POST['po_date'],
                    'date'     => $_POST['date'],
                    'supplier_name'   => $_POST['supplier_name'],
                  
                );
                addAsset($con, $asset_data);
                header('Location:add.php?success');
                exit();

            }else if(empty($errors)===false){

                echo '<center>'.output_errors($errors).'</center>';

            }



?>


    <div id='add-item-form'>
            <form name="add-asset" method='POST' action='add.php' onsubmit="return validateForm()">
                <table border=0>
                    <tr>
                        <td id='label-col'>
                            <label>Title*</label> </td>
                        <td id='input-col'>
                            <input type='text' name='title' required maxlength=30 oninput="activate('add-asset', this, 'quantity')"> </td>
                    </tr>
                    <tr>
                        <td id='label-col'>
                            <label>Category*</label></td>
                        <td id='input-col'>
                            <select name='category'>
                                <option value='Desktop'>Desktop</option>
                                <option value='CPU'>CPU</option>
                                <option value='Mouse'>Mouse</option>
                                <option value='Other'>Other</option>
                            </select>
                    </tr>
                    <tr>
                        <td id='label-col'>
                            <label>Quantity*</label></td>
                        <td id='input-col'>
                            <input type='text' name='quantity' required disabled oninput="activate('add-asset', this, 'address')"></td>
                    </tr>

                    <tr>
                        <td id='label-col'>
                            <label>Address*</label></td>
                        <td id='input-col'>
                            <input type='text' name='address' required disabled oninput="activate('add-asset', this, 'price')"></td>
                    </tr>
                    <tr>
                        <td id='label-col'>
                            <label>Price*</label> </td>
                        <td id='input-col'>
                            <input type='text' name='price' required disabled oninput="activate('add-asset', this, 'acadamic_year')"> </td>
                    </tr>
                    <tr>
                        <td id='label-col'>
                            <label>Academic Year*</label> </td>
                        <td id='input-col'>
                            <input type='text' name='acadamic_year' required disabled oninput="activate('add-asset', this, 'po_no')"> </td>
                    </tr>
                    <tr>
                        <td id='label-col'>
                            <label>Po No.*</label> </td>
                        <td id='input-col'>
                            <input type='text' name='po_no' required disabled oninput="activate('add-asset', this, 'po_date')"> </td>
                    </tr> 
                    <tr>
                        <td id='label-col'>
                            <label>PO Date*</label> </td>
                        <td id='input-col'>
                            <input type='date' name='po_date' required disabled oninput="activate('add-asset', this, 'date')"> </td>
                    </tr>
                    <tr>
                        <td id='label-col'>
                            <label>Date*</label> </td>
                        <td id='input-col'>
                            <input type='date' name='date' required disabled oninput="activate('add-asset', this, 'supplier_name')"> </td>
                    </tr>
                    <tr>
                        <td id='label-col'>
                            <label>Supplier Details</label> </td>
                        <td id='input-col'>
                            <textarea name='supplier_name' rows='5' required disabled oninput="activate('add-asset', this, 'assign')"></textarea> </td>
                    </tr>
                  
                    <tr>
                        <td id='label-col'>
                            <label>Assign</label> </td>
                        <td id='input-col'>
                            <input type='text' name='assign' disabled> </td>
                    </tr>                   
                </table> 
                <input type='submit' value='Add' name='add_asset'>
            </form>
        </div>


    </div>


<?php } ?>
</body>
</html>
