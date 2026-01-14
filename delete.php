<?php
session_start();
include("db.php");

/* =========================
   Check login
========================= */
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

/* =========================
   Fetch user
========================= */
$stmt = $conn->prepare("SELECT * FROM users WHERE name = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("User not found!");
}

$user = $result->fetch_assoc();

/* =========================
   Delete account
========================= */
if (isset($_POST['delete'])) {

    // Delete profile image
    if (!empty($user['profile_image']) && $user['profile_image'] !== "default.png") {
        $file = "uploads/" . $user['profile_image'];
        if (file_exists($file)) {
            unlink($file);
        }
    }

    // Delete user record
    $stmt = $conn->prepare("DELETE FROM users WHERE name = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();

    // Destroy session
    session_unset();
    session_destroy();

    header("Location: register.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Delete Account</title>
<link rel="stylesheet" href="css/delete.css">
</head>
<body>

<div class="sidebar">
    <h3><?php echo htmlspecialchars($user['name']); ?></h3>
    <a href="profile.php">Profile</a>
    <a href="edit_profile.php">Edit Profile</a>
    <a href="delete_account.php">Delete Account</a>
</div>

<div class="main-content">

    <h2>Delete Account</h2>

    <p style="color:red;">
        ⚠️ Warning: This action is permanent and cannot be undone.
    </p>

    <form method="POST">
        <button type="submit" name="delete" class="delete-btn">
            Yes, Delete My Account
        </button>
    </form>

    <br>

    <a href="profile.php">Cancel</a>

</div>

</body>
</html>