<?php
$host = "localhost";
$user = "root";  // Cambia esto si usas otro usuario
$pass = "";  // Deja vacío si usas XAMPP
$dbname = "registro_usuarios";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
