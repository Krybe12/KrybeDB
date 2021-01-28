<?php
session_start();
?>
<?php
require '../gameconn/conn.php';

if ($_SESSION["admin"] == 1){
    if(isset($_POST["id"])){
        $id = $_POST["id"];
        $sql = "DELETE FROM umimeto WHERE id=$id LIMIT 1";
        $conn->query($sql);
    }
}