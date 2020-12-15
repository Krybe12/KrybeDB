<?php
session_start();
if (isset($_SESSION["user"]) && isset($_SESSION["verified"])){
    header('Location: mainpage.php');
}
if (isset($_GET["page"])){
    $_SESSION["gotopage"] = $_GET["page"];
}
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
<title>Login</title>
</head>
<body class="bg-dark">
    <div class="container">
        <h2 id="wp" class="text-light"></h2>
        <div class="row flex-column flex-md-row justify-content-around pt-5">
            <div class="text-center text-md-left mb-3 mb-md-0">
                <h2 class="text-light">Login Form</h2>
            </div>
            <div class="text-center text-md-right">
                <div id="logreg" class="btn-group">
                    <button type="button" id="btnlogin" class="btn btn-primary">Login</button>
                    <button type="button" id="btnregister" class="btn btn-primary">Register</button>
                </div>
            </div>
        </div>
    </div>
    <div class="container pb-5">
        <div class="row flex-row justify-content-center pt-5">
            <form id="log" action="login/logindb.php" method="post" class="p-4 bg-light rounded">
                <div class="form-group">
                    <label for="name">Username</label>
                    <input type="text" class="form-control" autocomplete="off" placeholder="Enter Username" name="name" required>
                </div>
                <div class="form-group">
                    <label for="pswd">Password</label>
                    <input type="password" class="form-control" placeholder="Enter Password" name="pswd" required>
                </div>
                <div class="form-group text-center m-0">
                    <input type="submit" class="form-control btn-dark" value="Login">
                </div>
            </form>
    
            <form id="reg" action="login/registerdb.php" method="post" class="p-4 bg-light rounded">
                <div class="form-group">
                    <label for="name">Username</label>
                    <input type="text" class="form-control" autocomplete="off" id="inputname" placeholder="Enter Username" name="name" required>
                    <div id="lblname" class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                    <label for="pswd">Password</label>
                    <input type="password" class="form-control" id="input1" placeholder="Enter Password" name="pswd" required>
                    <div id="lbl1" class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                    <label for="pswd2">Repeat password</label>
                    <input type="password" class="form-control" id="input2" placeholder="Repeat Password" name="pswd2" required>
                    <div id="lbl2" class="invalid-feedback"></div>
                </div>
                <div class="form-group text-center m-0">
                    <input type="submit" id="btnreg" class="form-control btn-dark" value="Register">
                </div>
            </form>
        </div>
    </div>
</body>
</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$("#page").hide();
var url_string = window.location.href;
if (url_string.includes("?")){
    var url = new URL(url_string);
    var where = url.searchParams.get('id');
    if (where == "login"){
        $("#reg").hide();
        $("#log").show();
        $("#btnlogin").attr("disabled", true);
    } else if (where == "register"){
        $("#reg").show();
        $("#log").hide();
        $("#btnregister").attr("disabled", true);
    } 

    var reason = url.searchParams.get("re");
    let b = " bitch";
    if (reason == "noexist"){
        $("#wp").text("user does not exist" + b);
    } else if (reason == "regsuc"){
        $("#wp").text("registration succesful" + b);
    } else if (reason == "wp"){
        $("#wp").text("wrong password" + b);
    } else if (reason == "regexi"){
        $("#wp").text("username already registered" + b);
    } else if (reason == "nt") {
        $("#wp").text("nice try" + b);
    } else if (reason == "log") {
        $("#wp").text("logged out" + b);
    }
    if (!where){
        $("#reg").hide();
        $("#log").show();
        $("#wp").hide();
        $("#btnlogin").attr("disabled", true);
    }
} else {
    $("#reg").hide();
    $("#log").show();
    $("#wp").hide();
    $("#btnlogin").attr("disabled", true);
}
$("#btnlogin").click(function(){
    $("#btnregister, #btnlogin").attr("disabled", true);
    $("#wp").text(" ");
    $("#reg").fadeOut(300, function(){
        $("#btnregister").attr("disabled", false);
        $("#log").fadeIn(300, function(){
        });
    });
});
$("#btnregister").click(function(){
    $("#btnregister, #btnlogin").attr("disabled", true);
    $("#wp").text(" ");
    $("#log").fadeOut(300, function(){
        $("#btnlogin").attr("disabled", false);
        $("#reg").fadeIn(300, function(){ 
        });
    });
});
let x, t1, t2, t3;
$("#input1, #input2, #inputname").keyup(function(){
    let pas1 = $("#input1").val();
    let pas2 = $("#input2").val();
    let nm = $("#inputname").val();
    $.post("login/check.php", {
        ps1: pas1,
        ps2: pas2,
        name : nm
    }, function(data, status){
        data = data.split("&")
        t1 = t2 = t3 = false;
        $("#inputname, #input1, #input2").removeClass("is-invalid is-valid");
        if (data.includes("x1")) {
            x = data.indexOf("x1") - 1;
            $("#lblname").text(data[x]);
            $("#inputname").addClass("is-invalid");
        } else if (nm.length > 0){
            $("#inputname").addClass("is-valid");
            t1 = true;
        }
        if (data.includes("x2")) {
            x = data.indexOf("x2") - 1;
            $("#lbl1").text(data[x]);
            $("#input1").addClass("is-invalid"); 
        } else if (pas1.length > 0){
            $("#input1").addClass("is-valid");
            t2 = true;
        }
        if (data.includes("x3")) {
            x = data.indexOf("x3") - 1;
            $("#lbl2").text(data[x]);
            $("#input2").addClass("is-invalid");
        } else if (pas2.length > 0 && pas1.length > 3){
            $("#input2").addClass("is-valid");
            t3 = true;
        }
        if (t1 == t2 && t2 == t3 && t3 == true){
            $("#btnreg").attr("disabled", false);
        } else {
            $("#btnreg").attr("disabled", true);
        }
    });
});
</script>