<?php
session_start();
?>
<?php
require '../gameconn/conn.php';
$userid = $_SESSION["userid"];

if ($_SESSION["admin"] == 1){
    if(isset($_GET["table"]) && $_GET["table"] == "blacklist"){
        
    }

} else {
    header("Location: ../login/logout.php");
}
?>