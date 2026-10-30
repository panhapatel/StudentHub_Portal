<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

if (isset($_SESSION["last_activity"]) &&
    time() - $_SESSION["last_activity"] > 300) {

    session_unset();
    session_destroy();

    header("Location: login.php?timeout=1");
    exit;
}

$_SESSION["last_activity"] = time();

$username = $_SESSION["username"];
$role = $_SESSION["role"];
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <link rel="stylesheet" href="style.css">

    <title>Student Dashboard</title>
</head>

<body>

<table width="100%">
    <tr>
        <td width="20%" align="center">
            <a href="index.html">
                <button type="button">Home</button>
            </a>
        </td>

        <td width="60%" align="center">
            <h1>Student Dashboard</h1>
        </td>

        <td width="20%" align="center">
            <a href="logout.php">
                <button type="button" class="btn btn-danger">Logout</button>
            </a>
        </td>
    </tr>
</table>

<hr>

<center>
    <h2>
        Welcome, <?php echo htmlspecialchars($username); ?>!
    </h2>

    <p>Your role: <?php echo htmlspecialchars($role); ?></p>

    <h3>Student Services</h3>
</center>

<br>

<center>
<table width="80%" cellpadding="35">

    <tr>
        <td align="center">
            <a href="profile.html">
                <button type="button" class="dashboard-btn">Profile</button>
            </a>
        </td>

        <td align="center">
            <a href="fees.html">
                <button type="button" class="dashboard-btn">Fees</button>
            </a>
        </td>

        <td align="center">
            <a href="attendance.html">
                <button type="button" class="dashboard-btn">Attendance</button>
            </a>
        </td>
    </tr>

    <tr>
        <td align="center">
            <a href="result.html">
                <button type="button" class="dashboard-btn">Result</button>
            </a>
        </td>

        <td align="center">
            <a href="timetable.html">
                <button type="button" class="dashboard-btn">Time Table</button>
            </a>
        </td>

        <td align="center">
            <a href="event.html">
                <button type="button" class="dashboard-btn">Event</button>
            </a>
        </td>
    </tr>

</table>
</center>

<br><br><br>

<hr>

<footer>
    <center>&copy; 2026 StudentHub Portal</center>
</footer>

</body>
</html>
