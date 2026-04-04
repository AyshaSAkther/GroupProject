<?php
// Start session so we can store user info
session_start();

// Connect to database
include 'db.php';

// Store login error message
$message = '';

// Run this code when the login form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST['email'];
    $password = $_POST['password'];

    // Find the user by email
    $stmt = $conn->prepare("SELECT id, first_name, password FROM donors WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // Check if a user was found
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $first_name, $hashed_password);
        $stmt->fetch();

        // Check if password matches
        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $id;
            $_SESSION['user_name'] = $first_name;
            header("Location: dashboard.php");
            exit();
        } else {
            $message = "Invalid email or password";
        }
    } else {
        $message = "Invalid email or password";
    }

    
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    
    <title>Login</title>

    <!-- Link CSS file -->
    <link rel="stylesheet" href="style.css">
</head>
<body>


<div class="form-container">
    <h2>Login</h2>

    <!-- Show login error message -->
    <?php if ($message) echo "<p>$message</p>"; ?>

    <!-- Login form -->
    <form method="POST">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>

    <!-- Link back to home -->
    <br>
    <a href="index.php">⬅ Back to Home</a>

    <!-- Link to register page -->
    <p style="margin-top:10px;">
        Don't have an account? <a href="register.php">Register</a>
    </p>
</div>

</body>
</html>