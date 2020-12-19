<?php
session_start();
?>
<?php
require '../gameconn/conn.php';

$userid = $_SESSION["userid"];
if (isset($_SESSION["mats"])){
    send();
} else {
    $sql = "SELECT score FROM matgame WHERE user_id='$userid' LIMIT 1";
    $result = $conn->query($sql);
    $result = $result->fetch_assoc();
    $_SESSION["mats"] = $result["score"];
    send();
}
function send(){
    echo $_SESSION["mats"];
}
function checkAchs(){
    if ($_SESSION["mats"] != 0 and !isset($_SESSION["achdone"][3])){
        achiev(3); //achievement first priklad trigger
    }
    if ($_SESSION["mats"] >= 10 and !isset($_SESSION["achdone"][4])){
        achiev(4); //achievement 10 vyocitanejch trigger
    }
    if ($_SESSION["mats"] >= 50 and !isset($_SESSION["achdone"][5])){
        achiev(5); //achievement 50 vyocitanejch trigger
    }
    if ($_SESSION["mats"] >= 100 and !isset($_SESSION["achdone"][6])){
        achiev(6); //achievement 100 vyocitanejch trigger
    }
    if ($_SESSION["mats"] >= 250 and !isset($_SESSION["achdone"][7])){
        achiev(7); //achievement 250 vyocitanejch trigger
    }
    if ($_SESSION["mats"] >= 500 and !isset($_SESSION["achdone"][8])){
        achiev(8); //achievement 500 vyocitanejch trigger
    }
    if ($_SESSION["mats"] >= 1000 and !isset($_SESSION["achdone"][9])){
        achiev(9); //achievement 1000 vyocitanejch trigger
    }
    if ($_SESSION["mats"] >= 5000 and !isset($_SESSION["achdone"][10])){
        achiev(10); //achievement 5000 vyocitanejch trigger
    }
    if ($_SESSION["mats"] >= 10000 and !isset($_SESSION["achdone"][11])){
        achiev(11); //achievement 10000 vyocitanejch trigger
    }
}


function achiev($achid){
    global $conn;      
    $date = date('j M, Y @ g:ia');
    $sql = "INSERT INTO achcompleted (user_id, ach_id, awarded) VALUES ({$_SESSION['userid']}, $achid, '$date')";
    $conn->query($sql);
    $_SESSION["achdone"][$achid] = 1;
    echo '<script>
    $(document).ready(function(){
        $.get( "../achievements/load.php", { achid:' . $achid . '}, function(data){
            $(".alerty").append(data);
        });
    });   
    </script>';
}
?>