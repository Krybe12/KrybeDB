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
        $sql = "SELECT lastlogin,registerdate FROM users WHERE id='$userid' LIMIT 1"; //getiin users login a reg date
        $result = $conn->query($sql);
        if ($result->num_rows > 0){
            $result = $result->fetch_assoc();
            $selUserLastLogin = $result["lastlogin"];
            $selUserRegisterDate = $result["registerdate"];
            echo "<div><h3><b>Register Date:</b></h3> <h5>$selUserRegisterDate</h5></div><div><h3><b>Last login Date:</b></h3> <h5>$selUserLastLogin</h5></div>";
        }
    }

}
