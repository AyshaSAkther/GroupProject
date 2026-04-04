<?php
// Start session so we can check if user is logged in
session_start();

// Redirect user to login page if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Connect to database
include 'db.php';

// Join campaigns with donors to show who created each campaign
$sql = "SELECT campaigns.*, donors.first_name, donors.last_name
        FROM campaigns
        INNER JOIN donors ON campaigns.created_by = donors.id";

// Run the query
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    
    <title>All Campaigns</title>

    <!-- Link CSS file -->
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="nav">
    <h2>Donation Platform</h2>
    <div>
        <a href="index.php">Home</a>
        <a href="dashboard.php">Dashboard</a>
        <a href="create_campaign.php">Create Campaign</a>
        <a href="history.php">History</a>
        <a href="logout.php">Logout</a>
    </div>
</div>


<h2 style="text-align:center; margin-top:30px;">All Campaigns</h2>

<!-- Campaign cards -->
<div class="categories">

<?php while ($row = mysqli_fetch_assoc($result)) { ?>

    <div class="cardbox">
        <h3><?php echo $row['title']; ?></h3>

        <p>
            <strong>Description:</strong><br>
            <?php echo $row['description']; ?>
        </p>

        <p>
            <strong>Goal Amount:</strong>
            $<?php echo number_format($row['goal_amount'], 2); ?>
        </p>

        <p>
            <strong>Created By:</strong>
            <?php echo $row['first_name'] . " " . $row['last_name']; ?>
        </p>

        <a href="donate.php?campaign_id=<?php echo $row['id']; ?>" class="btn">Donate</a>
    </div>

<?php } ?>

</div>

</body>
</html>