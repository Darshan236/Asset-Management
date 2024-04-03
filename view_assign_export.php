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

// Initialize the Excel data variable
$data = "
<table border='1'>
    <tr>
        <th>Material ID</th>
        <th>Item Names</th>
        <th>Lab Name</th>
        <th>Assign Number</th>
        <th>Faculty Name</th>
        <th>Faculty Assign Number</th>
    </tr>";

// Check if there are rows in the result
if ($result->num_rows > 0) {
    // Append data to the Excel variable
    while($row = $result->fetch_assoc()) {
        $data .= "<tr>";
        $data .= "<td>" . $row["material_id"] . "</td>";
        $data .= "<td>" . $row["item_names"] . "</td>";
        $data .= "<td>" . $row["lab_name"] . "</td>";
        $data .= "<td>" . $row["assign_number"] . "</td>";
        $data .= "<td>" . $row["faculty_name"] . "</td>";
        $data .= "<td>" . $row["faculty_assign_number"] . "</td>";
        $data .= "</tr>";
    }
} else {
    // If no rows are returned, display a message
    $data .= "<tr><td colspan='6'>No data found.</td></tr>";
}

// Close the table tag
$data .= "</table>";

// Define the file name
$name = "Materials_Assignments_" . date("d-m-Y");

// Set the headers for file download
header("Content-Type: application/xls");
header("Content-Disposition: attachment; filename=$name.xls");

// Output the Excel data
echo $data;
?>
