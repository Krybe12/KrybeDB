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

    if ($result->num_rows > 0) {

        while($row = $result->fetch_assoc()) {
            
            echo "<div class='card bg-success my-1'>";
            echo "<div class='card-header'>{$row['achiev_name']}</div>";
            echo "<div class='card-body'>";
            echo "<p class='card-text'>{$row['achiev_req']}</p>";
            echo "<p class='card-text'>Unlocked  {$row['awarded']}</p>";
            echo "</div>";
            echo "</div>";
        }
        
    }

    $sql = "SELECT * FROM achievments WHERE category_id = $category AND NOT EXISTS (SELECT * FROM achcompleted WHERE achievments.id = achcompleted.ach_id AND achcompleted.user_id = $userid)";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {

        while($row = $result->fetch_assoc()) {

            echo "<div class='card bg-secondary my-1'>";
            echo "<div class='card-header'>{$row['achiev_name']}</div>";
            echo "<div class='card-body'>";
            echo "<p class='card-text'>{$row['achiev_req']}</p>";
            echo "</div>";
            echo "</div>";
        }
        
    }
}
?>


        
            


