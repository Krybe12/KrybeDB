<?php
session_start();
?>
<?php
require '../gameconn/conn.php';

if (!isset($_SESSION["MatGameInRowCorrect"]) or !isset($_SESSION["MatGameInRowWrong"])){
    $_SESSION["MatGameInRowCorrect"] = 0;
    $_SESSION["MatGameInRowWrong"] = 0;
}


if ($_SESSION["MatGameInRowCorrect"] >= 10 and !isset($_SESSION["achdone"][11])){
    achiev(11); //achievement 10 correct in a row trigger
}
if ($_SESSION["MatGameInRowWrong"] >= 5 and !isset($_SESSION["achdone"][12])){
    achiev(12); //achievement 5 wrong in a row trigger
}
if ($_SESSION["MatGameInRowCorrect"] >= 5 and !isset($_SESSION["achdone"][13])){
    achiev(13); //achievement 5 correct in a row trigger
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


echo $_SESSION["MatGameInRowCorrect"];