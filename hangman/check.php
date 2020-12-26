<?php
session_start();
?>
<?php
require '../gameconn/conn.php';
$userid = $_SESSION["userid"];

function add($n){
    global $userid;
    global $conn;
    if ($n == 1){
        $_SESSION["hang"]["totalScore"] = $_SESSION["hang"]["totalScore"] + 1;
    } else {
        $_SESSION["hang"]["totalScore"] = $_SESSION["hang"]["totalScore"] - 1;
    }
    
    $score = $_SESSION["hang"]["totalScore"];
    $sql = "UPDATE hangman SET score='$score' WHERE user_id='$userid'";
    $conn->query($sql);
}


if (isset($_SESSION["hang"]["totalScore"])){
} else {
    $sql = "SELECT score FROM hangman WHERE user_id='$userid' LIMIT 1";
    $result = $conn->query($sql);
    $result = $result->fetch_assoc();
    $_SESSION["hang"]["totalScore"] = $result["score"];
} 

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
            add(1);
            $_SESSION["hang"]["inRowWrong"] = 0;
            $_SESSION["hang"]["inRowCorrect"] = $_SESSION["hang"]["inRowCorrect"] + 1;
            echo "<h1>$guessWord</h1><h2>You won!</h2><script>game.won();game.score++;setTimeout(function(){game.newWord()}, 2500);</script>";
        } else { //guessed correctly
            echo "<h1>$guessWord</h1><script>game.correct();</script>";
        }
    } else {
        $_SESSION["hang"]["hp"] = $_SESSION["hang"]["hp"] - 1;
        if ($_SESSION["hang"]["hp"] <= 0){ //lost
            add(0);
            $_SESSION["hang"]["inRowCorrect"] = 0;
            $_SESSION["hang"]["inRowWrong"] = $_SESSION["hang"]["inRowWrong"] + 1;
            echo "<h1>$word</h1><h2>You lost!</h2><script>game.lost();game.score--;setTimeout(function(){game.newWord()}, 2500);</script>";
        } else { //guessed wrongly
            echo "<h1>{$_SESSION['hang']['guessWord']}</h1><script>game.wrong();</script>";
        }
    }
}

?>