<?php
// Start session to can check who is logged in
session_start();

// Connect to the database
include 'db.php';

// Make sure only logged-in users can donate
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get the campaign ID 
$campaign_id = isset($_GET['campaign_id']) ? (int)$_GET['campaign_id'] : 0;

// make values
$message = '';
$showForm = true;
$campaign_title = '';
$campaign_goal = 0;

// Store fixed dashboard campaigns
$staticCampaigns = [
    1 => ['title' => 'Education', 'goal' => 100000],
    2 => ['title' => 'Medical', 'goal' => 1000000],
    3 => ['title' => 'Kids', 'goal' => 50000],
    4 => ['title' => 'Immigration', 'goal' => 500000],
];

// Check if this is one of the fixed campaigns
if (isset($staticCampaigns[$campaign_id])) {
    $campaign_title = $staticCampaigns[$campaign_id]['title'];
    $campaign_goal = $staticCampaigns[$campaign_id]['goal'];

    // Check if this fixed campaign already exists in the database
    $stmt = $conn->prepare("SELECT id FROM campaigns WHERE id=?");
    $stmt->bind_param("i", $campaign_id);
    $stmt->execute();
    $stmt->store_result();

    // Insert campign  if it doest exist
    if ($stmt->num_rows == 0) {
        $insert = $conn->prepare("INSERT INTO campaigns (id, title, description, goal_amount, created_by) VALUES (?, ?, ?, ?, ?)");
        $desc = "Auto-generated campaign for $campaign_title";
        $created_by = 1;
        $insert->bind_param("issdi", $campaign_id, $campaign_title, $desc, $campaign_goal, $created_by);
        $insert->execute();
        $insert->close();
    }

    $stmt->close();
} else {
    // Get normal campaign info from the database
    $stmt = $conn->prepare("SELECT title, goal_amount FROM campaigns WHERE id=?");
    $stmt->bind_param("i", $campaign_id);
    $stmt->execute();
    $stmt->bind_result($campaign_title, $campaign_goal);
    $stmt->fetch();
    $stmt->close();
}

// Calculate how much has been donated so far
$stmt = $conn->prepare("SELECT IFNULL(SUM(amount),0) FROM donations WHERE campaign_id=?");
$stmt->bind_param("i", $campaign_id);
$stmt->execute();
$stmt->bind_result($total_donated);
$stmt->fetch();
$stmt->close();

// Calculate remaining amount
$remaining = $campaign_goal - $total_donated;

// when user submits the donation form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $amount = $_POST['amount'];
    $donor_id = $_SESSION['user_id'];

    // Insert donation into the donations table
    $stmt = $conn->prepare("INSERT INTO donations (donor_id, campaign_id, amount) VALUES (?, ?, ?)");
    $stmt->bind_param("iid", $donor_id, $campaign_id, $amount);

    // Show success or error 
    if ($stmt->execute()) {
        $message = "Donation successful! 🎉 Thank you for supporting '$campaign_title'.";
        $showForm = false;
        $total_donated += $amount;
        $remaining -= $amount;
    } else {
        $message = "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    
    <title>Donate to <?php echo htmlspecialchars($campaign_title); ?></title>

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

<!-- Main donation content -->
<div style="padding:40px; text-align:center;">
    <h2>Donate to <?php echo htmlspecialchars($campaign_title); ?></h2>
    <p><strong>Goal:</strong> $<?php echo number_format($campaign_goal); ?></p>
    <p><strong>Raised so far:</strong> $<?php echo number_format($total_donated); ?></p>
    <p><strong>Remaining:</strong> $<?php echo number_format($remaining); ?></p>

    <!-- Show message after donating -->
    <?php if ($message) echo "<p style='color:green; font-weight:bold;'>$message</p>"; ?>

    <!-- Show donation form if donation was not just submitted -->
    <?php if ($showForm): ?>
        <form method="POST">
            Amount:<br>
            <input type="number" name="amount" step="0.01" required><br><br>
            <button type="submit" class="btn">Donate</button>
        </form>
    <?php else: ?>
        <br>
        <a href="dashboard.php" class="btn">⬅ Go Back to Dashboard</a>
    <?php endif; ?>
</div>

</body>
</html>