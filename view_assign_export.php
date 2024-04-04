<?php
require 'core/init.php';

// Check if the user is logged in
if(logged_in() === false){
    session_destroy();
    header('Location:index.php');
    exit();
} 

// Fetch data from the database
$result = $con->query("SELECT * FROM materials");

// Initialize the Excel data variable
$data = "
<table border='1'>
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
    </tr>";

// Check if there are any rows returned
if ($result->num_rows > 0) {
    // Loop through each row and append data to the Excel variable
    while ($row = $result->fetch_assoc()) {
        $data .= "<tr>";
        $data .= "<td>" . $row["id"] . "</td>";
        $data .= "<td>" . $row["sw1"] . "</td>";
        $data .= "<td>" . $row["faculty1"] . "</td>";
        $data .= "<td>" . $row["sw2"] . "</td>";
        $data .= "<td>" . $row["faculty2"] . "</td>";
        $data .= "<td>" . $row["sw3"] . "</td>";
        $data .= "<td>" . $row["faculty3"] . "</td>";
        $data .= "<td>" . $row["sw4"] . "</td>";
        $data .= "<td>" . $row["faculty4"] . "</td>";
        $data .= "<td>" . $row["sw5"] . "</td>";
        $data .= "<td>" . $row["faculty5"] . "</td>";
        $data .= "<td>" . $row["sw6"] . "</td>";
        $data .= "<td>" . $row["faculty6"] . "</td>";
        $data .= "</tr>";
    }
} else {
    // If no rows are returned, display a message
    $data .= "<tr><td colspan='13'>No data found</td></tr>";
}

// Close the table tag
$data .= "</table>";

// Define the file name
$name = "Assigned_Assets_" . date("d-m-Y");

// Set the headers for file download
header("Content-Type: application/xls");
header("Content-Disposition: attachment; filename=$name.xls");

// Output the Excel data
echo $data;
?>
