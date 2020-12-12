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

    grid-template-rows: 0.4fr 1fr 1fr;
    grid-template-columns: 1fr 1fr 1fr;
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

    grid-template-rows: 0.25fr 1fr 1fr 0.1fr 0.25fr;
    grid-template-columns: 1fr 1fr;
    grid-template-areas: 
    "t2 t2"
    "m2 m2"
    "m1 t3"
    "b1 b2"
    "t1 t1"
    "m3 b3";
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
            <a class="logout" href="login/logout.php">Logout</a>
        </div>

        <div class="m bg-warning">
        </div>
    </div>

</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="script.js"></script>
<script>

</script>
</html>