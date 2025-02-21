<?php
$servername = "localhost";
$username = "sahithya";
$password = "iiits123";
$database = "test";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $password = $_POST['password'];

    // Validate name field to accept text only
    if (!preg_match("/^[a-zA-Z]*$/", $name)) {
        echo "Name field must contain only letters.";
    } else {
        // Prepare and bind
        $stmt = $conn->prepare("SELECT * FROM users WHERE name=? AND password=?");
        $stmt->bind_param("ss", $name, $password);

        // Execute query
        $stmt->execute();

        // Get result
        $result = $stmt->get_result();

        // Check if the username and password already exist in the database
        if ($result->num_rows > 0) {
            echo "Logged in successfully<br>";
            // Fetch user details
            while ($row = $result->fetch_assoc()) {
                echo "Username: " . $row['name'] . "<br>";
                echo "Password: " . $row['password'] . "<br>";
            }
        } else {
            // Insert new record if the username and password do not exist
            $stmt = $conn->prepare("INSERT INTO users (name, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $name, $password);

            if ($stmt->execute() === TRUE) {
                echo "New record created successfully<br>";
                echo "Username: " . $name . "<br>";
                echo "Password: " . $password . "<br>";
                echo "Logged in successfully";
            } else {
                echo "Error: " . $stmt->error;
            }
        }

        $stmt->close();
    }
}

$conn->close();
?>
