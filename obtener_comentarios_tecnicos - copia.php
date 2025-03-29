<?php
include 'db.php';



$tecnico_id = $_GET['tecnico_id'];

$sql = "SELECT usuario, comentario, calificacion, fecha FROM comentarios_tecnicos WHERE tecnico_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $tecnico_id);
$stmt->execute();
$result = $stmt->get_result();

$comentarios = [];
while ($row = $result->fetch_assoc()) {
    $comentarios[] = $row;
}

echo json_encode($comentarios);
$conn->close();
?>
