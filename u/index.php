<?php
session_start();
?>
<?php
require '../gameconn/conn.php';

$page = $_SERVER['REQUEST_URI'];
if (!isset($_SESSION["user"]) || $_SESSION["verified"] != 1){
    header("Location: ../index.php?id=login&re=nt&page=$page");
}
if ($_SESSION["admin"] != 1){
    header("Location: ulogin.php");
}

?>
<style>
@media (min-width:768px){
    .grid {
    display: grid;
    height: 100%;
    column-gap: 5px;
    grid-template-rows: 0.1fr 1.1fr;
    grid-template-columns: 1fr 1fr 1fr 1fr;
    grid-template-areas: 
    "t t t t"
    "m1 m2 m3 m4";
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
    "m3"
    "m4";
    }
    .m1{
        grid-area: m1;
        border-bottom: 4px solid #ffc107;
        overflow-y: auto;
        max-height: 50vh;
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

}
</style>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <title>Umimeto CP</title>
</head>
<body>
<div class="grid bg-warning">
    <div class="t bg-dark text-light d-flex flex-column flex-md-row justify-content-between align-items-center">
        <div class="container-fluid bg-dark text-light p-3 flex-shrink-1">
            <div class="row align-items-center">
                <div class="col-md d-flex justify-content-center justify-content-md-start">
                    <h5 class="m-md-0">Logged in as <?php echo "<h5 class='mx-2' style='color: {$_SESSION['color']}'>{$_SESSION['user']}</h5>"?></h5>
                </div>
                <div class="col-md d-flex justify-content-center">
                    <h4 class="m-md-0">Umimeto CP</h4>
                </div>
                <div style="white-space: nowrap;" class="col-md d-flex justify-content-center justify-content-md-end">
                    <a href="../profile" class="btn btn-primary mx-2">Profile</a>
                    <a href=".." class="btn btn-primary mx-2">Back to hub</a>
                    <a href="../login/logout.php" class="btn btn-danger mx-2">Logout</a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="m1 bg-dark text-light text-center p-lg-3 p-md-2 pt-md-0">
        <div style="position: sticky;top: 0;z-index: 2;" class="bg-dark py-md-3">
            <h4>Verified</h4>
            <hr class="mb-0">
        </div>
        <div id="ver">

        </div>
        
    </div>
    <div class="m2 bg-dark text-light text-center p-lg-3 p-md-2 pt-md-0">
        <div style="position: sticky;top: 0;z-index: 2;" class="bg-dark py-md-3">
            <h4>Add</h4>
            <hr class="mb-0">
        </div>
        <div>
            <div>
                <h6>Your IP:</h6>
                <h6><?php echo $_SERVER['REMOTE_ADDR'];?></h6>
                <button class="btn btn-sm btn-primary" id="btnAddMyself">Add Myself</button>
            </div>
            <div class="container d-flex pb-5 justify-content-center pt-5">
                <div class="p-4 bg-secondary rounded">
                    <input type="text" class="form-control" autocomplete="off" id="nameInput" placeholder="Name" required>
                    <input type="text" class="form-control mt-1" autocomplete="off" id="ipInput" placeholder="IP" required>
                    <div class="form-group text-center m-0">
                        <button class="form-control btn-dark" id="btnAddSomebody">Add</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="m3 bg-dark text-light text-center p-lg-3 p-md-2 pt-md-0">
        <div style="position: sticky;top: 0;z-index: 2;" class="bg-dark py-md-3">
            <h4>Requests</h4>
            <hr class="mb-0">
        </div>
        <div id="req">

        </div>
    </div>

    <div class="m4 bg-dark text-light text-center p-lg-3 p-md-2 pt-md-0">
        <div style="position: sticky;top: 0;z-index: 2;" class="bg-dark py-md-3">
            <h4>Blacklist</h4>
            <hr class="mb-0">
        </div>
        
        <div id="bl">
            
        </div>
    </div>
</div>

</body>
</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>

$( document ).ready(function() {
    $("#btnAddMyself").click(function(){
        addMyself();
    });
    $("#btnAddSomebody").click(function(){
        let name = $("#nameInput").val();
        let ip = $("#ipInput").val();
        if (name.length > 0 && ip.length > 0){
            addSomebody(name, ip);
            $("#nameInput, #ipInput").val("");
        }
    });
});
newVerified();
newBlackList();
newRequests();
function newVerified(){
    setTimeout(function(){
        $("#ver").load(`tablever.php`);
    },50)
    
}
function newBlackList(){
    setTimeout(function(){
        $("#bl").load(`tablebl.php`);
    },50)
}
function newRequests(){
    setTimeout(function(){
        $("#req").load(`tablereq.php`);
    },50)
}
function removeVer(b){
    $.post("removever.php", {
        id: b
    }, function(data){
    });
    newVerified();
}
function removeBL(v){
    $.post("removebl.php", {
        id: v
    }, function(data){
    });
    newBlackList();
}
function acceptReq(c){
    $.post("acceptreq.php", {
        id: c
    }, function(data){
    });
    newRequests();
    newVerified();
}
function declineReq(x){
    $.post("declinereq.php", {
        id: x
    }, function(data){
    });
    newRequests();
}
function addMyself(){
    $.post("addmyself.php", {
    }, function(data){
    });
    newVerified();
}
function addSomebody(name, ip){
    $.post("addsomebody.php", {
        name: name,
        ip: ip
    }, function(data){
    });
    newVerified();
}
</script>