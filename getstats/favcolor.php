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
        

    }

}