<?php
session_start();
?>
<?php
require 'conne.php';
//$result = $result->fetch_assoc();
if (isset($_GET["page"])){
    $position = $_GET["page"] * 5;
    $startPosition = $position - 5;
} else {
    //
}
$sql = "SELECT matscore, username FROM users ORDER BY matscore DESC";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
    echo '<table class="table">';
    echo "<tr>";

    echo "<th>";
    echo "###";
    echo "</th>";

    echo "<th>";
    echo "Username";
    echo "</th>";

    echo "<th>";
    echo "Score";
    echo "</th>";

    echo "</tr>";
    $runs = 0;
    while($row = $result->fetch_assoc()) {
        $runs++;
        $position++;

        echo "<tr>";

        echo "<td>";
        echo $position . ".";
        echo "</td>";

        echo "<td>";
        echo $row["username"];
        echo "</td>";

        echo "<td>";
        echo $row["matscore"];
        echo "</td>";

        echo "</tr>";
    }
    echo "</table>";
}
?>