<?php
// Connect to database
include 'db.php';

// Store message success or error
$message = '';

// Run this code  when the register form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get form values
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Insert new user into the donors table
    $stmt = $conn->prepare("INSERT INTO donors (first_name, last_name, email, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $first_name, $last_name, $email, $password);

    // Show success or error 
    if ($stmt->execute()) {
        $message = "Registration successful ✅";
    } else {
        $message = "Error: " . $stmt->error;
    }

    
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    
    <title>Register</title>

    <!-- Link CSS file -->
    <link rel="stylesheet" href="style.css">
</head>
<body>


<div class="form-container">
    <h2>Register</h2>

    <!-- Show register message -->
    <?php if ($message) echo "<p>$message</p>"; ?>

    <!-- Register form -->
    <form method="POST">
        <input type="text" name="first_name" placeholder="First Name" required>
        <input type="text" name="last_name" placeholder="Last Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Register</button>
    </form>

    <!-- Link back to home -->
    <br>
    <a href="index.php">⬅ Back to Home</a>

    <!-- Link to login page -->
    <p style="margin-top:10px;">
        Already have an account? <a href="login.php">Login</a>
    </p>
</div>

</body>
</html>