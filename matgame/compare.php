<?php
session_start();
?>
<?php
require 'conne.php';
$username = $_SESSION["user"];
function add($n){
    global $username;
    global $conn;
    if ($n == 1){
        $_SESSION["mats"] = $_SESSION["mats"] + 1;
    } else {
        $_SESSION["mats"] = $_SESSION["mats"] - 1;
    }
    
    $score = $_SESSION["mats"];
    $sql = "UPDATE users SET matscore='$score' WHERE username='$username'";
    $conn->query($sql);
}

if (isset($_SESSION["mats"])){
} else {
    $sql = "SELECT matscore FROM users WHERE username='$username' LIMIT 1";
    $result = $conn->query($sql);
    $result = $result->fetch_assoc();
    $_SESSION["mats"] = $result["matscore"];
} 

if (isset($_POST["awnsered"])){
    if ($_POST["awnsered"] == $_SESSION["result"]){
        add(1);
        echo "Correct!";
    } else {
        add(0);
        echo "Wrong! " . $_SESSION["n1"] . $_SESSION["op"] . $_SESSION["n2"]. " = " . $_SESSION["result"];
    }
}
?>