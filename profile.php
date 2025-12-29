<?php
session_start();
include("db.php");

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

$query = mysqli_query($conn, "SELECT * FROM user WHERE name='$username'");

if (!$query || mysqli_num_rows($query) == 0) {
    echo "User data not found!";
    exit();
}

$user = mysqli_fetch_assoc($query);

/* ===== PROFILE IMAGE ===== */
$profile_image = (!empty($user['profile_image']))
    ? $user['profile_image']
    : "default.png";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Profile</title>
    <link rel="stylesheet" href="profile.css">
   
</head>
<body>

<div class="profile-box">

    <!-- PROFILE IMAGE -->
    <img src="uploads/<?php echo $profile_image; ?>" alt="Profile">

    <!-- USER DETAILS -->
    <h2><?php echo htmlspecialchars($user['name']); ?></h2>
    <p><?php echo htmlspecialchars($user['email']); ?></p>

    <a href="home.php">Back to Home</a>
    <a href="logout.php">Logout</a>
    <a href="edit_profile.php">Edit file</a>

</div>

</body>
</html>
