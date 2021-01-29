<?php
require 'gameconn/conn.php';

if (isset($_POST["name"]) and strlen($_POST["name"]) <= 14 and strlen($_POST["name"]) >= 3){
    $name = $_POST["name"];
    $ip = $_SERVER['REMOTE_ADDR'];
    $stmt = $conn->prepare("INSERT INTO umimetoreq (nick, ip) VALUES (?, ?)");
    $stmt->bind_param("ss", $name, $ip);
    $stmt->execute();
}
header('Location: https://youtu.be/dQw4w9WgXcQ');
?>