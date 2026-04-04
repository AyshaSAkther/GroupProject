<?php
// Start session to track the user
session_start();

// Redirect user to login page if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Connect to the database
include 'db.php';
?>

<!DOCTYPE html>
<html>
<head>
    
    <title>Dashboard</title>

    <!-- Link CSS file -->
    <link rel="stylesheet" href="style.css">
</head>
<body>


<div class="nav">
    <h2>Donation Platform</h2>
    <div>
        <a href="index.php">Home</a>
        <a href="list_campaigns.php">Campaigns</a>
        <a href="create_campaign.php">Create</a>
        <a href="history.php">History</a>
        <a href="logout.php">Logout</a>
    </div>
</div>


<div style="padding:40px; text-align:center;">

    
    <h1>Welcome, <?php echo $_SESSION['user_name']; ?> 👋</h1>

  
    <p style="font-size:18px; color:#555;">
        Ready to make an impact today? You can create campaigns or support others.
    </p>

    <div class="categories">

        <!-- Create campaign card -->
        <div class="cardbox">
            <h2>📢 Create Campaign</h2>
            <p>Start a new fundraising campaign and help others.</p>
            <a href="create_campaign.php" class="btn">Create</a>
        </div>

        <!-- View campaigns card -->
        <div class="cardbox">
            <h2>💰 View Campaigns</h2>
            <p>Explore campaigns and donate to meaningful causes.</p>
            <a href="list_campaigns.php" class="btn">Browse</a>
        </div>

        <!-- Donation history card -->
        <div class="cardbox">
            <h2>📊 Donation History</h2>
            <p>See your donations and contributions.</p>
            <a href="history.php" class="btn">View History</a>
        </div>

    </div>

  
    <h2 style="text-align:center; margin-top:50px;">Ready to Donate</h2>

   
    <div class="categories">

        <!-- Education card -->
        <div class="cardbox">
            <h2>🎓 Education</h2>
            <p>Support low-income students by helping cover tuition and school expenses.</p>
            <p><strong>Goal:</strong> $100,000</p>
            <a href="donate.php?campaign_id=1" class="btn">Donate</a>
        </div>

        <!-- Medical card -->
        <div class="cardbox">
            <h2>🏥 Medical</h2>
            <p>Support cancer patients with treatment costs and medical care.</p>
            <p><strong>Goal:</strong> $1,000,000</p>
            <a href="donate.php?campaign_id=2" class="btn">Donate</a>
        </div>

        <!-- Kids card -->
        <div class="cardbox">
            <h2>👶🏻👦🏻👧🏻 Kids</h2>
            <p>Help children access education and basic necessities.</p>
            <p><strong>Goal:</strong> $50,000</p>
            <a href="donate.php?campaign_id=3" class="btn">Donate</a>
        </div>

        <!-- Immigration card -->
        <div class="cardbox">
            <h2>🌍 Immigration</h2>
            <p>Support refugees with housing, legal aid, and living expenses.</p>
            <p><strong>Goal:</strong> $500,000</p>
            <a href="donate.php?campaign_id=4" class="btn">Donate</a>
        </div>

    </div>

</div>

</body>
</html>