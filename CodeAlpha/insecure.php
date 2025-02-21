<?php
// Database connection parameters
$servername = "localhost"; // Change this to your MySQL server hostname
$username = "sahithya"; // Change this to your MySQL username
$password = "iiits123"; // Change this to your MySQL password
$database = "test"; // Change this to your MySQL database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get input data (without any sanitization)
    $name = $_POST["name"];
    $password = $_POST["password"];

    // SQL query to check if username and password match any existing records
    $sql = "SELECT * FROM users WHERE name = '$name' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Display login successful along with username and password
        echo "Login successful!<br>";
        while ($row = $result->fetch_assoc()) {
            echo "Username: " . $row["name"] . " - Password: " . $row["password"] . "<br>";
        }
    } else {
        $sql = "INSERT INTO users (name, password) VALUES ('$name', '$password')";

        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Close connection
$conn->close();
