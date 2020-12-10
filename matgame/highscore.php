<?php
session_start();
?>
<?php
require 'conne.php';

$numPerPage = 6;

$sql = "SELECT matscore, username FROM users ORDER BY matscore DESC";
$result = $conn->query($sql);
if ($result->num_rows > 0){
    $numUser = $result->num_rows;
    $numPages = ceil($numUser / $numPerPage);
}

if (isset($_GET["page"]) and $_GET["page"] >= 1 and $_GET["page"] <= $numPages){
    $currentPage = $_GET["page"];
    $pageInfo = "page " . $currentPage . "/" . $numPages;
    $start = $_GET["page"] * $numPerPage - $numPerPage;
    $end = $numPerPage; 
    $position = $start;
} else {
    $start = $numPages * $numPerPage - $numPerPage;
    $end = $numPerPage;
    $pageInfo = "page " . $numPages . "/" . $numPages;
    $position = $start;
}

$sql = "SELECT matscore, username FROM users ORDER BY matscore DESC LIMIT $start, $end";
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
    while($row = $result->fetch_assoc()) {
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
    echo "<tr>";

    echo "<td colspan='3'>";
    echo "<div class='d-flex justify-content-center'><button class='btn btn-Secondary' id='btnPrevious'>previous</button><p id='currentPage' class='align-self-center'>". $pageInfo . "</p><button class='btn btn-Secondary' id='btnNext'>next</button></div>";
    echo "</td>";

    echo "</tr>";
    echo "</table>";

    echo "<script>";
    echo "if(pageNum > $numPages){pageNum = $numPages;}";
    echo "$('#btnNext').click(function(){ pageNum++; newLeaderBoard();});";
    echo "$('#btnPrevious').click(function(){ pageNum--; newLeaderBoard();});";
    echo "</script>";
}
?>