<?php
session_start();
?>
<?php
require '../gameconn/conn.php';

$page = $_SERVER['REQUEST_URI'];
if (!isset($_SESSION["user"]) || $_SESSION["verified"] != 1){
    header("Location: ../index.php?id=login&re=nt&page=$page");
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
    <title>Hangman</title>
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
                    <h4 class="m-md-0">Hangman</h4>
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
    <div class="m2 text-center bg-secondary pt-2 pt-md-4">
        <div id="wrap" class="">
            <div>
                <img src="https://via.placeholder.com/300" alt="">
            </div>
            <div class="container-fluid d-flex flex-column justify-content-center align-items-center pt-md-3">   
                <div class="p-1">
                    <button class="btn btn-lg btn-dark">A</button>
                    <button class="btn btn-lg btn-dark">B</button>
                    <button class="btn btn-lg btn-dark">C</button>
                    <button class="btn btn-lg btn-dark">A</button>
                    <button class="btn btn-lg btn-dark">A</button>
                    <button class="btn btn-lg btn-dark">A</button>
                    <button class="btn btn-lg btn-dark">A</button>
                    <button class="btn btn-lg btn-dark">A</button>
                    <button class="btn btn-lg btn-dark">A</button>
                </div>
                <div class="p-1">
                    <button class="btn btn-lg btn-dark">A</button>
                    <button class="btn btn-lg btn-dark">A</button>
                    <button class="btn btn-lg btn-dark">A</button>
                    <button class="btn btn-lg btn-dark">A</button>
                    <button class="btn btn-lg btn-dark">A</button>
                    <button class="btn btn-lg btn-dark">A</button>
                    <button class="btn btn-lg btn-dark">A</button>
                    <button class="btn btn-lg btn-dark">A</button>
                    <button class="btn btn-lg btn-dark">A</button>
                </div>
                <div class="p-1">
                    <button class="btn btn-lg btn-dark">A</button>
                    <button class="btn btn-lg btn-dark">A</button>
                    <button class="btn btn-lg btn-dark">A</button>
                    <button class="btn btn-lg btn-dark">A</button>
                    <button class="btn btn-lg btn-dark">A</button>
                    <button class="btn btn-lg btn-dark">A</button>
                    <button class="btn btn-lg btn-dark">A</button>
                    <button class="btn btn-lg btn-dark">A</button>
                    <button class="btn btn-lg btn-dark">A</button>
                </div>
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

<script>
$( document ).ready(function() {
});
</script>