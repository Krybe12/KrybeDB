<?php
session_start();
?>
<?php
require '../gameconn/conn.php';

$page = $_SERVER['REQUEST_URI'];
if (!isset($_SESSION["user"]) || $_SESSION["verified"] != 1){
    header("Location: ../index.php?id=login&re=nt&page=$page");
}
/* $stmt = $conn->prepare("SELECT user_id FROM hangman WHERE user_id=? LIMIT 1");
$stmt->bind_param("i", $_SESSION["userid"]);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();

if (!$result){
    $stmt = $conn->prepare("INSERT INTO hangman (user_id) VALUES (?)");
    $stmt->bind_param("i", $_SESSION["userid"]);
    $stmt->execute();
} */
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
</style>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <title>Snake</title>
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
                    <h4 class="m-md-0">Snake</h4>
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
    <div class="m2 text-center bg-secondary p-3">
        <canvas id="canvas" width="460" height="460"><canvas>
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
/* if (!isset($_SESSION["achdone"][14])){ //achievement firt login
    $date = date('j M, Y @ g:ia');
    $sql = "INSERT INTO achcompleted (user_id, ach_id, awarded) VALUES ({$_SESSION['userid']}, 14, '$date')";
    $conn->query($sql);
    $_SESSION["achdone"][14] = 1;
    echo '<script>
    $(document).ready(function(){
        $.get( "../achievements/alert.php", { achid: 14}, function(data){
            $(".alerty").append(data);
        });
    });   
    </script>';
} */
?>
<script>
    var canvas,ctx;
$( document ).ready(function() {
    canvas = document.getElementById("canvas");
    ctx = canvas.getContext("2d");
    draw();
    setInterval(function(){
        snake.move();
    }, 150)


});
class Snake{
    constructor(startY, startX, startDIR, size){
        this.x = startX;
        this.y = startY;
        this.dir = startDIR;
        this.size = size;
        this.dirQue = [];
    }

    move(){
        if (this.dirQue.length > 0){
            let x = this.dirQue.shift();
            if (x == "UP" && this.dir != "DOWN"){
                this.dir = x;
            } else if (x == "LEFT" && this.dir != "RIGHT"){
                this.dir = x;
            } else if (x == "DOWN" && this.dir != "UP"){
                this.dir = x;
            } else if (x == "RIGHT" && this.dir != "LEFT"){
                this.dir = x;
            }
        }

        if (this.dir == "UP"){
            this.y = this.y - 20;
        } else if (this.dir == "LEFT"){
            this.x = this.x - 20;
        } else if (this.dir == "RIGHT"){
            this.x = this.x + 20;
        } else if (this.dir == "DOWN"){
            this.y = this.y + 20;
        }
        draw();
    }
}
var snake = new Snake(200, 200, "UP", 20);
function draw(){
    function drawBackground(){
        ctx.fillStyle = "black";
        ctx.fillRect(0, 0, 460, 460);
    }
    function drawSnake(){
        function drawHead(){
            ctx.fillStyle = "orange";
            ctx.fillRect(snake.x, snake.y, snake.size, snake.size)
        }
        function drawBody(){

        }
        drawHead();
        drawBody();
    }
    function drawUI(){
        ctx.font = "30px Arial";
        ctx.fillStyle = "red";
        ctx.fillText("score: 0", 10, 30)
        ctx.fillText("hahaha", 300, 30)
    }
    drawBackground();
    drawSnake();
    drawUI();
}

document.onkeydown = checkKey;
function checkKey(e) {

    e = e || window.event;
    if (snake.dirQue.length < 2){
        if (e.keyCode == '38') {
            snake.dirQue.push("UP"); // up arrow
        }
        else if (e.keyCode == '40') {
            snake.dirQue.push("DOWN"); // down arrow
        }
        else if (e.keyCode == '37') {
            snake.dirQue.push("LEFT"); // left arrow
        }
        else if (e.keyCode == '39') {
            snake.dirQue.push("RIGHT"); // right arrow
        }
    }
}
</script>