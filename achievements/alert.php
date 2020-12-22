<?php
require '../gameconn/conn.php';
if (isset($_GET['achid']) and is_numeric($_GET['achid'])){
    $achid = $_GET['achid'];
    $sql = "SELECT * FROM achievments WHERE id=$achid";
    $result = $conn->query($sql);
    $result = $result->fetch_assoc();
    echo "
    <div id=$achid>
        <div style='z-index: 3;'class='alert alert-success' role='alert'>
            <h4 class='alert-heading'>Achievment unlocked!</h4>
            <b><p class='mb-0'>{$result['achiev_name']}</p></b>
            <hr>
            <p class='mb-0'>{$result['achiev_req']}</p>
        </div>
    </div>" . '
  <script>
    setTimeout(function(){$("#' . $achid. '").remove();}, 6000);
  </script>';
}
?>