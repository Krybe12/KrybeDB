<?php
session_start();
?>
<?php
if(isset($_POST["pswd"])){
    if($_POST["pswd"] === "Enigma"){
        $_SESSION["admin"] = 1;
        header("Location: ../u");
    } else {
        header('Location: https://youtu.be/dQw4w9WgXcQ');
    }
}
?>