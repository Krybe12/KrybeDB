<?php
session_start();
?>
<?php
require 'conne.php';
if (!isset($_SESSION["user"]) || $_SESSION["verified"] != 1){
    header('Location: ../index.php?id=login&re=nt');
}
$stmt = $conn->prepare("SELECT id FROM users WHERE username=? LIMIT 1");
$stmt->bind_param("s", $_SESSION["user"]);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();
$_SESSION["userid"] = $result["id"];
$userid = $_SESSION["userid"];

$stmt = $conn->prepare("SELECT color,setup FROM usersettings WHERE user_id=? LIMIT 1"); // gets color and setup
$stmt->bind_param("i", $_SESSION["userid"]);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();

$date = date("l jS \of F Y h:i:s A");
$sql = "UPDATE users SET lastlogin='$date' WHERE id='$userid'"; //logs last login
$conn->query($sql);

if (!$result){
    $stmt = $conn->prepare("INSERT INTO usersettings (user_id) VALUES (?)");
    $stmt->bind_param("i", $_SESSION["userid"]);
    $stmt->execute();
    $_SESSION["color"] = "#000000";
    $_SESSION["profilenotset"] = 1;
} else{
    $_SESSION["color"] = $result["color"];
    if($result["setup"] == 0) {
        $_SESSION["profilenotset"] = 1;
    } else {
        $_SESSION["profilenotset"] = 0;
    }
}
if (isset($_SESSION["gotopage"])){
    $page = $_SESSION["gotopage"];
} else {
    $page = "../mainpage.php";
}

header("Location: $page");
?>