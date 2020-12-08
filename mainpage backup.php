<?php
session_start();
?>
<?php
if (!isset($_SESSION["user"]) || $_SESSION["verified"] != 1){
    header('Location: index.php?id=login&re=nt');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <title>adsadasd</title>
</head>
<body class="bg-secondary">   
    <div>
        <h1>logged in <?php echo $_SESSION["user"]; ?>, bitch</h1>
        <a href="login/logout.php">Logout</a>
    </div>

</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="script.js"></script>
<script>

</script>
</html>