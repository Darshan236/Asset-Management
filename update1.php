<?php 
require 'core/init.php';

if(logged_in() === false){
    session_destroy();
    header('Location:index.php');
    exit();
} 

if(isset($_GET['id'])) {
    $material_id = $_GET['id'];
    $material_data = getMaterialById($con, $material_id);
    
    // Check if material exists
    if(!$material_data) {
        echo "Material not found.";
        exit();
    }
    
    // If form is submitted
    if(isset($_POST['update'])) {
        $bill_no = $_POST['bill_no'];
        $supplier_name = $_POST['supplier_name'];
        $transaction_date = !empty($_POST['transaction_date']) ? $_POST['transaction_date'] : date('Y-m-d'); // Use current date if transaction_date is empty
        $item_names = $_POST['item_names'];
        $rates = $_POST['rates'];
        $quantity = $_POST['quantity'];

        // Update material in the database
        if(updateMaterial($con, $material_id, $bill_no, $supplier_name, $transaction_date, $item_names, $rates, $quantity)) {
            header('Location: materials.php');
            exit();
        } else {
            echo "Error updating material.";
        }
    }
} else {
    echo "Material ID not provided.";
    exit();
}

function getMaterialById($con, $material_id) {
    $query = "SELECT * FROM materials WHERE id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $material_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

function updateMaterial($con, $material_id, $bill_no, $supplier_name, $transaction_date, $item_names, $rates, $quantity) {
    $query = "UPDATE materials SET bill_no = ?, supplier_name = ?, transaction_date = ?, item_names = ?, rates = ?, quantity = ? WHERE id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("ssssssi", $bill_no, $supplier_name, $transaction_date, $item_names, $rates, $quantity, $material_id);
    return $stmt->execute();
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

        <div class="content-center">
            <div id="topic"><h3>Update Material</h3></div>
            <table border=0>
    <form action="" method="post">
        <tr>
            <th>Bill No</th>
            <th>Supplier Name</th>
            <th>Date</th>
            <th>Items Name</th>
            <th>Rates</th>
        </tr>
        <tr>
            <td><input type="text" name="bill_no" value="<?php echo isset($material_data['bill_no']) ? $material_data['bill_no'] : ''; ?>" style="width: 200px;"></td>
            <td><input type="text" name="supplier_name" value="<?php echo isset($material_data['supplier_name']) ? $material_data['supplier_name'] : ''; ?>" style="width: 200px;"></td>
            <td><input type="date" name="transaction_date" value="<?php echo isset($material_data['transaction_date']) ? $material_data['transaction_date'] : ''; ?>" style="width: 200px;"></td>
            <td><input type="text" name="item_names" value="<?php echo isset($material_data['item_names']) ? $material_data['item_names'] : ''; ?>" style="width: 200px;"></td>
            <td><input type="text" name="rates" value="<?php echo isset($material_data['rates']) ? $material_data['rates'] : ''; ?>" style="width: 200px;"></td>
        </tr>
        <tr> 
            <th>Quantities</th>
            
        </tr>
        <tr>
           
            <td><input type="text" name="quantity" value="<?php echo isset($material_data['quantity']) ? $material_data['quantity'] : ''; ?>" style="width: 200px;"></td>
            
            <td><input type="submit" name="update" value="update"></td>
        </tr>
    </form>
</table>


        </div>
    </div>
</body>
</html>
