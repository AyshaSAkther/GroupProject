<?php
// Start session so we can check login
session_start();

// Redirect to login if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Connect to database
include 'db.php';

// Join donations, donors, and campaigns to show donation history
$sql = "SELECT donors.first_name, donors.last_name, campaigns.title, donations.amount
        FROM donations
        INNER JOIN donors ON donations.donor_id = donors.id
        INNER JOIN campaigns ON donations.campaign_id = campaigns.id";

// Run the query
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    
    <title>Donation History</title>

    <!-- Link CSS file -->
    <link rel="stylesheet" href="style.css">
</head>
<body>


<div class="nav">
    <h2>Donation Platform</h2>
    <div>
        <a href="index.php">Home</a>
        <a href="dashboard.php">Dashboard</a>
        <a href="list_campaigns.php">Campaigns</a>
        <a href="create_campaign.php">Create</a>
        <a href="history.php">History</a>
        <a href="logout.php">Logout</a>
    </div>
</div>


<h2 style="text-align:center;">Donation History</h2>

<!-- Donation history cards -->
<div class="categories">

<?php while ($row = mysqli_fetch_assoc($result)) { ?>

    <div class="cardbox">
        <p><strong>Donor:</strong>
            <?php echo $row['first_name'] . " " . $row['last_name']; ?>
        </p>

        <p><strong>Campaign:</strong>
            <?php echo $row['title']; ?>
        </p>

        <p><strong>Amount:</strong>
            $<?php echo number_format($row['amount'], 2); ?>
        </p>
    </div>

<?php } ?>

</div>

</body>
</html>