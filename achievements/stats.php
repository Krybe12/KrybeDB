<?php
session_start();
?>
<?php
require '../gameconn/conn.php';
if (isset($_GET['category']) and is_numeric($_GET['category'])){
    $category = $_GET["category"];
    $userid = $_SESSION["userid"];

    $sql = "SELECT * FROM achievments JOIN achcompleted ON achcompleted.ach_id = achievments.id WHERE category_id = $category AND achcompleted.user_id = $userid";
    $result = $conn->query($sql);
    echo '<table class="table">';
    echo '<thead>';
    echo '<tr class="beta">';

    echo "<th>";
    echo "<b>" . "Achievment" . "</b>";
    echo "</th>";

    echo "<th>";
    echo "<b>" . "Completed" . "</b>";
    echo "</th>";

    echo "</tr>";
    echo '</thead>';
    echo '<tbody>';
    if ($result->num_rows > 0) {

        while($row = $result->fetch_assoc()) {
            echo "<tr>";

            echo "<td>";
            echo "<b>{$row['achiev_name']}</b><br>{$row['achiev_req']}";
            echo "</td>";
    
            echo "<td>";
            echo "yes";
            echo "</td>";
    
            echo "</tr>";
        }
        
    }

    $sql = "SELECT * FROM achievments WHERE category_id = $category AND NOT EXISTS (SELECT * FROM achcompleted WHERE achievments.id = achcompleted.ach_id AND achcompleted.user_id = $userid)";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {

        while($row = $result->fetch_assoc()) {
            echo "<tr>";

            echo "<td>";
            echo "<b>{$row['achiev_name']}</b><br>{$row['achiev_req']}";
            echo "</td>";
    
            echo "<td>";
            echo "no";
            echo "</td>";
    
            echo "</tr>";
        }
        
    }
    echo "</tbody>";
    echo "</table>";
}
?>