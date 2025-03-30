<?php
include 'db.php';
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cedula = mysqli_real_escape_string($conn, $_POST["cedula"]);

    $sql = "SELECT cedula FROM comprador WHERE cedula='$cedula'
            UNION
            SELECT cedula FROM vendedor WHERE cedula='$cedula'
            UNION
            SELECT cedula FROM tecnico WHERE cedula='$cedula'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Cédula no registrada"]);
    }

    $conn->close();
} else {
    echo json_encode(["status" => "error", "message" => "Método no permitido"]);
}
?>
