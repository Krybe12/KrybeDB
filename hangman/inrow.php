<?php
session_start();
?>
<?php
require '../gameconn/conn.php';

if ($_SESSION["hang"]["inRowWrong"] >= 5 and !isset($_SESSION["achdone"][16])){
    achiev(16); //achievement 5 wrong in a row trigger
}
if ($_SESSION["hang"]["inRowCorrect"] >= 5 and !isset($_SESSION["achdone"][17])){
    achiev(17); //achievement 5 correct in a row trigger
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

if (!isset($_SESSION["hang"]["inRowCorrect"])){
    $_SESSION["hang"]["inRowCorrect"] = 0;
}
echo $_SESSION["hang"]["inRowCorrect"];