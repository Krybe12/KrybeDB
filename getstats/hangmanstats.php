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
        $sql = "SELECT score FROM hangman WHERE user_id='$userid' LIMIT 1"; //gettin users mat score
        $result = $conn->query($sql);
        if ($result->num_rows > 0){
            $result = $result->fetch_assoc();
            $score = $result["score"];
            echo "<h3><b>Hangman score:</b> $score</h3>";
        }
    }

}
?>