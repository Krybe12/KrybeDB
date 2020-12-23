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
        if (strpos($guessWord, '_') === false) {
            echo "<h1>$guessWord</h1><h1>You Won!</h1><script>$('#wrap').addClass('bg-success');setTimeout(function(){game.newWord();$('#wrap').removeClass('bg-success')}, 3000)</script>";
        } else {
            echo "<h1>$guessWord</h1>";
        }
    } else {
        $_SESSION["hang"]["hp"] = $_SESSION["hang"]["hp"] - 1;
        if ($_SESSION["hang"]["hp"] == 0){
            echo "<h1>$word</h1><h1>You Lost!</h1><script>$('#wrap').addClass('bg-danger');setTimeout(function(){game.newWord();$('#wrap').removeClass('bg-danger')}, 3000)</script>";
        } else {
            echo "0";
        }
    }
}
?>