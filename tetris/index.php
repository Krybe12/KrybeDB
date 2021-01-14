<?php
session_start();
?>
<?php
require '../gameconn/conn.php';

$page = $_SERVER['REQUEST_URI'];
if (!isset($_SESSION["user"]) || $_SESSION["verified"] != 1){
    header("Location: ../index.php?id=login&re=nt&page=$page");
}
$stmt = $conn->prepare("SELECT user_id FROM tetris WHERE user_id=? LIMIT 1");
$stmt->bind_param("i", $_SESSION["userid"]);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();

if (!$result){
    $stmt = $conn->prepare("INSERT INTO tetris (user_id) VALUES (?)");
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
var canvas,ctx,block,afk,ghost;

canvas = document.getElementById("canvas");
ctx = canvas.getContext("2d");
pageNum = 1;
newLeaderBoard()
$.get( "gethighscore.php", function( data ) {
    game.highscore = data;
});
class Game{
    constructor(width, height, fps, size){
        this.width = width;
        this.height = height;
        this.fps = 1000 / fps;
        this.started = false;
        this.size = size;
        this.paused = false;
        this.highscore = 0;
        this.score = 0;
        this.objects = [[[0,0],[1,0],[-1,0], [0,-1]], [[0,0],[-1,0],[-2,0],[1,0]], [[0,0],[-1,0],[1,0],[-1,-1]], [[0,0],[-1,0],[1,0],[1,-1]], [[0,0],[1,0],[1,-1],[0,-1]], [[0,0],[-1,0],[0,-1],[1,-1]], [[0,0],[1,0],[0,-1],[-1,-1]]];
        this.colors = ["purple", "blue", "darkblue", "orange", "yellow", "green", "red"];
        this.x = Math.floor(Math.random() * this.objects.length);
    }
    addEventListener(){
        //canvas.addEventListener('click', startGame);
        document.onkeydown = this.key;
    }
    key(e){
        game.checkKey(e)
    }
    start(){
        if (!this.started){
            newLeaderBoard();
            this.newGame();
            this.started = true;
            this.timer = setInterval(function(){
                if (!game.paused){
                    block.moveDown();
                    afk.manage();
                }
            }, this.fps)
        }
    }
    checkKey(e){
        if (e.keyCode == "80" && this.started){ // P
            this.pause();
        }
        if (this.started && !this.paused){
            //console.log(e.keyCode)
            if (e.keyCode == '38') { // up arrow
                block.rotate();
            }
            else if (e.keyCode == '40') { // down arrow
                block.drop(); 
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
    pause(){
        if (this.paused){
            this.paused = false;
        } else {
            this.paused = true;
            drawPause()
        }
    }
    newBlock(){
        block = new Block(100, 25, this.objects[this.x], this.colors[this.x]);
        block.init();
        ghost.spawn();
        this.x = Math.floor(Math.random() * this.objects.length);
    }
    newGame(){
        afk = new Afk();
        this.newBlock();
        this.score = 0;
    }
    endGame(){
        this.paused = false;
        this.started = false;
        if (this.score > this.highscore){
            $.post("savescore.php", {
                score: game.score
            }, function(data){
            });
            this.highscore = this.score;
        }
        clearInterval(this.timer);
        drawEndScreen();
        newLeaderBoard();
    }
}

class Block{
    constructor(startX, startY, blocks, color){
        this.x = startX;
        this.y = startY;
        this.blocks = blocks;
        this.color = color;
        this.realBlocks = [];
        this.allowedSideMove = true;
        this.allowedDownMove = true;
        this.turnHelp = [];
        this.lastBlocks = [];
        this.lastRealBlocks = [];
    }
    init(){
        this.realBlocks = [];
        this.turnHelp = [];
        this.blocks.forEach(function(item){
            block.realBlocks.push([block.x + item[0] * game.size, block.y + item[1] * game.size]);
        });
        for (let i = 0; i < this.realBlocks.length; i++){
            if (this.realBlocks[i][0] < 0 || this.realBlocks[i][0] >= game.width || this.realBlocks[i][1] >= game.height){
                this.realBlocks = this.lastRealBlocks;
                this.blocks = this.lastBlocks;
                break;
            }
            for (let m = 0; m < afk.realBlocks.length; m++){
                if (this.realBlocks[i][0] == afk.realBlocks[m][0] && this.realBlocks[i][1] == afk.realBlocks[m][1]){
                    this.realBlocks = this.lastRealBlocks;
                    this.blocks = this.lastBlocks;
                    break;
                }
            }
        }
    }
    rotate(){ // 90° do prava
        let x,y;
        this.lastBlocks = this.blocks;
        this.lastRealBlocks = this.realBlocks;

        this.turnHelp.push([0,0])
        for (let i = 0; i < this.blocks.length; i++){//0 = x ; 1 = y
            if (this.blocks[i][0] <= 0 && this.blocks[i][1] < 0){ //1
                x = this.blocks[i][0];
                y = this.blocks[i][1];
                if (y != 0){
                    y = y *(-1);
                }
                this.turnHelp.push([y,x])
            }
            if (this.blocks[i][0] < 0 && this.blocks[i][1] >= 0){ //2
                x = this.blocks[i][0];
                y = this.blocks[i][1];
                if (y != 0){
                    y = y *(-1);
                }
                this.turnHelp.push([y,x])
            }
            if (this.blocks[i][0] > 0 && this.blocks[i][1] <= 0){ //3
                x = this.blocks[i][0];
                y = this.blocks[i][1];
                if (x != 0){
                    x = x * 1;
                }
                if (y != 0){
                    y = y *(-1);
                }
                this.turnHelp.push([y,x])
            }
            if (this.blocks[i][0] >= 0 && this.blocks[i][1] > 0){ //4
                x = this.blocks[i][0];
                y = this.blocks[i][1];
                if (y != 0){
                    y = y *(-1);
                }
                this.turnHelp.push([y,x])
            }
        }
        this.blocks = this.turnHelp;
        this.init();
        ghost.spawn();
        draw();
    }
    moveSide(n){
        this.allowedSideMove = true;
        if (n == "LEFT"){
            for (let i = 0; i < this.realBlocks.length; i++){
                for (let m = 0; m < afk.realBlocks.length; m++){
                    if (!this.allowedSideMove) break;
                    if (this.realBlocks[i][1] == afk.realBlocks[m][1] && this.realBlocks[i][0] - game.size == afk.realBlocks[m][0]){
                        this.allowedSideMove = false;
                        break;
                    }
                }
                if (this.realBlocks[i][0] - game.size < 0){
                    this.allowedSideMove = false;
                }
            }
            
            if (this.allowedSideMove){
                this.realBlocks.forEach(block => block[0] = block[0] - game.size);
                this.x = this.x - game.size;
            }
          
        } else if (n == "RIGHT"){
            for (let i = 0; i < this.realBlocks.length; i++){
                for (let m = 0; m < afk.realBlocks.length; m++){
                    if (!this.allowedSideMove) break;
                    if (this.realBlocks[i][1] == afk.realBlocks[m][1] && this.realBlocks[i][0] + game.size == afk.realBlocks[m][0]){
                        this.allowedSideMove = false;
                        break;
                    }
                }
                if (this.realBlocks[i][0] + game.size >= game.width){
                    this.allowedSideMove = false;
                }
            }
            if (this.allowedSideMove){
                this.realBlocks.forEach(block => block[0] = block[0] + game.size);
                this.x = this.x + game.size;
            }
        }
        ghost.spawn();
        draw();
    }
    drop(){
        this.realBlocks = ghost.arr;
        this.moveDown();
    }
    moveDown(){
        this.allowedDownMove = true;
        this.dieNext = false;
        for (let i = 0; i < this.realBlocks.length; i++){
            for (let m = 0; m < afk.realBlocks.length; m++){
                if (!this.allowedDownMove) break;
                if (this.realBlocks[i][0] == afk.realBlocks[m][0] && this.realBlocks[i][1] + game.size == afk.realBlocks[m][1]){
                    this.allowedDownMove = false;
                    this.dieNext = true;
                    break;
                }
            }
            if (this.realBlocks[i][1] + game.size >= game.height){
                this.allowedDownMove = false;
                this.dieNext = true;
            }
        }
        if (this.dieNext){
            this.die();
        }
        if (this.allowedDownMove){
            this.realBlocks.forEach(block => block[1] = block[1] + game.size);
            this.y = this.y + game.size; 
        }
        draw();
    }
    die(){
        for (let i = 0; i < this.realBlocks.length; i++){
            afk.realBlocks.push([this.realBlocks[i][0], this.realBlocks[i][1], this.color]);
        }
        game.newBlock();
    }
}
class Ghost{
    constructor(){
        this.arr = [];
        this.allowedDownMove = true;
        this.count = 0;
    }
    spawn(){
        this.allowedDownMove = true;
        this.arr = [];
        for (let i = 0; i < block.realBlocks.length; i++){
            this.arr.push([block.realBlocks[i][0],block.realBlocks[i][1]]);
        }
        this.count = 0;
        while (this.allowedDownMove){
            this.down();
            this.count++;
            if (this.count > 30){
                this.allowedDownMove = false;
                break;
            }
        }
    }
    down(){
        this.allowedDownMove = true;
        for (let i = 0; i < this.arr.length; i++){
            for (let m = 0; m < afk.realBlocks.length; m++){
                if (!this.allowedDownMove) break;
                if (this.arr[i][0] == afk.realBlocks[m][0] && this.arr[i][1] + game.size == afk.realBlocks[m][1]){
                    this.allowedDownMove = false;
                    break;
                }
            }
            if (this.arr[i][1] + game.size >= game.height){
                this.allowedDownMove = false;
            }
        }
        if (this.allowedDownMove){
            this.arr.forEach(block => block[1] = block[1] + game.size);
        }
    }
}
class Afk{
    constructor(){
        this.realBlocks = [];
        this.x = 0;
        this.coords = [];
        this.cleared = [];
        this.num = 0;
    }
    checkLost(){
        for (let i = 0; i < this.realBlocks.length; i++){
            if (this.realBlocks[i][1] <= 60){
                game.endGame();
                break;
            }
        }
    }
    checkLine(){
        this.coords = [];
        this.cleared = [];
        this.num = 0;
        for (let i = 0; i < this.realBlocks.length; i++){
            if (!this.coords.includes(this.realBlocks[i][1])){
                this.coords.push(this.realBlocks[i][1]);
            }
        }
        for (let k = 0; k < this.coords.length; k++){
            this.num = 0;
            for (let m = 0; m < this.realBlocks.length; m++){
                if (this.realBlocks[m][1] == this.coords[k]){
                    this.num++;
                }
                if (this.num == game.width / game.size){
                    if (!this.cleared.includes(this.coords[k])){
                        this.cleared.push(this.coords[k]);
                    }
                }
            }
        }
        if (this.cleared.length > 0){
            this.clearLines();
        }
    }
    clearLines(){
        if (this.cleared.length > 1){
            game.score += this.cleared.length * (Math.floor(this.cleared.length / 2) + 1);
        } else {
            game.score++;
        }
        this.cleared = this.cleared.sort()
        for (let i = 0; i < this.realBlocks.length; i++){
            for (let b = 0; b < this.realBlocks.length; b++){
                if (this.realBlocks[b][1] == this.cleared[i]){
                    this.realBlocks.splice(b, 1)
                    b = b - 1;
                }
            }
            for (let h = 0; h < this.realBlocks.length; h++){
                if (this.realBlocks[h][1] < this.cleared[i]){
                    this.realBlocks[h][1] += game.size;
                }
            }
        }
    }
    manage(){
        if (this.x != this.realBlocks.length){
            this.checkLost();
            this.checkLine();
            this.x = this.realBlocks.length;
        }
        
    }
}
var game = new Game(300, 500, 2, 25);
drawStartScreen();
game.addEventListener();
ghost = new Ghost();
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
    function drawAfk(){
        afk.realBlocks.forEach(function(item){
            ctx.fillStyle = item[2];
            ctx.fillRect(item[0], item[1], game.size, game.size);
        });
    }
    function drawGhost(){
        ghost.arr.forEach(function(item){
            ctx.fillStyle = "white";
            ctx.fillRect(item[0], item[1], game.size, game.size);
        });
    }
    function drawUI(){
        function bg(){
            ctx.fillStyle = "#00001a";
            ctx.fillRect(0, 0, game.width, 60);  
        }
        function ui(){
            ctx.font = "20px Arial";
            ctx.fillStyle = "red";
            ctx.fillText(`score: ${game.score}`, 10, 20);
            ctx.fillText(`highscore: ${game.highscore}`, game.width - ctx.measureText(`highscore: ${game.highscore}`).width - 10, 20);
            ctx.fillText(`next:`, 10, 45);
        }
        function line(){
            ctx.fillStyle = "red";
            ctx.fillRect(0, 60, game.width, 5)
        }
        function nextBlock(){
            ctx.fillStyle = game.colors[game.x];
            game.objects[game.x].forEach(function(item){
                ctx.fillRect(110 + item[0] * game.size / 1.25 , 35 + item[1] * game.size / 1.25, game.size / 1.25 , game.size / 1.25)
            });
        }
        bg();
        ui();
        line();
        nextBlock();
    }
    drawBackground();
    drawBlock();
    drawAfk();
    drawGhost();
    drawUI();
}
function drawStartScreen(){
    ctx.fillStyle = "black";
    ctx.fillRect(0, 0, game.width, game.height);
    ctx.fillStyle = "green";
    ctx.fillRect(game.width / 10, game.height / 4, game.width - game.width / 5, 100);
    ctx.font = "30px Arial";
    ctx.fillStyle = "yellow";
    ctx.fillText("Press any key", game.width / 2  - ctx.measureText(`Press any key`).width / 2, game.height / 2 - game.height / 4 + 30);
    ctx.fillText("or click here", game.width / 2  - ctx.measureText(`or click here`).width / 2, game.height / 2 - game.height / 4 + 60);
    ctx.fillText("to start", game.width / 2  - ctx.measureText(`to start`).width / 2, game.height / 2 - game.height / 4 + 90);
    drawGuide()
}
function drawEndScreen(){
    ctx.fillStyle = "red";
    ctx.fillRect(game.width / 10, game.height / 4, game.width - game.width / 5, 130);
    ctx.font = "30px Arial";
    ctx.fillStyle = "yellow";
    ctx.fillText("You lost", game.width / 2  - ctx.measureText(`You lost`).width / 2, game.height / 2 - game.height / 4 + 30);
    ctx.fillText("Press any key", game.width / 2  - ctx.measureText(`Press any key`).width / 2, game.height / 2 - game.height / 4 + 60);
    ctx.fillText("or click here", game.width / 2  - ctx.measureText(`or click here`).width / 2, game.height / 2 - game.height / 4 + 90);
    ctx.fillText("to start again", game.width / 2  - ctx.measureText(`to start again`).width / 2, game.height / 2 - game.height / 4 + 120);
    drawGuide()
}
function drawGuide(){
    ctx.font = "25px Arial";
    ctx.fillStyle = "red";
    ctx.fillText("Arrow left, right - Sides", 10, 300);
    ctx.fillText("Arrow Down - Move down", 10, 330);
    ctx.fillText("Arrow UP - Rotate", 10, 360);
    ctx.fillText("P - Pause", 10, 390);
}
function drawPause(){
    ctx.font = "35px Arial";
    ctx.fillStyle = "red";
    ctx.fillText("Paused", game.width / 2 - ctx.measureText(`Paused`).width / 2, game.height / 2 - 35 / 2);
}
function newLeaderBoard(){
    if (pageNum < 1) {
        pageNum = 1;
    } else {
        $("#leaderBoard").load(`../leaderboard/lb.php?page=${pageNum}&game=4`);
    }
}
</script>