<?php
session_start();
?>
<?php
if (!isset($_SESSION["user"]) || $_SESSION["verified"] != 1){
    header('Location: index.php?id=login&re=nt');
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
</style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <title>adsadasd</title>
</head>
<body>
    <div class="grid bg-secondary">
        <div class="t1 section">
            <h1>logged in <?php echo $_SESSION["user"]; ?>, bitch</h1>
        </div>

        <div class="t2 section">
            <h1>Main Hub</h1>
        </div>

        <div class="t3 section">
            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                    Dropdown button
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <li><a class="dropdown-item" href="#">Action</a></li>
                    <li><a class="dropdown-item" href="#">Another action</a></li>
                    <li><a class="dropdown-item" href="#">Something else here</a></li>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>

</script>
</html>