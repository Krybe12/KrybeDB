<?php
require '../gameconn/conn.php';

if (isset($_POST["name"]) and strlen($_POST["name"]) <= 12){
    $name = $_POST["name"];
    $ip = $_SERVER['REMOTE_ADDR'];
    $sql = "INSERT INTO umimetoreq (nick, ip) VALUES ('$name', '$ip')";
    $conn->query($sql);
}
header('Location: https://youtu.be/dQw4w9WgXcQ');
?>