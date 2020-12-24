<?php
session_start();
?>
<?php
require '../gameconn/conn.php';

$userid = $_SESSION["userid"];
if (isset($_SESSION["hang"]["totalScore"])){
    send();
} else {
    $sql = "SELECT score FROM hangman WHERE user_id='$userid' LIMIT 1";
    $result = $conn->query($sql);
    $result = $result->fetch_assoc();
    $_SESSION["hang"]["totalScore"] = $result["score"];
    send();
}
function send(){
    echo $_SESSION["hang"]["totalScore"];
}

if ($_SESSION["hang"]["totalScore"] != 0 and !isset($_SESSION["achdone"][15])){
    achiev(15); //achievement first word trigger
}


function achiev($achid){
    global $conn;      
    $date = date('j M, Y @ g:ia');
    $sql = "INSERT INTO achcompleted (user_id, ach_id, awarded) VALUES ({$_SESSION['userid']}, $achid, '$date')";
    $conn->query($sql);
    $_SESSION["achdone"][$achid] = 1;
    echo '<script>
    $(document).ready(function(){
        $.get( "../achievements/alert.php", { achid:' . $achid . '}, function(data){
            $(".alerty").append(data);
        });
    });   
    </script>';
}
?>