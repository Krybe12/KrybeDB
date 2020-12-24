<?php
session_start();
?>
<?php
if (isset($_POST["letter"])){
    $ltr = $_POST["letter"];
    $word = $_SESSION["hang"]["word"];
    if (strstr($word, $ltr)){
        $guessWord = $_SESSION["hang"]["guessWord"];
        for ($i = 0; $i < strlen($word); $i++){
            if ($word[$i] == $ltr){
                $guessWord[$i * 2] = $ltr;
            }
        }
        $_SESSION["hang"]["word"] = $word;
        $_SESSION["hang"]["guessWord"] = $guessWord;
        if (strpos($guessWord, '_') === false) { //won
            echo "<h1>$guessWord</h1><script>game.correct(2500);game.score++;setTimeout(function(){game.newWord()}, 2500);</script>";
        } else { //guessed correctly
            echo "<h1>$guessWord</h1>";
        }
    } else {
        $_SESSION["hang"]["hp"] = $_SESSION["hang"]["hp"] - 1;
        if ($_SESSION["hang"]["hp"] <= 0){ //lost
            echo "<h1>$word</h1><script>game.wrong(2500);game.score--;setTimeout(function(){game.newWord()}, 2500);</script>";
        } else { //guessed wrongly
            echo "0";
        }
    }
}
?>