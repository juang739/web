<?php
require 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tecnico_id = $_POST['tecnico_id'];
    $usuario = $_POST['usuario'];
    $calificacion = $_POST['calificacion'];
    $comentario = $_POST['comentario'];

    $sql = "INSERT INTO comentarios_tecnicos (tecnico_id, usuario, calificacion, comentario) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isis", $tecnico_id, $usuario, $calificacion, $comentario);
    
    if ($stmt->execute()) {
        header("Location: comentarios_tecnico.html?tecnico_id=" . $tecnico_id);
        exit();
    } else {
        echo "Error al guardar el comentario.";
    }
}
?>
