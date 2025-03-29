<?php
include 'db.php';

header('Content-Type: application/json');

$producto = isset($_GET['producto']) ? $conn->real_escape_string($_GET['producto']) : '';
$precio = isset($_GET['precio']) ? $conn->real_escape_string($_GET['precio']) : '';

$sql = "SELECT nombre, correo, celular, producto, descripcion, precio, ciudad, horario_venta, pagina_web, edad, 'Vendedor' AS tipo, foto 
        FROM vendedor 
        WHERE 1";

if (!empty($producto)) {
    $sql .= " AND producto LIKE '%$producto%'";
}

if (!empty($precio)) {
    $sql .= " AND precio = $precio";
}

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
