<?php
session_start();
?>
<?php
require '../gameconn/conn.php';

if (isset($_GET["height"])){
    $height = $_GET["height"];
    if (is_numeric($height)){
        if ($height > 900 and $height < 1000){
            $numPerPage = 9;
        } else if ($height > 800 and $height <= 900){
            $numPerPage = 8;
        } else if ($height >= 1000 and $height < 1050){
            $numPerPage = 10;
        } else if ($height >= 1050){
            $numPerPage = 10;
        } else {
            $numPerPage = 7;
        }
    }
} else {
    $numPerPage = 7;
}


//$sql = "SELECT matscore, username FROM users ORDER BY matscore DESC";
$sql = "SELECT * FROM matgame JOIN users WHERE matgame.user_id = users.id";
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
$sql = "SELECT users.id, users.username, matgame.score, usersettings.color FROM matgame JOIN users ON matgame.user_id = users.id JOIN usersettings ON users.id = usersettings.user_id ORDER BY score DESC LIMIT $start, $end";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    echo '<table class="table">';
    echo '<tr class="beta">';

    echo "<th>";
    echo "###";
    echo "</th>";

    echo "<th>";
    echo "<b>" . "Username" . "</b>";
    echo "</th>";

    echo "<th>";
    echo "<b>" . "Score" . "</b>";
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
        echo "<a href='../profiles?id=$id'><b style='color: $color;'>" . $row["username"] . "</b></a>";
        echo "</td>";

        echo "<td>";
        echo $row["score"];
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