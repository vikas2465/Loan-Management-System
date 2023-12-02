<?php
// Establish a database connection (use your own database credentials)
$conn = mysqli_connect("localhost", "root", "", "interest_book");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Check if the email already exists
    $checkQuery = "SELECT * FROM users WHERE email='$email'";
    $checkResult = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        // Email already exists
        echo "Email already registered. Please choose a different email.";
    } else {
        // Hash the password (you should use a stronger password hashing method)
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Insert the user's data into the database
        $query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";

        if (mysqli_query($conn, $query)) {
            // Registration successful
            header('Location: login.php');
        } else {
            // Registration failed
            echo "Error: " . mysqli_error($conn);
        }
    }
}

// Close the database connection
mysqli_close($conn);
?>
