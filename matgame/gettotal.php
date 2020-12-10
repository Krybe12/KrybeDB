<?php
session_start();
?>
<?php
require 'conne.php';
$userid = $_SESSION["userid"];
if (isset($_SESSION["mats"])){
    echo "Total Score: " . $_SESSION["mats"];
} else {
    $sql = "SELECT score FROM matgame WHERE user_id='$userid' LIMIT 1";
    $result = $conn->query($sql);
    $result = $result->fetch_assoc();
    $_SESSION["mats"] = $result["score"];
    echo "Total Score: " . $_SESSION["mats"];
}
?>