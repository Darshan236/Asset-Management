<?php 
require 'core/init.php';

if(logged_in() === false){
    session_destroy();
    header('Location:index.php');
    exit();
} 

$errors = array();

if(isset($_POST['add_asset'])) {

    $required_fields = array('bill_no', 'supplier_name', 'transaction_date', 'total_amount', 'item_name', 'rate', 'quantity');
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            $errors[] = 'All fields are required';
            break;
        }
    }

    if(empty($errors)) {
        $bill_no = $_POST['bill_no'];
        $supplier_name = $_POST['supplier_name'];
        $transaction_date = $_POST['transaction_date'];
        $total_amount = $_POST['total_amount'];
        $item_names = $_POST['item_name'];
        $rates = $_POST['rate'];
        $quantities = $_POST['quantity'];

        // Insert data into database
        if(addAsset($con, $bill_no, $supplier_name, $transaction_date, $total_amount, $item_names, $rates, $quantities, $user_data)) {
            // Redirect after successful addition
            header('Location:recouring.php?success');
            exit();
        } else {
            $errors[] = 'Error while adding asset. Please try again.';
        }
    }
}

// Additional validation for required fields if form is submitted but errors occurred
if(empty($_POST['add_asset']) === false && !empty($errors)) {
    $required_fields = array('bill_no', 'supplier_name', 'transaction_date', 'total_amount');
    foreach ($_POST as $key => $value) {
        if (empty($value) && in_array($key, $required_fields)) {
            $errors[] = 'Fields marked with asterisk are required';
            break;
        }
    }
}

// Function to insert data into database
function addAsset($con, $bill_no, $supplier_name, $transaction_date, $total_amount, $item_names, $rates, $quantities, $user_data) {
    // Prepare and execute query to insert data
    $query = "INSERT INTO materials (userid, bill_no, supplier_name, transaction_date, item_names, rates, quantity,sw1,sw2,sw3,sw4,sw5,sw6) VALUES (?, ?, ?, ?, ?, ?, ?,0,0,0,0,0,0)";
    $stmt = $con->prepare($query);

    // Get user ID
    $userid = $user_data['id'];

    // Bind parameters
    $stmt->bind_param("issssss", $userid, $bill_no, $supplier_name, $transaction_date, $item_name, $rate, $quantity);

    // Iterate through items and insert each into the database
    foreach ($item_names as $key => $item_name) {
        $rate = $rates[$key];
        $quantity = $quantities[$key];
        if (!$stmt->execute()) {
            return false; // Return false if any execution fails
        }
    }

    // Close statement and return true indicating successful insertion
    $stmt->close();
    return true;
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
if (isset($_GET['success']) && empty($_GET['success'])) {
    echo '<center> inserted successfully!!!! </center><br>';
    echo '<center><a href="materials.php">View Results</a>'."    ". '<a href="recouring.php">Add item</a></center>';
} else {
    if (empty($_POST) === false and empty($errors)===true) {
        $asset_data = array(
            'userid'    => $user_data['id'],
            'bill_no'     => $_POST['bill_no'],
            'supplier_name'  => $_POST['supplier_name'],
            'transaction_date'  => $_POST['transaction_date'],
            'item_name[]'  => $_POST['item_name[]'],
            'rate[]'     => $_POST['rate[]'],
            'quantity[]'     => $_POST['quantity[]'],
            'total_amount'     => $_POST['total_amount'],  
        );
        addAsset($con, $asset_data);
        header('Location:recouring.php?success');
        exit();

    } else if(empty($errors)===false){
        echo '<center>'.output_errors($errors).'</center>';
    }
?>

<div id='add-item-form'>
    <form name="add-asset" method='POST' action='recouring.php'>
        <table border=0>
            <tr>
                <td id='label-col'>
                    <label>Bill No.*</label>
                </td>
                <td id='input-col'>
                    <input type='text' name='bill_no' required>
                </td>
            </tr>
            <tr>
                <td id='label-col'>
                    <label>Supplier Name*</label>
                </td>
                <td id='input-col'>
                    <input type='text' name='supplier_name' required>
                </td>
            </tr>
            <tr>
                <td id='label-col'>
                    <label>Date*</label>
                </td>
                <td id='input-col'>
                    <input type='date' name='transaction_date' required>
                </td>
            </tr>
            <!-- Here starts the section for adding multiple items -->
            <tr>
                <td colspan="2">
                    <h3>Add Items</h3>
                </td>
                </tr>
            <tr>
                <td colspan="2" id="itemRows">
                    <input type='text' name='item_name[]' placeholder="Item Name*" required>
                    <input type='text' name='rate[]' placeholder="Rate*" required>
                    <input type='text' name='quantity[]' placeholder="Quantity*" required>
                </td>
                <br></br>
            </tr>
            <!-- End of section for adding multiple items -->
            <tr>
                <td id='label-col'>
                    <label>Total Amount*</label>
                </td>
                <td id='input-col'>
                    <input type='text' id='total_amount' name='total_amount' readonly>
                    <button type="button" onclick="calculateTotal()">Calculate Total</button>
                </td>
            </tr>
        </table>
        <button type="button" onclick="addItem()">Add Another Item</button>
        <input type='submit' value='Add' name='add_asset'>
    </form>
</div>

<script>
    // Function to add a new set of text fields for an item
    function addItem() {
        const newItemRow = `
            <div>
                <input type='text' name='item_name[]' placeholder="Item Name*" required>
                <input type='text' name='rate[]' placeholder="Rate*" required>
                <input type='text' name='quantity[]' placeholder="Quantity*" required>
                <button type="button" onclick="removeItem(this)">Remove</button>
            </div>
        `;
        document.getElementById('itemRows').insertAdjacentHTML('beforeend', newItemRow);
    }

    // Function to remove a set of text fields for an item
    function removeItem(element) {
        element.parentNode.remove();
    }

    // Function to calculate the total amount
    function calculateTotal() {
        const rates = document.getElementsByName('rate[]');
        const quantities = document.getElementsByName('quantity[]');
        let total = 0;
        for (let i = 0; i < rates.length; i++) {
            const rate = parseFloat(rates[i].value);
            const quantity = parseFloat(quantities[i].value);
            if (!isNaN(rate) && !isNaN(quantity)) {
                total += rate * quantity;
            }
        }
        document.getElementById('total_amount').value = total.toFixed(2);
    }
</script>

<?php } ?>
</body>
</html>
