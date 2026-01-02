<?php
session_start();
include("db.php");

/* ===== CHECK LOGIN ===== */
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

$query = mysqli_query($conn, "SELECT * FROM user WHERE name='$username'");
$user = mysqli_fetch_assoc($query);

$error = "";
$success = "";

if(isset($_POST['upload'])) {

    if(isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {

        $allowed = ['jpg','jpeg','png','gif'];
        $filename = $_FILES['profile_image']['name'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);

        if(!in_array(strtolower($ext), $allowed)){
            $error = "Only JPG, PNG & GIF files allowed!";
        } else {
            $newname = $username . "_" . time() . "." . $ext;
            $destination = "uploads/" . $newname;

            if(move_uploaded_file($_FILES['profile_image']['tmp_name'], $destination)){
                // Update in database
                $update = mysqli_query($conn, "UPDATE user SET profile_image='$newname' WHERE name='$username'");
                if($update){
                    $success = "Profile image updated!";
                    $user['profile_image'] = $newname;
                } else {
                    $error = "Database update failed!";
                }
            } else {
                $error = "Failed to move uploaded file!";
            }
        }

    } else {
        $error = "No file selected!";
    }
}
// if(isset($_POST['delete_profile'])){
    // if(isset($_))

}

$profile_image = !empty($user['profile_image']) ? $user['profile_image'] : "default.png";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="css/edit_profile.css">
</head>
<body>

<div class="edit-box">

    <!-- Page title -->
    <h2>Edit Profile</h2>
    <p class="subtitle">Update your profile picture</p>

    <!-- Profile Image -->
    <div class="profile-img">
        <img src="uploads/<?php echo $profile_image; ?>" alt="Profile Image">
    </div>

    <!-- Upload Form -->
    <form method="POST" enctype="multipart/form-data">
        <label for="profile_image">Choose new profile image</label>
        <input type="file" name="profile_image" id="profile_image" required>

        <button type="submit" name="upload">Upload Image</button>
    </form>

    <!-- Messages -->
    <?php if ($error) { ?>
        <p class="error"><?php echo $error; ?></p>
    <?php } ?>

    <?php if ($success) { ?>
        <p class="success"><?php echo $success; ?></p>
    <?php } ?>

    <!-- Links -->
    <div class="links">
        <button type="delete_profile">Delete profile</button>
        <a href="profile.php">⬅ Back to Profile</a><br>
        <a href="delete.php">🗑 Delete Account</a>
    </div>

</div>

</body>
</html>
