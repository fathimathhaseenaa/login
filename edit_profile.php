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

$profile_image = !empty($user['profile_image']) ? $user['profile_image'] : "default.png";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>
</head>
<body>
<h2>Edit Profile</h2>

<!-- Show current image -->
<img src="uploads/<?php echo $profile_image; ?>" width="120"><br><br>

<!-- Upload form -->
<form method="POST" enctype="multipart/form-data">
    <input type="file" name="profile_image" required><br><br>
    <button type="submit" name="upload">Upload Image</button>
    <p><a href="delete.php">Delete</a></p>
</form>

<?php
if($error != "") echo "<p style='color:red;'>$error</p>";
if($success != "") echo "<p style='color:green;'>$success</p>";
?>

<a href="profile.php">Back to Profile</a>
</body>
</html>
