<?php
// Start session so the page knows if a user is logged in
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    
    <title>Donation And Fundraising Platform</title>

    <!-- Link CSS file -->
    <link rel="stylesheet" href="style.css">
</head>
<body>


<div class="nav">
    <h2>Donation Platform</h2>
    <div>
        <a href="/donation_platform/index.php">Home</a>

        <?php if(isset($_SESSION['user_id'])): ?>
            <a href="/donation_platform/dashboard.php">Dashboard</a>
            <a href="/donation_platform/logout.php">Logout</a>
        <?php else: ?>
            <a href="/donation_platform/register.php">Register</a>
            <a href="/donation_platform/login.php">Login</a>
        <?php endif; ?>
    </div>
</div>

<!-- image and message -->
<div class="top-section">
    <img src="donation.jpg" class="top-img" alt="Donation Banner">

    <div class="top-text">
        <h1>Make a Difference Today</h1>
        <p>Support meaningful causes and help change lives through your generosity.</p>

       
        <br>
        <a href="list_campaigns.php" class="btn explore-btn">Explore Campaigns</a>

        <!-- Login/register helper message -->
        <p style="margin-top: 20px; color: white; font-weight: bold; text-align: center; text-shadow: 1px 1px 4px rgba(0,0,0,0.7);">
            Please <a href="register.php" style="color: #90caf9;">register</a> or
            <a href="login.php" style="color: #90caf9;">login</a> to access the dashboard and explore campaigns.
        </p>
    </div>
</div>

<!-- Home page  -->
<div class="categories">

    <!-- Education -->
    <div class="cardbox no-hover">
        <h2>🎓 Education</h2>
        <p>Support low-income students by helping cover tuition and school expenses.</p>
    </div>

    <!-- Medical -->
    <div class="cardbox no-hover">
        <h2>🏥 Medical</h2>
        <p>Support cancer patients with treatment costs and medical care.</p>
    </div>

    <!-- Kids -->
    <div class="cardbox no-hover">
        <h2>👶🏻👦🏻👧🏻 Kids</h2>
        <p>Help children access education and basic necessities.</p>
    </div>

    <!-- Immigration -->
    <div class="cardbox no-hover">
        <h2>🌍 Immigration</h2>
        <p>Support refugees with housing, legal aid, and living expenses.</p>
    </div>

</div>

</body>
</html>