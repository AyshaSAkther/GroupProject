<?php
// Start sess dor whos is logged in
session_start();

// Connect to the database
include 'db.php';

//  only logged-in users can create campaign
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// success or error
$message = '';

//  form is submitted 
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get form inputs
    $title = $_POST['title'];
    $description = $_POST['description'];
    $goal_amount = $_POST['goal_amount'];
    $created_by = $_SESSION['user_id'];

    // Insert new campaign into the database
    $stmt = $conn->prepare("INSERT INTO campaigns (title, description, goal_amount, created_by) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssdi", $title, $description, $goal_amount, $created_by);

    // success or error 
    if ($stmt->execute()) {
        $message = "Campaign created successfully ✅";
    } else {
        $message = "Error creating campaign ❌";
    }

   
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    
    <title>Create Campaign</title>

    <!-- Link CSS file -->
    <link rel="stylesheet" href="style.css">
</head>
<body>


<div class="form-container">
    <h2>Create Campaign</h2>

    <!-- Show success or error message -->
    <?php if ($message) echo "<p>$message</p>"; ?>

    <!-- Campaign creation form -->
    <form method="POST">
        <input type="text" name="title" placeholder="Campaign Title" required>

        <textarea name="description" placeholder="Campaign Description" required style="width:100%; padding:10px; margin:10px 0; border:1px solid #ccc; border-radius:5px;"></textarea>

        <input type="number" step="0.01" name="goal_amount" placeholder="Goal Amount ($)" required>

        <button type="submit">Create Campaign</button>
    </form>

    <!-- Bring back to dashboard -->
    <br>
    <a href="dashboard.php">⬅ Back to Dashboard</a>
</div>

</body>
</html>