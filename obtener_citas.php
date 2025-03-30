<?php
include 'db.php';
header('Content-Type: application/json');

$sql = "SELECT usuario, cedula, telefono, tecnico, fecha_hora FROM citas";
$result = $conn->query($sql);

$citas = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $citas[] = $row;
    }
}

echo json_encode($citas);
$conn->close();
?>
