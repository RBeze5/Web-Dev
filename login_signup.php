<?php
session_start();

// MySQL database connection
$servername = "your_servername";
$username = "your_username";
$password = "your_password";
$dbname = "your_database";

// Connect to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle user registration
if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Insert user details into the database
    $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
    if ($conn->query($sql) === true) {
        echo "Registration successful. You can now log in.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Handle user login
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Retrieve hashed password from the database
    $sql = "SELECT password FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $hashedPassword = $row['password'];

        // Verify the password
        if (password_verify($password, $hashedPassword)) {
            // Password is correct, generate a session or cookie to remember login status
            $_SESSION['username'] = $username;
            echo "Login successful. Welcome, $username!";
        } else {
            echo "Incorrect username or password.";
        }
    } else {
        echo "Incorrect username or password.";
    }
}

// Close the database connection
$conn->close();
?>
