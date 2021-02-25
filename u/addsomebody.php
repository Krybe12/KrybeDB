<?php
session_start();
?>
<?php
require '../gameconn/conn.php';

if ($_SESSION["admin"] == 1){
    if (isset($_POST["name"]) and isset($_POST["ip"])){
        $name = $_POST["name"];
        $ip = $_POST["ip"];
        $stmt = $conn->prepare("INSERT INTO umimeto (nick, ip) VALUES (?, ?)");
        $stmt->bind_param("ss", $name, $ip);
        $stmt->execute();
    }

}
?>