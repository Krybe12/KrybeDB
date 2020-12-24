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
$_SESSION["hang"]["guessWord"] = $guessWord;
$_SESSION["hang"]["hp"] = 6;
echo "<script>console.log('{$_SESSION["hang"]["word"]}')</script>";
echo "<h1>$guessWord</h1>";
?>