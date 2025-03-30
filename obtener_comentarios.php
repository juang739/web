<?php
include 'db.php';

header('Content-Type: application/json');

$vendedor_id = $_GET['vendedor_id'];

$sql = "SELECT usuario, comentario, calificacion, fecha FROM comentarios_vendedores WHERE vendedor_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $vendedor_id);
$stmt->execute();
$result = $stmt->get_result();

$comentarios = [];
while ($row = $result->fetch_assoc()) {
    $comentarios[] = $row;
}

echo json_encode($comentarios);
$conn->close();
?>
