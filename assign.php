<?php
require 'core/init.php';
error_reporting(0);
if(logged_in() === false){
    session_destroy();
    header('Location:index.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $titles = $_POST['title']; // Corrected variable name to be an array
    $lab_names = $_POST['lab_name'];
    $assign_numbers = $_POST['assign_number'];
    $faculty_names = $_POST['faculty_name'];
    $faculty_assign_numbers = $_POST['faculty_assign_number'];

    // Loop through each set of fields and insert into the database
    foreach ($titles as $key => $title) {
        $lab_name = $lab_names[$key];
        $assign_number = $assign_numbers[$key];
        $faculty_name = $faculty_names[$key];
        $faculty_assign_number = $faculty_assign_numbers[$key];

        // Prepare and execute the SQL statement to insert data into the database
        $stmt = $con->prepare("INSERT INTO assign (tittle, lab_name, assign_number, faculty_name, faculty_assign_number) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $title, $lab_name, $assign_number, $faculty_name, $faculty_assign_number);

        // Check if the statement executed successfully
        if ($stmt->execute()) {
            // Data inserted successfully
            echo "Data inserted successfully.";
        } else {
            // Error occurred
            echo "Error: " . $con->error;
        }

        // Close the statement
        $stmt->close();
    }
}
?>
<!DOCTYPE html>

<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Asset Management System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        #page {
            width: 80%;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        #topic {
            text-align: center;
            margin-bottom: 20px;
        }

        .faculty-row {
            display: flex;
            flex-wrap: wrap;
            margin-bottom: 10px;
        }

        .faculty-input {
            flex: 1;
            margin-right: 10px;
        }

        .faculty-input label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        .faculty-input input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        button {
            background-color: #4caf50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
        header {
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo img {
            height: 66px;
            width: 66px;
        }

        .logo span {
            font-size: 24px;
            font-weight: bold;
            margin-left: 10px;
            color: white;
        }

        nav {
            display: flex;
            align-items: center;
        }

        nav a {
            margin-left: 10px;
            text-decoration: none;
            color: #fff;
        }

        nav a:hover {
            text-decoration: underline;
        }

        nav label {
            margin-right: 10px;
        }
    </style>
</head>
<body>

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
<div id="page">
    
    <?php $id=$_GET['id'];
    $asset_data=asset_data($con,$id);?>

    <div class="content-center">
        <div id="topic"><h3><?php echo $asset_data['title'];?></h3></div>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" id="assignment-form">
            <!-- Faculty Name and Faculty Assign Number Section -->
            <div id="faculty-section">
                <div id="faculty-fields">
                    <!-- Initial set of fields -->
                    <div class="faculty-row">
                        <div class="faculty-input">
                            <label>Title:</label>
                            <input type="text" name="title[]" value="<?php echo $asset_data['title'];?>" placeholder="Title" required> <!-- Use [] to create an array of inputs -->
                        </div>
                        <div class="faculty-input">
                            <label>Lab Name:</label>
                            <input type="text" name="lab_name[]" placeholder="Lab Name" required>
                        </div>
                        <div class="faculty-input">
                            <label>Assign Number:</label>
                            <input type="text" name="assign_number[]" placeholder="Assign Number" required>
                        </div>
                        <div class="faculty-input">
                            <label>Faculty Name:</label>
                            <input type="text" name="faculty_name[]" placeholder="Faculty Name" required>
                        </div>
                        <div class="faculty-input">
                            <label>Faculty Assign Number:</label>
                            <input type="text" name="faculty_assign_number[]" placeholder="Faculty Assign Number" required>
                        </div>
                        <button type="button" onclick="removeFacultyRow(this)">Remove</button>
                    </div>
                </div>
                <button type="button" onclick="addFacultyRow()">Add Another Faculty</button>
            </div>
            <!-- End of Faculty Name and Faculty Assign Number Section -->
            <input type="submit" value="Submit">
        </form>
    </div>
</div>

<script>
    // Function to add a new set of faculty fields
    function addFacultyRow() {
        const facultySection = document.getElementById('faculty-fields');
        const newFacultyRow = document.createElement('div');
        newFacultyRow.classList.add('faculty-row');

        newFacultyRow.innerHTML = `
            <div class="faculty-input">
                <label>Title:</label>
                <input type="text" name="title[]" value="<?php echo $asset_data['title'];?>" placeholder="Title" required>
            </div>
            <div class="faculty-input">
                <label>Lab Name:</label>
                <input type="text" name="lab_name[]" placeholder="Lab Name" required>
            </div>
            <div class="faculty-input">
                <label>Assign Number:</label>
                <input type="text" name="assign_number[]" placeholder="Assign Number" required>
            </div>
            <div class="faculty-input">
                <label>Faculty Name:</label>
                <input type="text" name="faculty_name[]" placeholder="Faculty Name" required>
            </div>
            <div class="faculty-input">
                <label>Faculty Assign Number:</label>
                <input type="text" name="faculty_assign_number[]" placeholder="Faculty Assign Number" required>
            </div>
            <button type="button" onclick="removeFacultyRow(this)">Remove</button>
        `;
        facultySection.appendChild(newFacultyRow);
    }

    // Function to remove a set of faculty fields
    function removeFacultyRow(element) {
        element.parentNode.remove();
    }
</script>

</body>
</html>
