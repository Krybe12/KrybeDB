<?php
session_start();
?>
<?php
require '../gameconn/conn.php';

if (!isset($_SESSION["user"]) || $_SESSION["verified"] != 1){
    header('Location: ../index.php?id=login&re=nt');
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
.content-box{

min-height:150px;
min-width: 300px;
padding-top: 20px;
padding-left:50px;
padding-right:30px;
padding-bottom: 20px; /* Radek uprava, 40 -> 20 */

margin:10px 35em;
margin-bottom: 20px;

background-color: darkgrey;
font-weight: 400;  

text-align: left;
border: 1px solid var(--lightGrayHover);
border-radius: 8px;    

box-shadow: 0px 0px 32px 0px rgba(0,0,0,0.1);

}
@media (max-width: 860px){
.content-box{

    margin:10px 15px;
    }
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
    <title>Profile</title>
</head>
<body>
    <div class="grid bg-secondary">
        <div class="t1 section">
        <h1>logged in <br><?php $user = $_SESSION["user"]; $color = $_SESSION["color"]; echo "<p style='color: $color;'>$user</p><p>, bitch</p>" ?></h1>
        </div>

        <div class="t2 section">
            <h1>Profile</h1>
        </div>

        <div class="t3 section">

            <div class="btn-group">
                <button type="button" class="btn btn-danger dropdown-toggle btn-lg" data-bs-toggle="dropdown" aria-expanded="false">
                    <?php echo $_SESSION["user"]?>
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="..">HUB</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="../login/logout.php">Logout</a></li>
                </ul>
            </div>
        </div>

        <div class="m bg-dark">
            <div class="content-box">
                <form id="settings" action="savesettings.php" method="post" class="p-4 bg-light rounded">
                <div class="form-group">
                    <label for="favcolor">Select your favorite color:</label>
                    <input type="color" id="favcolor" name="favcolor" value="<?php echo $_SESSION['color']?>">
                </div>
                <div class="form-group text-center m-0">
                    <input type="submit" id="btnsave" class="form-control btn-dark" value="Save Settings">
                </div>
                </form>
            </div>
        </div>
    </div>

</body>
<script>

</script>
</html>