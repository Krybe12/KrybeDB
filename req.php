<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <title>Request form</title>
</head>
<body class="bg-dark">
<div class="container d-flex pb-5 justify-content-center pt-5">
    <form id="req" action="u/request.php" method="post" class="p-4 bg-light rounded">
        <div class="form-group">
            <label for="name" id="nameLabel">Name</label>
            <input type="text" class="form-control" autocomplete="off" id="nameInput" placeholder="Enter your name" name="name" required>
        </div>
        <div class="form-group text-center m-0">
            <input type="submit" class="form-control btn-dark" id="btnSend" value="Send Request">
        </div>
    </form>
</div>

</body>
</html>
<script>
$("#nameInput").keyup(function(){
    let name = $("#nameInput").val();
    if (name.length > 12){
        $("#btnSend").attr("disabled", true);
        $("#nameLabel").text("Name too long(max 12characters)")
    } else {
        $("#btnSend").attr("disabled", false);
        $("#nameLabel").text("Name")
    }
});
</script>