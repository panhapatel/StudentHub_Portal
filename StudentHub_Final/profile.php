<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Profile</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<center>
    <h1>STUDENTHUB PORTAL</h1>
    <h2>Student Profile</h2>
</center>

<div class="content">
    <p><b>Name:</b>
        <?php echo htmlspecialchars($_SESSION["username"]); ?>
    </p>

    <p><b>Role:</b>
        <?php echo htmlspecialchars($_SESSION["role"]); ?>
    </p>

    <a href="dashboard.php">Back to Dashboard</a>
</div>

</body>
</html>
