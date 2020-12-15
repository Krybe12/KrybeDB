<?php
session_start();
?>
<?php
require 'conne.php';
function check($name, $pswd){
    global $conn;

    $stmt = $conn->prepare("SELECT username, pass FROM users WHERE username=? LIMIT 1");
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if ($result !== null){
        if ($result["pass"] === $pswd){
            $_SESSION["user"] = $name;
            $_SESSION["verified"] = 1;
            header("Location: sessionsetup.php");
        } else {
            header('Location: ../index.php?id=login&re=wp');
        }
    } else {
        header('Location: ../index.php?id=login&re=noexist');
    }
}

if ($_POST) {
    $name = $_POST['name'];
    $pswd = $_POST['pswd'];
    if (empty($name) or empty($pswd)) {
        header('Location: ../index.php?id=login&re=nt');
    } else {
        check($name, $pswd);
    }
} else {
    header('Location: ../index.php?id=login&re=nt');
}
?>

