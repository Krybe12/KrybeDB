<?php
session_start();
?>
<?php
require 'conne.php';
function check($name, $pswd){
    global $conn;
/*     $sql = "SELECT username, pass FROM users WHERE username='$name' LIMIT 1";
    $result = $conn->query($sql);
    $result = $result->fetch_assoc(); */

    $stmt = $conn->prepare("SELECT username, pass FROM users WHERE username=? LIMIT 1");
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if ($result !== null){
        if ($result["pass"] === $pswd){
            $_SESSION["user"] = $name;
            $_SESSION["verified"] = 1;

            //session setup 

            
            $stmt = $conn->prepare("SELECT id FROM users WHERE username=? LIMIT 1");
            $stmt->bind_param("s", $_SESSION["user"]);
            $stmt->execute();
            $result = $stmt->get_result()->fetch_assoc();
            $_SESSION["userid"] = $result["id"];
            $userid = $_SESSION["userid"];

            $stmt = $conn->prepare("SELECT color,setup FROM usersettings WHERE user_id=? LIMIT 1"); // gets color and setup
            $stmt->bind_param("i", $_SESSION["userid"]);
            $stmt->execute();
            $result = $stmt->get_result()->fetch_assoc();

            $date = date("l jS \of F Y h:i:s A");
            $sql = "UPDATE users SET lastlogin='$date' WHERE id='$userid'"; //logs last login
            $conn->query($sql);

            if (!$result){
                $stmt = $conn->prepare("INSERT INTO usersettings (user_id) VALUES (?)");
                $stmt->bind_param("i", $_SESSION["userid"]);
                $stmt->execute();
                $_SESSION["color"] = "#000000";
                $_SESSION["profilenotset"] = 1;
            } else{
                $_SESSION["color"] = $result["color"];
                if($result["setup"] == 0) {
                    $_SESSION["profilenotset"] = 1;
                } else {
                    $_SESSION["profilenotset"] = 0;
                }
            }
      
            //session setup over

            header('Location: ../index.php?id=verified');
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

