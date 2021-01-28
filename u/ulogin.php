<?php
session_start();
?>
<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <title>ulogin</title>
</head>
<body class="bg-dark">¨
<div class="container pb-5">
    <form id="log" action="ulogincheck.php" method="post" class="p-4 bg-light rounded">
        <div class="form-group">
            <label for="pswd">Password</label>
            <input type="password" class="form-control" autocomplete="off" readonlyonfocus="this.removeAttribute('readonly');" placeholder="Enter Password" name="pswd" required>
        </div>
        <div class="form-group text-center m-0">
            <input type="submit" class="form-control btn-dark" value="Login">
        </div>
    </form>
</div>

</body>
</html>
