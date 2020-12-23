<?php
session_start();
?>
<?php
if (isset($_POST["letter"])){
    $ltr = $_POST["letter"];
    $word = $_SESSION["hang"]["word"];
    if (str_contains($word, $ltr)){
        $guessWord = $_SESSION["hang"]["guessWord"];
        for ($i = 0; $i < strlen($word); $i++){
            if ($word[$i] == $ltr){
                $guessWord[$i * 2] = $ltr;
            }
        }
        $_SESSION["hang"]["word"] = $word;
        $_SESSION["hang"]["guessWord"] = $guessWord;
        echo "<h1>$guessWord</h1>";
    } else {
        $_SESSION["hang"]["hp"] = $_SESSION["hang"]["hp"] - 1;
        echo "h" . $_SESSION["hang"]["hp"] . "h";
        echo 0;
    }
}
?>