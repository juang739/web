<?php
include 'db.php';
header('Content-Type: application/json');

$usuario = $_POST['usuario'];
$cedula = $_POST['cedula'];
$telefono = $_POST['telefono'];
$tecnico = $_POST['tecnico'];
$fecha_hora = $_POST['fecha_hora'];

// Validar que la fecha y hora no estén ocupadas
$sql_verificar = "SELECT * FROM citas WHERE tecnico='$tecnico' AND fecha_hora='$fecha_hora'";
$result = $conn->query($sql_verificar);

if ($result->num_rows > 0) {
    echo json_encode(["status" => "error", "message" => "Este horario ya está ocupado con este técnico."]);
    exit();
}

// Insertar la cita si está disponible
$sql = "INSERT INTO citas (usuario, cedula, telefono, tecnico, fecha_hora) VALUES ('$usuario', '$cedula', '$telefono', '$tecnico', '$fecha_hora')";

if ($conn->query($sql) === TRUE) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "message" => $conn->error]);
}

$conn->close();
?>
