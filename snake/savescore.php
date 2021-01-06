<?php
session_start();
?>
<?php
require '../gameconn/conn.php';
$userid = $_SESSION["userid"];

if (isset($_POST["score"]) and $_POST["score"] > 0){
    if ($_POST["score"] > 5){
        echo '<script id="yoink">
        $.post("savescore.php", {
            tailLen: snake.tailLen,
            lenOfTail: snake.tail.length,
            numFruits: snake.numFruits,
            numTurns: snake.numTurns
        }, function(data){
        });
        setTimeout(function(){$("#yoink").remove();}, 100);
        </script>';
    } else {
        addScore($_POST["score"]);
    }
}
if (isset($_POST["tailLen"]) and isset($_POST["lenOfTail"]) and isset($_POST["numFruits"]) and isset($_POST["numTurns"])){
    $tailLen = $_POST["tailLen"];
    $lenOfTail = $_POST["lenOfTail"];
    $turnsPerFood = $_POST["numTurns"] / $_POST["numFruits"];
    $numFruits = $_POST["numFruits"] + 1; // aby se to rovnalo s delkou ocasu
    $numTurns = $_POST["numTurns"];
    //echo "tailen: $tailLen lenoftail: $lenOfTail turnsperfood: $turnsPerFood numfruits+1: $numFruits numturns: $numTurns";
    if ($tailLen == $lenOfTail and $lenOfTail == $numFruits and is_numeric($tailLen)){
        if ($turnsPerFood > 1.8){
            addScore($tailLen);
        }
    }
}
function addScore($n){
    global $userid;
    global $conn;
    $_SESSION["snake"]["highScore"] = $n;
    $sql = "UPDATE snake SET score='$n' WHERE user_id='$userid'";
    $conn->query($sql);
}
echo "<script>snake = undefined;</script>"
?>