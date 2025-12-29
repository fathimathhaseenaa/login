    <?php
    include("db.php");
    session_start();

    if (isset($_POST['submit'])) {

        $name = $_POST['name'];
        $password = $_POST['password'];

        $query = "SELECT * FROM user WHERE name='$name' AND password='$password'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) == 1) {
            $_SESSION['username'] = $name;
            header("Location: home.php");
            exit();
        } else {
            $error = "Invalid username or password!";
        }
    }

    ?>
    <!DOCTYPE html> 
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login Screen</title>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        <link rel="stylesheet" href="login.css">
    </head>
    <body>

    <div class="mobile-container">

        <div class="shape-green">
            <h1 class="login-text">Login</h1>
        </div>
        <div class="shape-yellow"></div>

        <div class="content">

        
            <form method="POST">
                
                <div class="input-group">
            <?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
                    
                    <input type="text" placeholder="name"  name="name" required>
                </div>

                <div class="input-group">
                    <input type="password" placeholder="Password"  name="password"required>
                </div>


            <button type="submit" name="submit" class="signin-btn"> Sign in </button>
        </form>


            <div class="social-section">
                <p>Or sign in with</p>

                <div class="social-icons">
                    <div class="icon-circle"><i class="fa-brands fa-facebook-f"></i></div>
                    <div class="icon-circle"><i class="fa-brands fa-google"></i></div>
                    <div class="icon-circle"><i class="fa-brands fa-twitter"></i></div>
                </div>
            </div>

            <footer>
                <a href="register.php"> <span>You don't have an account?   </span>Sign up</a>
                <!-- <a href="#">Forgot Password?</a> -->
            </footer>

        </div>
    </div>

    </body>
    </html>
