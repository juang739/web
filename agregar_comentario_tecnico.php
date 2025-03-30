<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tecnico_id = $_POST['tecnico_id'];
    $usuario = $_POST['usuario'];
    $comentario = $_POST['comentario'];
    $calificacion = $_POST['calificacion'];

    $sql = "INSERT INTO comentarios_tecnicos (tecnico_id, usuario, comentario, calificacion, fecha) VALUES (?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issi", $tecnico_id, $usuario, $comentario, $calificacion);

    if ($stmt->execute()) {
        // Obtener el nuevo promedio de calificación
        $sql = "SELECT AVG(calificacion) as promedio, COUNT(*) as total FROM comentarios_tecnicos WHERE tecnico_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $tecnico_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();

        echo json_encode([
            "success" => true,
            "promedio" => round($data['promedio'], 1),
            "total" => $data['total']
        ]);
    } else {
        echo json_encode(["success" => false]);
    }

    $stmt->close();
    $conn->close();
}
?>
