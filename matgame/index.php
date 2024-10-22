<?php
session_start();
?>
<?php
require '../gameconn/conn.php';

$page = $_SERVER['REQUEST_URI'];
if (!isset($_SESSION["user"]) || $_SESSION["verified"] != 1){
    header("Location: ../index.php?id=login&re=nt&page=$page");
}
$stmt = $conn->prepare("SELECT user_id FROM matgame WHERE user_id=? LIMIT 1");
$stmt->bind_param("i", $_SESSION["userid"]);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();

if (!$result){
    $stmt = $conn->prepare("INSERT INTO matgame (user_id) VALUES (?)");
    $stmt->bind_param("i", $_SESSION["userid"]);
    $stmt->execute();
}
?>
<style>
@media (min-width:768px){
    .grid {
    display: grid;
    height: 100%;

    grid-template-rows: 0.1fr 1.1fr;
    grid-template-columns: 1fr 2.8fr 1fr;
    grid-template-areas: 
    "t t t"
    "m1 m2 m3";
    }
}
@media (max-width: 768px){
    .grid {
    display: grid;
    grid-template-rows: repeat(auto-fill, minmax(140px,1fr));
    grid-template-columns: 1fr;
    grid-template-areas: 
    "t"
    "m2"
    "m1"
    "m3";
    }
    .m1{
        grid-area: m1;
        border-bottom: 4px solid #ffc107;
    }
    .m2{
        grid-area: m2;
        border-bottom: 4px solid #ffc107;
    }
    .m3{
        grid-area: m3;
        overflow-y: auto;
        max-height: 50vh;
    }
}

.t{
    grid-area: t;
    border-bottom: 4px solid #ffc107;
}
.m1{
    grid-area: m1;
}
.m2{
    grid-area: m2;
}
.m3{
    grid-area: m3;
    overflow-y: auto;
}
.alerty {
    position: absolute;
    right: 10;
    bottom: 10;
}
h6, .h6 {
  font-size: 0.1px !important;
}
h2, .h2 {
  font-size: 34px !important;
}
h3, .h3 {
  font-size: 34px !important;
}
</style>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <title>Math game</title>
</head>
<body>
<div class="grid">
    <div class="t bg-dark text-light d-flex flex-column flex-md-row justify-content-between align-items-center">
        <div class="container-fluid bg-dark text-light p-3 flex-shrink-1">
            <div class="row align-items-center">
                <div class="col-md d-flex justify-content-center justify-content-md-start">
                    <h5 class="m-md-0">Logged in as <?php echo "<h5 class='mx-2' style='color: {$_SESSION['color']}'>{$_SESSION['user']}</h5>"?></h5>
                </div>
                <div class="col-md d-flex justify-content-center">
                    <h4 class="m-md-0">Math Game</h4>
                </div>
                <div style="white-space: nowrap;" class="col-md d-flex justify-content-center justify-content-md-end">
                    <a href="../profile" class="btn btn-primary mx-2">Profile</a>
                    <a href=".." class="btn btn-primary mx-2">Back to hub</a>
                    <a href="../login/logout.php" class="btn btn-danger mx-2">Logout</a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="m1 bg-dark text-center text-light p-2 p-md-3">
        <div class="">
            <h4>Leaderboard</h4>
        </div>
        <hr>
        <div id="leaderBoard">

        </div>
        
    </div>
    <div class="m2 text-center bg-secondary p-3 p-md-5">
        <div id="wrap" class="">
            <div class="rounded bg-dark text-light d-inline-block p-3 mb-4">
                <div id="priklad" class="d-flex justify-content-center m-0">
                    
                </div>
                <hr>
                <input type="number" id="inpt" class="form-control text-center">
                <input type="button" id="btnsend" class="form-control btn bg-success text-light mt-1" value="Odeslat">
            </div>
            <hr class="bg-light">
            <div class="row mt-4 text-white">
                <div class="col">
                    <h5>Session Score:</h5>
                    <p id="score" class="lead m-0">0</p>
                </div>
                <div class="col">
                    <h5>In Row Correct:</h5>
                    <p id="inRowNum" class="lead m-0"></p>
                </div>
                <div class="col">
                    <h5>Total Score:</h5>
                    <p id="totalScoreNum" class="lead m-0"></p>
                </div>
            </div>
            <div class="pt-1 pt-md-4 text-light">
                <h1 id="cAwnser"></h1>
            </div>
        </div>

    </div>
    <div class="m3 bg-dark text-light text-center p-md-3 pt-md-0">
        <div style="position: sticky;top: 0;z-index: 2;" class="bg-dark py-md-3">
            <h4>Achievements</h4>
            <hr class="mb-0">
        </div>
        
        <div id="ach">

        </div>
    </div>
</div>
<div class="alerty">
</div>

</body>
</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<?php
if (!isset($_SESSION["achdone"][2])){ //achievement firt login
    $date = date('j M, Y @ g:ia');
    $sql = "INSERT INTO achcompleted (user_id, ach_id, awarded) VALUES ({$_SESSION['userid']}, 2, '$date')";
    $conn->query($sql);
    $_SESSION["achdone"][2] = 1;
    echo '<script>
    $(document).ready(function(){
        $.get( "../achievements/alert.php", { achid: 2}, function(data){
            $(".alerty").append(data);
        });
    });   
    </script>';
}
?>
<script>
let odp;
let body = 0;
let pageNum = 1;
$( document ).ready(function() {
    newNums();
    newLeaderBoard();
    newAchievements()
});
$("#btnsend").click(function() {
    sendResult();
});
$(document).keyup(function(){
    if (event.key == "Enter"){
        $("#btnsend").click();
    }
});
function sendResult() {
    odp = $("#inpt").val();
    if (odp == "") return;
    $.post("compare.php", {
        awnsered: odp
    }, function(data){
        $("#cAwnser").text(data)
        if (data[0] == "C") awnsered(1);
        else awnsered(0);

    });
}
function newNums(){
    $("#priklad").load("new.php")
}
function awnsered(data){
    if (data == 1) {$("#wrap").addClass("bg-success"); body++;}
    else {$("#wrap").addClass("bg-danger"); body--;}
    $("#inpt").focus();
    $("#inpt").val("");
    setTimeout(reset, 1000);
    newNums();
    newLeaderBoard();
    newAchievements();
}
function reset(){
    $("#wrap").removeClass("bg-danger bg-success");
    $("#score").text(body);
    setTimeout(function(){ $("#cAwnser").text("");}, 400);
}
function newAchievements(){
    $("#ach").load("../achievements/stats.php?category=" + 2);
}
function newLeaderBoard(){
    if (pageNum < 1) {
        pageNum = 1;
    } else {
        $("#leaderBoard").load(`../leaderboard/lb.php?page=${pageNum}&game=1`);
        $("#totalScoreNum").load("gettotal.php");
        $("#inRowNum").load("inrow.php");
    }
}
</script>