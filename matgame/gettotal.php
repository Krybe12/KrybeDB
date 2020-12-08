<?php
session_start();
?>
<?php
require 'conne.php';
$username = $_SESSION["user"];
if (isset($_SESSION["mats"])){
    echo "Total Score: " . $_SESSION["mats"];
} else {
    $sql = "SELECT matscore FROM users WHERE username='$username' LIMIT 1";
    $result = $conn->query($sql);
    $result = $result->fetch_assoc();
    $_SESSION["mats"] = $result["matscore"];
    echo "Total Score: " . $_SESSION["mats"];
}
?>