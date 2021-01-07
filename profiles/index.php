<?php
session_start();
?>
<?php
require '../gameconn/conn.php';
$page = $_SERVER['REQUEST_URI'];
if (!isset($_SESSION["user"]) || $_SESSION["verified"] != 1){
    header("Location: ../index.php?id=login&re=nt&page=$page");
}
if (isset($_GET["id"]) and is_numeric($_GET["id"])){
    $selUserId = $_GET["id"] / 17;
}
$stmt = $conn->prepare("SELECT users.username, users.id, usersettings.color FROM users JOIN usersettings ON users.id = usersettings.user_id WHERE users.id=? LIMIT 1");  //gettin username and confirms that selUserId is valid
$stmt->bind_param("i", $selUserId);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();
if ($result){
    $selUserName = $result['username'];
    $selUserFavColor = $result['color'];
} else {
    header('Location: https://youtu.be/dQw4w9WgXcQ');
}
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
</style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <title>Profile of <?php echo $selUserName?></title>
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
                        <h4 class="m-md-0">Profile of <?php echo "<h4 class='mx-2' style='color: $selUserFavColor;'>$selUserName</h4>" ?></h4>
                    </div>
                    <div style="white-space: nowrap;" class="col-md d-flex justify-content-center justify-content-md-end">
                        <a href="../profile" class="btn btn-primary mx-2">Profile</a>
                        <a href=".." class="btn btn-primary mx-2">Back to hub</a>
                        <a href="../login/logout.php" class="btn btn-danger mx-2">Logout</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="m bg-dark">
            <div class="content-box">
                <div id="favcolor"></div>
                <div id="matscore"></div>
                <div id="hangman"></div>
                <div id="snake"></div>
                <hr>
                <div id="logreg"></div>

                
            </div>
        </div>
    </div>

</body>
<script>
$(document).ready(function(){
    let userid = <?php echo $_GET["id"];?>;
    $("#matscore").load("../getstats/matgamestats.php?id=" + userid);
    $("#logreg").load("../getstats/lastloginregister.php?id=" + userid);
    $("#favcolor").load("../getstats/favcolor.php?id=" + userid);
    $("#hangman").load("../getstats/hangmanstats.php?id=" + userid);
    $("#snake").load("../getstats/snakestats.php?id=" + userid);
});
</script>
</html>