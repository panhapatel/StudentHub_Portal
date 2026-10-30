<?php
session_start();
require "db.php";

$error = "";

if (isset($_GET["timeout"])) {
    $error = "Session expired. Please login again.";
}

function setRememberToken($conn, $userId)
{
    $token = bin2hex(random_bytes(32));
    $expiry = date("Y-m-d H:i:s", time() + (30 * 24 * 60 * 60));

    $stmt = $conn->prepare(
        "UPDATE users SET remember_token = ?, token_expiry = ? WHERE id = ?"
    );

    // Only the hash of the token is stored in the database.
    $tokenHash = hash("sha256", $token);

    $stmt->bind_param("ssi", $tokenHash, $expiry, $userId);
    $stmt->execute();
    $stmt->close();

    setcookie("remember_token", $token, [
        "expires" => time() + (30 * 24 * 60 * 60),
        "path" => "/",
        "secure" => !empty($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] !== "off",
        "httponly" => true,
        "samesite" => "Lax"
    ]);
}

if (isset($_SESSION["user_id"])) {
    header("Location: dashboard.php");
    exit;
}

if (isset($_COOKIE["remember_token"])) {
    $token = $_COOKIE["remember_token"];

    if (preg_match('/^[a-f0-9]{64}$/', $token)) {
        $stmt = $conn->prepare(
            "SELECT id, username, role FROM users
             WHERE remember_token = ? AND token_expiry > NOW()"
        );

        $tokenHash = hash("sha256", $token);

        $stmt->bind_param("s", $tokenHash);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
            $stmt->bind_result($id, $username, $role);
            $stmt->fetch();

            session_regenerate_id(true);

            $_SESSION["user_id"] = $id;
            $_SESSION["username"] = $username;
            $_SESSION["role"] = $role;
            $_SESSION["last_activity"] = time();

            $stmt->close();
            header("Location: dashboard.php");
            exit;
        }

        $stmt->close();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    if ($email == "" || $password == "") {
        $error = "Please enter email and password.";
    } else {
        $stmt = $conn->prepare(
            "SELECT id, username, password, role FROM users WHERE email = ?"
        );

        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
            $stmt->bind_result($id, $username, $hash, $role);
            $stmt->fetch();

            if (password_verify($password, $hash)) {
                session_regenerate_id(true);

                $_SESSION["user_id"] = $id;
                $_SESSION["username"] = $username;
                $_SESSION["role"] = $role;
                $_SESSION["last_activity"] = time();

                $stmt->close();

                if (isset($_POST["remember"])) {
                    setRememberToken($conn, $id);
                }

                header("Location: dashboard.php");
                exit;
            }
        }

        $stmt->close();
        $error = "Invalid email or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Login</title>
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

<table width="100%">
    <tr>
        <td width="20%" align="center">
            <img src="logo.png" width="100" alt="StudentHub Logo">
        </td>

        <td width="60%" align="center">
            <h1>STUDENTHUB PORTAL</h1>
        </td>

        <td width="20%" align="center">
            <a href="index.html">
                <button type="button">Home</button>
            </a>
        </td>
    </tr>
</table>

<center>
    <h2>
        <span style="background-color: beige; color: crimson; font-weight: bold; padding: 5px;">
            Student Login
        </span>
    </h2>
</center>

<div class="login-box">

    <?php if ($error != "") { ?>
        <p style="color:red;">
            <?php echo htmlspecialchars($error); ?>
        </p>
    <?php } ?>

    <form action="login.php" method="post">

        <label for="email">Email</label>
        <input type="email" id="email" name="email"
               placeholder="Enter your registered email" required>
        <br><br>

        <label for="password">Password</label>
        <input type="password" id="password" name="password"
               placeholder="Enter your password" required>
        <br><br>

        <label class="checkbox-label">
            <input type="checkbox" name="remember" value="1">
            Remember Me
        </label>
        <br><br>

        <input type="submit" value="Login">

    </form>

    <p>
        Don't have an account?
        <a href="register.html">Create an Account</a>
    </p>

</div>

<footer>
    &copy;2026 StudentHub Portal
</footer>

</body>
</html>
