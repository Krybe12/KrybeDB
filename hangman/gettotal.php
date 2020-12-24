<?php
session_start();
?>
<?php
require '../gameconn/conn.php';

$userid = $_SESSION["userid"];
if (isset($_SESSION["hang"]["totalScore"])){
    send();
} else {
    $sql = "SELECT score FROM hangman WHERE user_id='$userid' LIMIT 1";
    $result = $conn->query($sql);
    $result = $result->fetch_assoc();
    $_SESSION["hang"]["totalScore"] = $result["score"];
    send();
}
function send(){
    echo $_SESSION["hang"]["totalScore"];
}