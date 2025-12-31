<?php
session_start();
include("db.php");

if(!isset($_SESSION['username'])){
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

$query = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
$user = mysqli_fetch_assoc($query);

if(isset($_POST['delete'])){
    if(!empty($user['profile_image']) && $user['profile_image'] !== "default.png"){
        $file = "uploads/".$user['profile_image'];
        if(file_exists($file)){
            unlink($file);
        }
    }

    mysqli_query($conn, "DELETE FROM users WHERE username='$username'");
    session_unset();
    session_destroy();
    header("Location: register.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Delete Account</title>
    <link rel="stylesheet" href="css/delete.css">
</head>
<body>

<div class="delete-box">
    <h2>⚠ Delete Account</h2>
    <p>This action is permanent. All your data will be deleted.</p>

    <form method="POST" onsubmit="return confirm('Are you sure? This cannot be undone!');">
        <button type="submit" name="delete" class="danger">
            Delete My Account
        </button>
    </form>

    <a href="profile.php" class="cancel">Cancel & go back</a>
</div>

</body>
</html>
