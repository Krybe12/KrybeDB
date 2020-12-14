<?php
require 'conne.php';
function database($name, $pswd){
    global $conn;
    $stmt = $conn->prepare("SELECT username FROM users WHERE username=? LIMIT 1");
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    if (!$result){
        $ip = $_SERVER['REMOTE_ADDR'];
        $date = date("l jS \of F Y h:i:s A");

        $stmt = $conn->prepare("INSERT INTO users (username, pass, ip, lastlogin, registerdate) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $pswd, $ip, $date, $date);
        $stmt->execute();
        header('Location: ../index.php?id=login&re=regsuc');
    } else {
        header('Location: ../index.php?id=register&re=regexi');
    }
    
    $stmt->close();
    //$conn->close();
}
if ($_POST) {
    // collect value of input field

    $name = $_POST['name'];
    $pswd = $_POST['pswd'];
    $pswd2 = $_POST['pswd2'];
    if ($pswd !== $pswd2){
        header('Location: ../index.php?id=register&re=nt');
    } else if (empty($name) or empty($pswd)) {
        header('Location: ../index.php?id=register&re=nt');
    } else if (strlen($pswd) < 4 or strlen($pswd2) < 4 or strlen($name) <= 2){
        header('Location: ../index.php?id=register&re=nt');
    } else if (strlen($name) > 12 or strlen($pswd) > 18){
        header('Location: ../index.php?id=register&re=nt');
    }else {
        database($name, $pswd);
    }
} else {
    header('Location: ../index.php?id=register&re=nt');
}

?>
