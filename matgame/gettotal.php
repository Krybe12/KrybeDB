<?php
session_start();
?>
<?php
require '../gameconn/conn.php';
$userid = $_SESSION["userid"];
if (isset($_SESSION["mats"])){
    echo "Total Score: " . $_SESSION["mats"];
} else {
    $sql = "SELECT score FROM matgame WHERE user_id='$userid' LIMIT 1";
    $result = $conn->query($sql);
    $result = $result->fetch_assoc();
    $_SESSION["mats"] = $result["score"];
    echo "Total Score: " . $_SESSION["mats"];
}
if ($_SESSION["mats"] > 0 and !isset($_SESSION["achdone"][3])){
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

function achiev($achid){
    global $conn;      
    $sql = "INSERT INTO achcompleted (user_id, ach_id) VALUES ({$_SESSION['userid']}, $achid)";
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