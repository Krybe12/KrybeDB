<?php
session_start();
?>
<?php
require '../gameconn/conn.php';
$userid = $_SESSION["userid"];
function add($n){
    global $userid;
    global $conn;
    if ($n == 1){
        $_SESSION["mats"] = $_SESSION["mats"] + 1;
    } else {
        $_SESSION["mats"] = $_SESSION["mats"] - 1;
    }
    
    $score = $_SESSION["mats"];
    $sql = "UPDATE matgame SET score='$score' WHERE user_id='$userid'";
    $conn->query($sql);
}


if (isset($_SESSION["mats"])){
} else {
    $sql = "SELECT score FROM matgame WHERE user_id='$userid' LIMIT 1";
    $result = $conn->query($sql);
    $result = $result->fetch_assoc();
    $_SESSION["mats"] = $result["matscore"];
} 

if (isset($_POST["awnsered"])){
    if ($_POST["awnsered"] == $_SESSION["result"]){
        $_SESSION["MatGameInRowWrong"] = 0;
        $_SESSION["MatGameInRowCorrect"] = $_SESSION["MatGameInRowCorrect"] + 1;
        add(1);
        echo "Correct!";
    } else {
        $_SESSION["MatGameInRowCorrect"] = 0;
        $_SESSION["MatGameInRowWrong"] = $_SESSION["MatGameInRowWrong"] + 1;
        add(0);
        echo "Wrong! " . $_SESSION["n1"] . $_SESSION["op"] . $_SESSION["n2"]. " = " . $_SESSION["result"];
    }
}
?>