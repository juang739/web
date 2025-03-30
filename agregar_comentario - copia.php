<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vendedor_id = $_POST['vendedor_id'];
    $usuario = $_POST['usuario'];
    $comentario = $_POST['comentario'];
    $calificacion = $_POST['calificacion'];

    $sql = "INSERT INTO comentarios_vendedores (vendedor_id, usuario, comentario, calificacion, fecha) VALUES (?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issi", $vendedor_id, $usuario, $comentario, $calificacion);

    if ($stmt->execute()) {
        // Obtener el nuevo promedio de calificación
        $sql = "SELECT AVG(calificacion) as promedio, COUNT(*) as total FROM comentarios_vendedores WHERE vendedor_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $vendedor_id);
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
