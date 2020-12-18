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
@media (min-width:860px){
    .grid {
    display: grid;
    height: 100%;
    text-align: center;

    grid-template-rows: 1fr 3fr 1fr;
    grid-template-columns: 1fr 3fr 1fr;
    grid-template-areas: 
    "t1 t2 t3"
    "m1 m2 m3"
    "b1 b2 b3";
    }
}
@media (max-width: 860px){
    .grid {
    display: grid;
    text-align: center;

    grid-template-rows: 0.25fr 1fr 1fr 0.1fr 0.25fr;
    grid-template-columns: 1fr 1fr;
    grid-template-areas: 
    "t2 t2"
    "m2 m2"
    "m1 b3"
    "t3 b2"
    "t1 t1"
    "m3 b1";
}
}

.t1{
    grid-area: t1;
}
.t2{
    grid-area: t2;
}
.t3{
    grid-area: t3;
}
.m1{
    grid-area: m1;
}
.m2{
    grid-area: m2;
}
.m3{
    grid-area: m3;
}
.b1{
    grid-area: b1;
}
.b2{
    grid-area: b2;
}
.b3{
    grid-area: b3;
}
.i{
    width: 5vw;
    height: 10vh;
}
.section {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-wrap: wrap;
}
.box{
    text-align: center;
    font-size: 2vh;
}
.logout{
    font-size: 6vh;
}
.top {
    display: flex;
    justify-content: center;
    align-items: top;
    flex-wrap: wrap;
}
.mid {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-wrap: wrap;
}
.tl {
    display: flex;
    justify-content: top;
    align-items: top;
    flex-wrap: wrap;
}
h1, .h1 {
  font-size: 2.8em !important;
}
h3, .h3 {
    font-size: 2.8em !important;
}
h5, .h5 {
    font-size: 2.8em !important;
}

h6, .h6 {
  font-size: 0.1px !important;
}
.beta {
  color: black;
  background-color: steelblue;
}
p {
  display: inline-block;
}
.alerty {
    position: absolute;
    right: 10;
    bottom: 10;
}
.ach{
    overflow-y: auto;
    max-height: 52.5vh;
    
}
</style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <title>Matematická hra</title>
</head>
<body>
    <div class="grid bg-secondary">
        <div class="t1 section">
        <h1>logged in <br><?php $user = $_SESSION["user"]; $color = $_SESSION["color"]; echo "<p style='color: $color;'>$user</p><p>, bitch</p>" ?></h1>
        </div>
        <div class="t2 section">
            <div>
                <h1>Matematická hra!</h1>           
            </div>
        </div>
        <div class="t3 section">

            <div class="btn-group">
                <button type="button" class="btn btn-danger dropdown-toggle btn-lg" data-bs-toggle="dropdown" aria-expanded="false" >
                    <?php echo $_SESSION["user"]?>
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="../profile">Profile</a></li>
                    <li><a class="dropdown-item" href="..">HUB</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="../login/logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
        <div class="m1 bg-info">
            <div><h1>Leaderboard</h1></div>
            <div class="leader mid"></div>
        </div>
        <div class="m2 bg-warning">
            <div class="area">
                <div class="top">
                </div>
                <div class="mid">
                    <input type="number" class="box" id="inpt">
                    <button id="btnsend">Odeslat</button>
                </div>
                <div class="tl">
                    <h2 id="score">Session Score: 0</h2>
                </div>
                <div class="tl">
                    <h2 id="totalscore">Total Score: 0</h2>
                </div>
                <div>
                    <h1 id="cAwnser"></h1>
                </div>
                
            </div>
        </div>
        <div class="m3 bg-info">
            <div><h1>Achievments</h1></div>
            <div class="achievments ach"></div>
        </div>
        <div class="b1 section bg-success">

        </div>
        <div class="b2 section">

        </div>
        <div class="b3 section bg-success">
        </div>
    </div>
<div class="alerty">

</div>

</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<?php
if (!isset($_SESSION["achdone"][2])){ //achievement firt login
    $date = date('j M, Y @ g:ia');
    $sql = "INSERT INTO achcompleted (user_id, ach_id, awarded) VALUES ({$_SESSION['userid']}, 2, '$date')";
    $conn->query($sql);
    $_SESSION["achdone"][2] = 1;
    echo '<script>
    $(document).ready(function(){
        $.get( "../achievements/load.php", { achid: 2}, function(data){
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
    odp = $("input").val();
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
    $(".top").load("new.php")
}
function awnsered(data){
    if (data == 1) {$(".area").addClass("bg-success"); body++;}
    else {$(".area").addClass("bg-danger"); body--;}
    $("#inpt").focus();
    $("input").val("");
    setTimeout(reset, 1000);
    newNums();
    newLeaderBoard();
    newAchievements();
}
function reset(){
    $(".area").removeClass("bg-danger bg-success")
    $("#score").text(`Session Score: ${body}`)
    setTimeout(function(){ $("#cAwnser").text("");}, 800);
}
function newAchievements(){
    $(".achievments").load("../achievements/stats.php?category=" + 2);
}
function newLeaderBoard(){
    if (pageNum < 1) {
        pageNum = 1;
    } else {
        $(".leader").load("highscore.php?page=" + pageNum + "&height=" + $(document).height())
        $("#totalscore").load("gettotal.php")
    }

}
</script>
</html>