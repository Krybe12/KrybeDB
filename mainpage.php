<?php
session_start();
?>
<?php
require 'gameconn/conn.php';
$page = $_SERVER['REQUEST_URI'];
if (!isset($_SESSION["user"]) || $_SESSION["verified"] != 1){
    header("Location: ../index.php?id=login&re=nt&page=$page");
}
?>
<style>
@media (min-width:860px){
    .grid {
    display: grid;
    height: 100%;
    text-align: center;

    grid-template-rows: 0.5fr 1fr 1fr;
    grid-template-columns: 1fr 3fr 1fr;
    grid-template-areas: 
    "t1 t2 t3"
    "m m m"
    "m m m";
    }
}
@media (max-width: 860px){
    .grid {
    display: grid;
    text-align: center;

    grid-template-rows: 0.25fr 1fr 1fr 1fr;
    grid-template-columns: 1fr 1fr;
    grid-template-areas: 
    "t2 t2"
    "m m"
    "t3 t1";
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
.m{
    grid-area: m;
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

h1, .h1 {
  font-size: 2.8em !important;
}
.card-title{
    font-size: 150%;
}
p {
  display: inline-block;
}
</style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <title>HUB</title>
</head>
<body>
    <div class="grid bg-secondary">
        <div class="t1 section">
            <h1>logged in <br><?php $user = $_SESSION["user"]; $color = $_SESSION["color"]; echo "<p style='color: $color;'>$user</p><p>, bitch</p>" ?></h1>
        </div>

        <div class="t2 section">
            <h1>Main Hub</h1>
        </div>

        <div class="t3 section">
            <button type="button" style="width: 1px;" class="btn btn-secondary" id="pop" data-container="body" data-toggle="popover" data-placement="left" title="Setup your profile"></button>

            <div class="btn-group">
                <button type="button" class="btn btn-danger dropdown-toggle btn-lg" data-bs-toggle="dropdown" aria-expanded="false" >
                    <?php echo $_SESSION["user"]?>
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="profile">Profile</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="login/logout.php">Logout</a></li>
                </ul>
            </div>
        </div>

        <div class="m bg-dark">

            <div class="container py-3">
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 row-cols-lg-8 g-4 justify-content-center align-items-center">    
                    <div class="col">
                        <div class="card text-center bg-warning">
                            <div class="card-img-top" style="height: 150px; background-image: url('img/test.png'); background-size: contain; background-repeat: no-repeat; background-position: center center;"></div>
                                <div class="card-body">
                                <h5 class="card-title">Matematická hra</h5>
                                <a class="btn btn-success d-block" href="matgame">Play</a>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card text-center bg-warning">
                            <div class="card-img-top" style="height: 150px; background-image: url('img/calc.png'); background-size: contain; background-repeat: no-repeat; background-position: center center;"></div>
                                <div class="card-body">
                                <h5 class="card-title">Kalkulačka</h5>
                                <a class="btn btn-success d-block" href="kalkulacka.html">Play</a>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card text-center bg-warning">
                            <div class="card-img-top" style="height: 150px; background-image: url('img/test.png'); background-size: contain; background-repeat: no-repeat; background-position: center center;"></div>
                                <div class="card-body">
                                <h5 class="card-title">Matematická hra</h5>
                                <a class="btn btn-success d-block" href="matgame">Play</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>

</body>
<script>
    $(document).ready(function(){
    });
    $(function () {
        const popover = $('[data-toggle="popover"]').popover({
            placement: "left"
        })
        let profileNotSet = <?php echo $_SESSION["profilenotset"]?>;
        if (profileNotSet == 1){
            popover.popover("show");
        } else {
            popover.popover("hide");
        }
    })

</script>
</html>