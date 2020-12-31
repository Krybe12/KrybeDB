<?php
session_start();
?>
<?php
$words = file_get_contents("words.json");
$words = json_decode($words, true);

$_SESSION["hang"]["word"] = strtoupper($words["words"][rand(1,979)]);
$n = strlen($_SESSION["hang"]["word"]);
$guessWord = "_";
for ($i = 1; $i < $n; $i++){
    $guessWord .= " _";
}

if (!isset($_SESSION["hang"]["inRowCorrect"]) or !isset($_SESSION["hang"]["inRowWrong"])){
    $_SESSION["hang"]["inRowCorrect"] = 0;
    $_SESSION["hang"]["inRowWrong"] = 0;
}

$_SESSION["hang"]["guessWord"] = $guessWord;
$_SESSION["hang"]["hp"] = 8; //imgcount - 1
//echo "<script>console.log('{$_SESSION["hang"]["word"]}')</script>"; //debug
echo "<h1>$guessWord</h1>";
?>