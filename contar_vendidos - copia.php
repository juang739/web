<?php
$host = "localhost";
$user = "root";  
$pass = "";  
$dbname = "registro_usuarios";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$sql = "SELECT COUNT(*) AS vendidos FROM vendedor WHERE estado = 'Vendido'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode(["vendidos" => $row["vendidos"]]);
} else {
    echo json_encode(["vendidos" => 0]);
}

$conn->close();
?>
