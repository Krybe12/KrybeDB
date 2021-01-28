<?php
session_start();
?>
<?php
require '../gameconn/conn.php';
$userid = $_SESSION["userid"];

if ($_SESSION["admin"] == 1){
    $sql = "SELECT * FROM umimeto";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo '<table class="table text-center table-dark table-borderless">';
        echo '<tr>';
    
        echo "<th>";
        echo "<b>Name</b>";
        echo "</th>";
    
        echo "<th>";
        echo "<b>IP</b>";
        echo "</th>";
    
        echo "<th>";
        echo "<b>Uses</b>";
        echo "</th>";

        echo "<th>";
        echo "<b>Remove</b>";
        echo "</th>";
    
        echo "</tr>";
        while($row = $result->fetch_assoc()) {
            $id = $row["id"];
            echo "<tr class='align-middle'>";
    
            echo "<td>";
            echo $row["nick"];
            echo "</td>";   
            echo "<td>";
            echo $row["ip"];
            echo "</td>";
    
            echo "<td>";
            echo $row["uses"];
            echo "</td>";

            echo "<td>";
            echo "<button class='btn-sm btn-warning' onclick='removeVer($id)'>Remove</button>";
            echo "</td>";
    
            echo "</tr>";

        }
        echo "<tr>";
    
        echo "<td>";
        echo "</td>";
    
        echo "</tr>";
        echo "</table>";
    }
} else {
    header("Location: ../login/logout.php");
}
?>