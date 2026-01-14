<?php
session_start();
include("db.php");

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
$query = mysqli_query($conn, "SELECT * FROM users WHERE name='$username'");
$user = mysqli_fetch_assoc($query);

$profile_image = !empty($user['profile_image']) ? $user['profile_image'] : "default.png";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Profile</title>
    <link rel="stylesheet" href="css/profile.css">
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <div class="sidebar-header">
        <img src="uploads/<?php echo $profile_image; ?>" class="profile-img">
        <h3><?php echo htmlspecialchars($user['name']); ?></h3>
    </div>

    <a href="home.php">Home</a>
    <a href="profile.php">My Profile</a>
    <a href="edit_profile.php">Edit Profile</a>

    <form action="logout.php" method="post">
        <button class="logout-btn">Logout</button>
    </form>
</div>

<!-- MAIN CONTENT -->
<div class="main-content">

    <h2>My Profile Dashboard</h2>

    <!-- PROFILE OVERVIEW -->
    <div class="section">
        <h3>Profile Overview</h3>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
        <p><strong>Username:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
    </div>

    <!-- PERSONAL DETAILS -->
    <div class="section">
        <h3>Personal Details</h3>

        <?php if(!empty($user['phone'])){ ?>
            <p><strong>Phone:</strong> <?php echo htmlspecialchars($user['phone']); ?></p>
        <?php } else { ?>
            <p><strong>Phone:</strong> Not added</p>
        <?php } ?>

        <?php if(!empty($user['gender'])){ ?>
            <p><strong>Gender:</strong> <?php echo htmlspecialchars($user['gender']); ?></p>
        <?php } else { ?>
            <p><strong>Gender:</strong> Not specified</p>
        <?php } ?>
    </div>

    <!-- ACCOUNT STATUS -->
    <div class="section">
        <h3>Account Status</h3>
        <p><strong>Account:</strong> Active</p>
        <p><strong>Member Since:</strong> <?php echo date("d M Y", strtotime($user['created_at'] ?? date("Y-m-d"))); ?></p>
    </div>

    <!-- QUICK ACTIONS -->
    <div class="section">
        <h3>Quick Actions</h3>
        <p>• Update your personal information</p>
        <p>• Change profile picture</p>
        <p>• Secure your account</p>

        <a href="edit_profile.php" class="edit-btn">Edit Profile</a>
    </div>

</div>

</body>
</html>
