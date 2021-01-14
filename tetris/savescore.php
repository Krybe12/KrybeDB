<?php
session_start();
?>
<?php
require '../gameconn/conn.php';
$userid = $_SESSION["userid"];

if (isset($_POST["score"]) and $_POST["score"] > 0 and $_POST["score"] < 1500){
    addScore($_POST["score"]);
}

function addScore($n){
    global $userid;
    global $conn;
    if ($n > $_SESSION["tetris"]["highScore"]){
        $_SESSION["tetris"]["highScore"] = $n;
        $sql = "UPDATE tetris SET score='$n' WHERE user_id='$userid'";
        $conn->query($sql);
    }
}
?>