<?php
session_start();
?>
<?php
require 'gameconn/conn.php';
$page = $_SERVER['REQUEST_URI'];
if (!isset($_SESSION["user"]) || $_SESSION["verified"] != 1){
    header("Location: ../index.php?id=login&re=nt&page=$page");
}
//var_dump($_SESSION["achtest"][1]);

?>
<style>
@media (min-width:768px){
    .grid {
    display: grid;
    height: 100%;

    grid-template-rows: 0.15fr 1fr;
    grid-template-columns: 1fr;
    grid-template-areas: 
    "t"
    "m";
    }
}
@media (max-width: 768px){
    .grid {
    display: grid;
    height: 100%;
    grid-template-rows: 0.15fr 2fr;
    grid-template-columns: 1fr;
    grid-template-areas: 
    "t"
    "m";
    }
}

.t{
    grid-area: t;
    border-bottom: 4px solid #ffc107;
}
.m{
    grid-area: m;
}
.alerty {
    position: absolute;
    right: 10;
    bottom: 10;
}
.card-title{
    font-size: 150%;
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
<div class="grid">
    <div class="t bg-dark text-light d-flex flex-column flex-md-row justify-content-between align-items-center">
        <div class="container-fluid bg-dark text-light p-3 flex-shrink-1">
            <div class="row align-items-center">
                <div class="col-md d-flex justify-content-center justify-content-md-start">
                    <h5 class="m-md-0">Logged in as <?php echo "<h5 class='mx-2' style='color: {$_SESSION['color']}'>{$_SESSION['user']}</h5>"?></h5>
                </div>
                <div class="col-md d-flex justify-content-center">
                    <h4 class="m-md-0">HUB</h4>
                </div>
                <div style="white-space: nowrap;" class="col-md d-flex justify-content-center justify-content-md-end">
                    <button style="width: 1px" class="btn btn-dark p-0 m-0" id="pop" data-container="body" data-toggle="popover" data-placement="left" title="Setup your profile"></button>
                    <a href="profile" class="btn btn-primary mx-2" >Profile</a>
                    <a href="login/logout.php" class="btn btn-danger mx-2">Logout</a>
                </div>
            </div>
        </div>
    </div>
    <div class="m bg-dark">
        <div class="container py-4">
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
<div class="alerty">
</div>

</body>
<?php
if (!isset($_SESSION["achdone"][1])){ //achievement firt login
    $date = date('j M, Y @ g:ia');
    $sql = "INSERT INTO achcompleted (user_id, ach_id, awarded) VALUES ({$_SESSION['userid']}, 1, '$date')";
    $conn->query($sql);
    $_SESSION["achdone"][1] = 1;
    echo '<script>
    $(document).ready(function(){
        $.get( "achievements/alert.php", { achid: 1}, function(data){
            $(".alerty").append(data);
        });
    });   
    </script>';
}
?>
<script>
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
