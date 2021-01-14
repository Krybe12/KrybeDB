<?php
session_start();
?>
<?php
require '../gameconn/conn.php';

$numPerPage = 10;
$scoreColumn = "Score";
if (isset($_GET["game"])){
    if ($_GET["game"] == 1){
        $ha = "matgame";
    } else if ($_GET["game"] == 2){
        $ha = "hangman";
    } else if ($_GET["game"] == 3){
        $ha = "snake";
        $scoreColumn = "Highscore";
    } else if ($_GET["game"] == 4){
        $ha = "tetris";
        $scoreColumn = "Highscore";
    } 
}

$sql = "SELECT * FROM $ha JOIN users WHERE $ha.user_id = users.id";
$result = $conn->query($sql);
if ($result->num_rows > 0){
    $numUser = $result->num_rows;
    $numPages = ceil($numUser / $numPerPage);
}
if (isset($_GET["page"]) and is_numeric($_GET["page"])){
    if ($_GET["page"] >= 1 and $_GET["page"] <= $numPages){
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
}


//$sql = "SELECT matscore, username FROM users ORDER BY matscore DESC LIMIT $start, $end";
$sql = "SELECT users.id, users.username, $ha.score, usersettings.color FROM $ha JOIN users ON $ha.user_id = users.id JOIN usersettings ON users.id = usersettings.user_id ORDER BY score DESC LIMIT $start, $end";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    echo '<table class="table text-center table-dark table-borderless">';
    echo '<tr>';

    echo "<th>";
    echo "#";
    echo "</th>";

    echo "<th>";
    echo "<b>" . "Username" . "</b>";
    echo "</th>";

    echo "<th>";
    echo "<b>" . $scoreColumn . "</b>";
    echo "</th>";

    echo "</tr>";
    $color = "warning";
    $class = "text-" . $color;
    $id = $_SESSION["userid"];
    while($row = $result->fetch_assoc()) {
        $position++;
        $color = $row["color"];
        $id = $row["id"] * 17;
        echo "<tr>";

        echo "<td>";
        echo $position . ".";
        echo "</td>";   
        //echo "<td class='$class'>";
        echo "<td>";
        echo "<a href='../profiles?id=$id' style='text-decoration:none;'><b style='color: $color;'>" . $row["username"] . "</b></a>";
        echo "</td>";

        echo "<td>";
        echo $row["score"];
        echo "</td>";

        echo "</tr>";
    }
    echo "<tr>";

    echo "<td>";
    echo "</td>";

    echo "</tr>";
    echo "</table>";

    echo "<div class='d-flex align-items-center justify-content-center'><button style='width: 35%;' id='btnPrevious' class='btn btn-primary mx-2'>Previous</button><h5>$pageInfo</h5><button style='width: 35%;' id='btnNext' class='btn btn-primary mx-2'>Next</button></div>";

    echo "<script>";
    echo "if(pageNum > $numPages){pageNum = $numPages;}";
    echo "$('#btnNext').click(function(){ pageNum++; newLeaderBoard();});";
    echo "$('#btnPrevious').click(function(){ pageNum--; newLeaderBoard();});";
    echo "</script>";
}
?>