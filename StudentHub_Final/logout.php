<?php
session_start();
require "db.php";

if (isset($_SESSION["user_id"])) {
    $userId = (int)$_SESSION["user_id"];

    $stmt = $conn->prepare(
        "UPDATE users
         SET remember_token = NULL, token_expiry = NULL
         WHERE id = ?"
    );

    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->close();
}

setcookie("remember_token", "", [
    "expires"  => time() - 3600,
    "path"     => "/",
    "secure"   => !empty($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] !== "off",
    "httponly" => true,
    "samesite" => "Lax"
]);

$_SESSION = [];

if (ini_get("session.use_cookies")) {
    $p = session_get_cookie_params();
    setcookie(session_name(), "", time() - 3600, $p["path"], $p["domain"], $p["secure"], $p["httponly"]);
}

session_destroy();

header("Location: login.php");
exit;
