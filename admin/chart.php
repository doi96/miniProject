<?php 
include_once '../config/Database.php';
$database = new Database();
$db = $database->getConnection();
$query = "SELECT id, name FROM products ";
$stmt = $db->prepare($query);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$dataPoints = array(
    array("y"=>10, "lable"=>$row['name']),
    array("y"=>20, "lable"=>$row['name']),
    array("y" => 5, "lable" => $row['name']),
    array("y" => 3, "lable" => $row['name']),
    array("y" => 15, "lable" => $row['name']),
);
?>
<!DOCTYPE HTML>
<html>

<head>
    <script>
        window.onload = function() {

            var chart = new CanvasJS.Chart("chartContainer", {
                animationEnabled: true,
                theme: "light2",
                title: {
                    text: "Product Chart"
                },
                axisY: {
                    title: "Gold Reserves (in tonnes)"
                },
                data: [{
                    type: "column",
                    yValueFormatString: "#,##0.## tonnes",
                    dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
                }]
            });
            chart.render();

        }
    </script>
</head>

<body>
    <div id="chartContainer" style="height: 370px; width: 100%;"></div>
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>

</html>