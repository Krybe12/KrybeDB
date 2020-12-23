<?php
$words = file_get_contents("words.json");
$words = json_decode($words, true);

$n = strlen($words["words"][rand(1,979)]);
$guessWord = "_";
for ($i = 1; $i < $n; $i++){
    $guessWord .= " _";
}
echo "<h1>$guessWord</h1>";
?>