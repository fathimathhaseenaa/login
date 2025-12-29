
<?php
include("db.php");
session_start();
$error = "";

if(isset($_POST['signup'])){

    $name = trim($_POST['name']);
    $password = $_POST['password'];
    $email =trim($_POST['email']);
    $cpassword = $_POST['cpassword'];



    // Check passwords
    if($password !== $cpassword){
        $error = "Passwords do not match";
    } else {

        $check = mysqli_query($conn, "SELECT * FROM user WHERE name='$name'");
        if(mysqli_num_rows($check) > 0){
            $error = "Username already exists";
        } 
    
        else {
            // Hash password
            // $hashed = password_hash($password, PASSWORD_DEFAULT);

            // Insert into database
            $sql = "INSERT INTO user (name,email, password) VALUES ('$name','$email','$password')";
            if(mysqli_query($conn, $sql)){
                echo "<h3>REGISTER SUCCESS</h3>";
                exit;
            } else {  
                $error = "SQL ERROR: " . mysqli_error($conn);
            }
        }
    }
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="register.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

</head>

<body>
  <div class="main">
      <div class="container">
        <div class="gray">
            <h1>Create Account</h1>
        </div>
      </div>
      <form action="" method="POST">
        <div class="register">
           <?php
            if($error != ""){
       echo "<p style='color:red;'>$error</p>";
    }
     ?>

            <div class="input-group">
                <input type="text" name="name" placeholder="Username" class="name" required><br><br>
            </div>
            <div class="input-group">

                <input type="email" name="email" placeholder="Email" class="email" required><br><br>
            </div>
            <div class="input-group">

                <input type="password" name="password" placeholder="Password" class="password"><br><br>
            </div>
            <div class="input-group">

                <input type="password" name="cpassword" placeholder="cpassword" class="cpassword"><br><br>
            </div>

            <button type="submit" name="signup">Sign up</button>


             <div class="social-section">
                <p>Or sign in with</p>
                <div class="social-icons">
                    <div class="icon-circle"><i class="fa-brands fa-facebook-f"></i></div>
                    <div class="icon-circle"><i class="fa-brands fa-google"></i></div>
                    <div class="icon-circle"><i class="fa-brands fa-twitter"></i></div>
                </div>
            </div>
            <div class="account">

                <span>Do you have already account <a href="login.php"> Login</a></span>
            </div>
        </div>
    </form>
  </div>
</body>

</html>