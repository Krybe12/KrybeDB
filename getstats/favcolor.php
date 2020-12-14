<?php
session_start();
?>
<?php
require '../gameconn/conn.php';

if (!isset($_SESSION["user"]) || $_SESSION["verified"] != 1){
    header("Location: ../index.php?id=login&re=nt");
}
if (isset($_GET["id"])){
    if (is_numeric($_GET["id"])){
        $userid = $_GET["id"] / 17;
        $sql = "SELECT color FROM usersettings WHERE user_id='$userid' LIMIT 1"; //getiin users fav color
        $result = $conn->query($sql);
        if ($result->num_rows > 0){
            $result = $result->fetch_assoc();
            $selUserFavColor = $result["color"];
            echo "<h1 style='background-color: $selUserFavColor;'>Fovorite color: $selUserFavColor</h1>";
        }
    }

}