<?php
session_start();
?>
<?php
require '../gameconn/conn.php';

if ($_SESSION["admin"] == 1){
    $ip = $_SERVER['REMOTE_ADDR'];
    $name = $_SESSION["user"];
    $stmt = $conn->prepare("INSERT INTO umimeto (nick, ip) VALUES (?, ?)");
    $stmt->bind_param("ss", $name, $ip);
    $stmt->execute();
}
?>