<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "mysql";
$database = "user";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Loop through your invoices and generate links for each invoice
for ($i = 1; $i <= 10; $i++) { // Assuming you have 10 invoices
    echo "<a href='invoice.php?invoice_id=$i'>Invoice $i</a><br>";
}

// Function to sanitize input to prevent SQL injection
function sanitize_input($input) {
    // Implement your sanitization logic here
    return $input;
}

// Check if invoice ID is provided in the URL
if(isset($_GET['invoice_id'])) {
    // Assuming you're passing invoice ID through GET request
    $invoice_id = sanitize_input($_GET['invoice_id']);

    // Query to fetch invoice data from your table
    $sql = "SELECT * FROM your_table WHERE id = ?";

    // Prepare and bind parameters
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $invoice_id);

    // Execute the query
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // Check if there are rows returned
    if ($result->num_rows > 0) {
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            // Output the invoice details
            echo "<h2>Invoice</h2>";
            echo "<p>ID: " . $row['id'] . "</p>";
            echo "<p>Title: " . $row['title'] . "</p>";
            echo "<p>Category: " . $row['category'] . "</p>";
            // Add more fields as needed
        }
    } else {
        echo "No invoice found with the given ID.";
    }

    // Close statement and connection
    $stmt->close();
} else {
    echo "No invoice ID provided.";
}

$conn->close();
?>
