<?php
session_start();
?>
<?php
require '../gameconn/conn.php';

$page = $_SERVER['REQUEST_URI'];
if (!isset($_SESSION["user"]) || $_SESSION["verified"] != 1){
    header("Location: ../index.php?id=login&re=nt&page=$page");
}
/* $stmt = $conn->prepare("SELECT user_id FROM snake WHERE user_id=? LIMIT 1");
$stmt->bind_param("i", $_SESSION["userid"]);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();

if (!$result){
    $stmt = $conn->prepare("INSERT INTO snake (user_id) VALUES (?)");
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
    <title>Tetris</title>
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
                    <h4 class="m-md-0">Tetris</h4>
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
        <canvas id="canvas" width="300" height="500"><canvas>
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
var canvas,ctx;

canvas = document.getElementById("canvas");
ctx = canvas.getContext("2d");

class Game{
    constructor(width, height, fps, size){
        this.width = width;
        this.height = height;
        this.fps = 1000 / fps;
        this.started = false;
        this.size = size;
    }
    addEventListener(){
        //canvas.addEventListener('click', startGame);
        document.onkeydown = this.key;
    }
    key(e){
        game.checkKey(e)
    }
    start(){
        console.log("start")
        if (!this.started){
            this.started = true;
            this.timer = setInterval(function(){
                block.moveDown();
                //block.move()
            }, this.fps)
        }
    }
    checkKey(e){
        if (this.started){
            //console.log(e.keyCode)
            if (e.keyCode == '38') { // up arrow
                block.rotate();
            }
            else if (e.keyCode == '40') { // down arrow
                console.log("DOWN"); 
            }
            else if (e.keyCode == '37') { // left arrow
                block.moveSide("LEFT");
            }
            else if (e.keyCode == '39') { // right arrow
                block.moveSide("RIGHT");
            }
        } else {
            this.start()
        }
    }
}
class Block{
    constructor(startX, startY){
        this.x = startX;
        this.y = startY;
        this.blocks = [[0,0], [-1,0], [1,1], [-2,0], [-3,1], [-1,-1], [-1,-2], [-1,-3]];
        this.color = "blue";
        this.realBlocks = [];
        this.allowedMove = true;
    }
    init(){
        this.blocks.forEach(function(item){
            block.realBlocks.push([block.x + item[0] * game.size, block.y + item[1] * game.size]);
        });
    }
    moveSide(n){
        this.allowedMove = true;
        if (n == "LEFT"){
            for (let i = 0; i < this.realBlocks.length; i++){
                if (this.realBlocks[i][0] - game.size < 0){
                    this.allowedMove = false;
                }
            }
            if (this.allowedMove){
                this.realBlocks.forEach(block => block[0] = block[0] - game.size);
                this.x = this.x - game.size;
            }
          
        } else if (n == "RIGHT"){
            for (let i = 0; i < this.realBlocks.length; i++){
                if (this.realBlocks[i][0] + game.size >= game.width){
                    this.allowedMove = false;
                }
            }
            if (this.allowedMove){
                this.realBlocks.forEach(block => block[0] = block[0] + game.size);
                this.x = this.x + game.size;
            }
        }
        draw();
    }
    moveDown(){
        draw();
    }
    rotate(){

    }
}
var game = new Game(300, 500, 2, 20);
drawStartScreen();
game.addEventListener();

var block = new Block(140, 220);
block.init();

function draw(){
    function drawBackground(){
        ctx.fillStyle = "black";
        ctx.fillRect(0, 0, game.width, game.height);
    }
    function drawBlock(){
        ctx.fillStyle = block.color;
        block.realBlocks.forEach(function(item){
            ctx.fillRect(item[0], item[1], game.size, game.size);
        });
    }
    drawBackground();
    drawBlock();
}
function drawStartScreen(){ //tohle je potřeba přepsat xd
    ctx.fillStyle = "black";
    ctx.fillRect(0, 0, game.width, game.height);
    ctx.fillStyle = "green";
    ctx.fillRect(game.width / 10, game.height / 4, game.width - game.width / 5, 100);
    ctx.font = "30px Arial";
    ctx.fillStyle = "yellow";
    ctx.fillText("Press any key", game.width / 2  - ctx.measureText(`Press any key`).width / 2, game.height / 2 - game.height / 4 + 30)
    ctx.fillText("or click here", game.width / 2  - ctx.measureText(`or click here`).width / 2, game.height / 2 - game.height / 4 + 60)
    ctx.fillText("to start", game.width / 2  - ctx.measureText(`to start`).width / 2, game.height / 2 - game.height / 4 + 90)
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
</script>