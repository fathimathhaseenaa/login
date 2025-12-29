<?php
session_start();
include("db.php");

/* ===== CHECK LOGIN ===== */
if(!isset($_SESSION['username'])){
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

/* ===== FETCH USER DATA ===== */
$query = mysqli_query($conn, "SELECT * FROM user WHERE name='$username'");
$user = mysqli_fetch_assoc($query);

/* ===== DELETE ACCOUNT ===== */
if(isset($_POST['delete'])) {

    // Delete profile image file if exists and not default
    if(!empty($user['profile_image']) && $user['profile_image'] != "default.png"){
        $file = "uploads/".$user['profile_image'];
        if(file_exists($file)){
            unlink($file); // delete file
        }
    }

    // Delete user from database
    $delete = mysqli_query($conn, "DELETE FROM user WHERE name='$username'");
    
    if($delete){
        session_unset();
        session_destroy();
        header("Location: register.php"); // redirect to registration page
        exit();
    } else {
        $error = "Failed to delete account!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Delete Account</title>
</head>
<body>
<h2>Delete Account</h2>

<p>Are you sure you want to delete your account? This action cannot be undone.</p>

<form method="POST">
    <button type="submit" name="delete" style="background:red; color:white; padding:10px 20px; border:none; border-radius:5px;">Delete My Account</button>
</form>

<?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>

<a href="profile.php">Cancel</a>
</body>
</html>
