<?php
session_start();
?>
<?php
require '../gameconn/conn.php';

$page = $_SERVER['REQUEST_URI'];
if (!isset($_SESSION["user"]) || $_SESSION["verified"] != 1){
    header("Location: ../index.php?id=login&re=nt&page=$page");
}
$stmt = $conn->prepare("SELECT user_id FROM snake WHERE user_id=? LIMIT 1");
$stmt->bind_param("i", $_SESSION["userid"]);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();

if (!$result){
    $stmt = $conn->prepare("INSERT INTO snake (user_id) VALUES (?)");
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
        <div id="test">
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
var canvas,ctx,snake,fruit;

canvas = document.getElementById("canvas");
ctx = canvas.getContext("2d");
pageNum = 1;
newLeaderBoard()
$.get( "gethighscore.php", function( data ) {
    game.highscore = data;
});
class Game{
    constructor(width, height, fps){
        this.width = width;
        this.height = height;
        this.fps = fps;
        this.highscore = 0;
        this.paused = false;
    }
    startScreen(){
        drawStartScreen();
    }
    start(){
        this.active = true;
        fruit = new Fruit();
        snake = new Snake(Math.floor(Math.random() * 22) * 20, Math.floor(Math.random() * 19) * 20 + 40, "UP", 20);
        fruit.spawn();
        this.started = true;
        this.timer = setInterval(function(){
            if (game.active){
                snake.move();
            }
        }, 1000 / this.fps)
        newLeaderBoard()
    }
    end(){
        if (snake.tailLen > this.highscore){
            $.post("savescore.php", {
                score: snake.tailLen
            }, function(data){
                $("#test").html(data);
            });
            this.highscore = snake.tailLen;
        }
        this.active = false;
        this.started = false;
        this.paused = false;
        //this.printResults();
        clearInterval(this.timer)
        setTimeout(drawEndScreen, 1000 / this.fps)
    }
    pause(){
        if (this.paused == false){
            this.paused = true;
            this.active = false;
            drawPause()
        } else {
            this.paused = false;
            this.active = true;
        }
    }
/*     printResults(){
        console.log(`tailLen: ${snake.tailLen}\ntail.len: ${snake.tail.length}\nnumTurns: ${snake.numTurns}\nnumFruits: ${snake.numFruits}\n----------\nturnsPerFood: ${snake.numTurns / snake.numFruits}`)
    } */
}

class Snake{
    constructor(startY, startX, startDIR, size){
        this.x = startX;
        this.y = startY;
        this.dir = startDIR;
        this.size = size;
        this.dirQue = [];
        this.tailLen = 1;
        this.tail = [];
        this.numTurns = 0;
        this.numFruits = 0;
        this.numDistanceSinceBlink = 0;
        this.n = 20;
    }
    manageTail(){
        this.tail.unshift([this.x, this.y]);
        if (this.tail.length > this.tailLen){
            this.tail.pop();
        }
        if (this.tailLen != this.tail.length){
            this.tailLen = -2;
            this.tail = [];
            this.numFruits = 0;
        }
    }
    manageDir(){
        if (this.dirQue.length > 0){
            this.numTurns++;
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
    }
    checkSideCollision(){
        if (this.x >= 460) this.x = 0;
        else if (this.x < 0) this.x = 440;
        else if (this.y >= 460) this.y = 0;
        else if (this.y < 0) this.y = 440;
    }
    checkFruitCollision(){
        if (this.x == fruit.x && this.y == fruit.y){
            this.tailLen++;
            this.numFruits++;
            fruit.spawn()
        }
    }
    checkSelfCollision(){
        this.tail.forEach(tailPiece => {if(tailPiece[0] == snake.x && tailPiece[1] == snake.y){
            game.end();
        }})
    }
    move(){
        this.numDistanceSinceBlink++;
        if (this.blink){
            this.n = 80;
            this.blink = false;
            this.numDistanceSinceBlink = 0;
        }
        this.manageTail()
        this.manageDir()
        if (this.dir == "UP"){
            this.y = this.y - this.n;
        } else if (this.dir == "LEFT"){
            this.x = this.x - this.n;
        } else if (this.dir == "RIGHT"){
            this.x = this.x + this.n;
        } else if (this.dir == "DOWN"){
            this.y = this.y + this.n;
        }
        this.n = 20;
        this.checkSideCollision()
        this.checkSelfCollision()
        this.checkFruitCollision()
        drawGame();
        if (this.numDistanceSinceBlink > 60){
            drawBlinkReady();
        }
    }
}
class Fruit{
    constructor(){
    }
    spawn(){
        this.x = Math.floor(Math.random() * 22) * 20;
        this.y = (Math.floor(Math.random() * 19) * 20) + 40;
        snake.tail.forEach(tailPiece => {if(tailPiece[0] == this.x && tailPiece[1] == this.y){
            this.spawn();
        }})
        if (snake.x == this.x && snake.y == this.y){
            this.spawn();
        }
    }
}
var game = new Game(460, 460, 8)
game.startScreen();
fruit = new Fruit();
snake = new Snake(200, 200, "UP", 20);

function drawGame(){
    function drawBackground(){
        ctx.fillStyle = "black";
        ctx.fillRect(0, 0, game.width, game.height);
    }
    function drawFruit(){
        ctx.fillStyle = "green";
        ctx.fillRect(fruit.x, fruit.y, snake.size, snake.size);
    }
    function drawSnake(){
        function drawHead(){
            ctx.fillStyle = "orange";
            ctx.fillRect(snake.x, snake.y, snake.size, snake.size)
        }
        function drawBody(){
            ctx.fillStyle = "darkred";
            snake.tail.forEach(tailPiece => ctx.fillRect(tailPiece[0], tailPiece[1], snake.size, snake.size));
        }
        drawBody();
        drawHead();
    }
    function drawUI(){
        ctx.font = "30px Arial";
        ctx.fillStyle = "red";
        ctx.fillText(`length: ${snake.tailLen}`, 10, 30)
        ctx.fillText(`highscore: ${game.highscore}`, game.width - ctx.measureText(`highscore: ${game.highscore}`).width - 10, 30)
    }
    drawBackground();
    drawFruit();
    drawSnake();
    drawUI();
}
function drawStartScreen(){ //tohle je potřeba přepsat xd
    ctx.fillStyle = "black";
    ctx.fillRect(0, 0, game.width, game.height);
    ctx.fillStyle = "green";
    ctx.fillRect(game.width / 2  - game.width / 4, game.height / 2 - game.height / 4, game.width / 2, game.height / 3);
    ctx.font = "30px Arial";
    ctx.fillStyle = "yellow";
    ctx.fillText("Press any key", game.width / 2  - game.width / 4 + 23, game.height / 2 - game.height / 4 + 30)
    ctx.fillText("or click here", game.width / 2  - game.width / 4 + 35, game.height / 2 - game.height / 4 + 60)
    ctx.fillText("to start", game.width / 2  - game.width / 4 + 65, game.height / 2 - game.height / 4 + 90)
    drawGuide()
}
function drawEndScreen(){ // a tohle taky
    ctx.fillStyle = "red";
    ctx.fillRect(game.width / 2  - game.width / 4, game.height / 2 - game.height / 4, game.width / 2, game.height / 3);
    ctx.font = "30px Arial";
    ctx.fillStyle = "yellow";
    ctx.fillText("You lost", game.width / 2  - game.width / 4 + 35, game.height / 2 - game.height / 4 + 30)
    ctx.fillText("press any key", game.width / 2  - game.width / 4 + 30, game.height / 2 - game.height / 4 + 60)
    ctx.fillText("or click here", game.width / 2  - game.width / 4 + 30, game.height / 2 - game.height / 4 + 90)
    ctx.fillText("to start again", game.width / 2  - game.width / 4 + 30, game.height / 2 - game.height / 4 + 120)
    drawGuide()
}
function drawGuide(){
    ctx.font = "30px Arial";
    ctx.fillStyle = "red";
    ctx.fillText("Arrow Keys - Movement", 100, 300)
    ctx.fillText("P - Pause", 100, 330)
    ctx.fillText("Space - Blink", 100, 360)
}
function drawPause(){
    ctx.font = "35px Arial";
    ctx.fillStyle = "red";
    ctx.fillText("Paused", game.width / 2 - ctx.measureText(`Paused`).width / 2, game.height / 2 - 35 / 2)
}
function drawBlinkReady(){
    ctx.font = "15px Arial";
    ctx.fillStyle = "yellow";
    ctx.fillText("Blink Ready", game.width / 2 - ctx.measureText(`Blink Ready`).width / 2, game.height - 10)
}
canvas.addEventListener('click', startGame);
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
    if (game.started == true){
        if (e.keyCode == 80){
            game.pause()
        } else if (e.keyCode == 32){
            if (snake.numDistanceSinceBlink > 60){
                snake.blink = true;
            }  
        }
    } else {
        startGame();
    }
}
function startGame(){
    if (!game.active && game.paused != true){
        game.start();
    }
}
function newLeaderBoard(){
    if (pageNum < 1) {
        pageNum = 1;
    } else {
        $("#leaderBoard").load(`../leaderboard/lb.php?page=${pageNum}&game=3`);
    }
}
</script>