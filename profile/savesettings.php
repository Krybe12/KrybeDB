<?php
session_start();
?>
<?php
require '../gameconn/conn.php';
if (!isset($_SESSION["user"]) || $_SESSION["verified"] != 1){
    header('Location: ../index.php?id=login&re=nt');
}
?>
<?php
if ($_POST) {
    $color = $_POST['favcolor'];
    $_SESSION["color"] = $color;
    $_SESSION["profilenotset"] = 0;
    $userid = $_SESSION["userid"];
    $sql = "UPDATE usersettings SET color='$color' WHERE user_id='$userid'";
    $conn->query($sql);
    $sql = "UPDATE usersettings SET setup='1' WHERE user_id='$userid'";
    $conn->query($sql);
    header('Location: ../profile');
    //echo "<h1 style='color: $color;'>ahoj</h1>";
}
?>