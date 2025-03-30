<?php
include 'db.php';

header('Content-Type: application/json');

$sql = "
     
    SELECT id, nombre, correo, celular, producto, descripcion, precio, ciudad, horario_venta, pagina_web, edad, 'Vendedor' AS tipo, foto, estado, NULL AS empresa, NULL AS horarios, NULL AS tarjeta_profesional 
    FROM vendedor
    UNION ALL
    SELECT NULL AS id, nombre, correo, celular, NULL AS producto, descripcion_lugar AS descripcion, NULL AS precio, ciudad, NULL AS horario_venta, NULL AS pagina_web, NULL AS edad, 'Técnico' AS tipo, foto, NULL AS estado, empresa, horarios, tarjeta_profesional
    FROM tecnico";
    

$result = $conn->query($sql);

$productos = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $productos[] = $row;
    }
}

echo json_encode($productos);
$conn->close();
?>


