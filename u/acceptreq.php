<?php
session_start();
?>
<?php
require '../gameconn/conn.php';

if ($_SESSION["admin"] == 1){
    if(isset($_POST["id"])){
        $id = $_POST["id"];
        $sql = "SELECT * FROM umimetoreq WHERE id=$id LIMIT 1";
        $result = $conn->query($sql);
        $result = $result->fetch_assoc();
        $nick = $result["nick"];
        $ip = $result["ip"];

        $sql = "DELETE FROM umimetoreq WHERE id=$id LIMIT 1";
        $conn->query($sql);

        $stmt = $conn->prepare("INSERT INTO umimeto (nick, ip) VALUES (?, ?)");
        $stmt->bind_param("ss", $nick, $ip);
        $stmt->execute();
    }
}
?>