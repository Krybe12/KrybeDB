<?php
session_start();
?>
<?php
require '../gameconn/conn.php';

$userid = $_SESSION["userid"];
if (isset($_SESSION["tetris"]["highScore"])){
    send();
} else {
    $sql = "SELECT score FROM tetris WHERE user_id='$userid' LIMIT 1";
    $result = $conn->query($sql);
    $result = $result->fetch_assoc();
    $_SESSION["tetris"]["highScore"] = $result["score"];
    send();
}
function send(){
    echo $_SESSION["tetris"]["highScore"];
}