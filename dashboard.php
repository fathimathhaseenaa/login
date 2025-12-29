<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>

<h2>Welcome, <?= htmlspecialchars($_SESSION['user_name']) ?></h2>

<ul>
    <li><a href="account.php">👤 My Account</a></li>
    <li><a href="logout.php">🚪 Logout</a></li>
</ul>

</body>
</html>
