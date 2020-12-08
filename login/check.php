<?php
session_start();
?>
<?php
if (isset($_POST['name'])) {
    if (strlen($_POST['name']) > 0)  {
        if (strlen($_POST['name']) < 3){
            echo "jméno musí mít alespoň 3 znaky&x1&";
        } else if (strlen($_POST['name']) > 12){
            echo "jméno může mít maximálně 12 znaků&x1&";
        }
    }
}
if (isset($_POST['ps1'])) {
    if (strlen($_POST['ps1']) > 0)  {
        if (strlen($_POST['ps1']) < 4){
            echo "heslo musí mít alespoň 4 znaky&x2&";
        } else if (strlen($_POST["ps1"]) > 18){
            echo "heslo moc dlouhé&x2&";
        }
    }
}
if (isset($_POST['ps2'])) {
    if (strlen($_POST['ps2']) > 0)  {
        if ($_POST["ps1"] != $_POST["ps2"]){
            echo "hesla nejsou stejná&x3";
        }
    }
}
?>