<?php
include 'db.php';

header('Content-Type: application/json');

$response = ["status" => "error", "message" => "Error desconocido"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitizar y obtener datos obligatorios
    $nombre = isset($_POST["nombre"]) ? trim(mysqli_real_escape_string($conn, $_POST["nombre"])) : "";
    $cedula = isset($_POST["cedula"]) ? trim(mysqli_real_escape_string($conn, $_POST["cedula"])) : "";
    $celular = isset($_POST["celular"]) ? trim(mysqli_real_escape_string($conn, $_POST["celular"])) : "";
    $correo = isset($_POST["correo"]) ? trim(mysqli_real_escape_string($conn, $_POST["correo"])) : "";

    if ($nombre === "" || $cedula === "" || $celular === "" || $correo === "") {
        echo json_encode(["status" => "error", "message" => "Todos los campos son obligatorios"]);
        exit;
    }

    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(["status" => "error", "message" => "Correo inválido"]);
        exit;
    }

    // Verificar si la cédula ya está registrada en cualquier tabla
    $check_sql = "SELECT cedula FROM comprador WHERE cedula='$cedula'
                  UNION
                  SELECT cedula FROM vendedor WHERE cedula='$cedula'
                  UNION
                  SELECT cedula FROM tecnico WHERE cedula='$cedula'";
    
    $check_result = $conn->query($check_sql);

    if ($check_result->num_rows > 0) {
        echo json_encode(["status" => "error", "message" => "La cédula ya está registrada"]);
        exit;
    }

    // Determinar tipo de usuario (Comprador, Vendedor o Técnico)
    if (isset($_POST["producto"])) {  
        // 📌 Cliente Vendedor
        $producto = isset($_POST["producto"]) ? trim(mysqli_real_escape_string($conn, $_POST["producto"])) : "";
        $precio = isset($_POST["precio"]) ? trim(mysqli_real_escape_string($conn, $_POST["precio"])) : "0";
        $descripcion = isset($_POST["descripcion"]) ? trim(mysqli_real_escape_string($conn, $_POST["descripcion"])) : "";

        $edad = isset($_POST["edad"]) ? "'" . trim(mysqli_real_escape_string($conn, $_POST["edad"])) . "'" : "NULL";
        $horario_venta = isset($_POST["horario_venta"]) ? "'" . trim(mysqli_real_escape_string($conn, $_POST["horario_venta"])) . "'" : "NULL";
        $ciudad = isset($_POST["ciudad"]) ? "'" . trim(mysqli_real_escape_string($conn, $_POST["ciudad"])) . "'" : "NULL";
        $pagina_web = isset($_POST["pagina_web"]) ? "'" . trim(mysqli_real_escape_string($conn, $_POST["pagina_web"])) . "'" : "NULL";

        $sql = "INSERT INTO vendedor (nombre, cedula, celular, correo, producto, precio, descripcion, edad, horario_venta, ciudad, pagina_web) 
                VALUES ('$nombre', '$cedula', '$celular', '$correo', '$producto', '$precio', '$descripcion', $edad, $horario_venta, $ciudad, $pagina_web)";

    } elseif (isset($_POST["empresa"])) {  
        // 📌 Cliente Técnico
        $empresa = isset($_POST["empresa"]) ? trim(mysqli_real_escape_string($conn, $_POST["empresa"])) : "";
        $horarios = isset($_POST["horarios"]) ? trim(mysqli_real_escape_string($conn, $_POST["horarios"])) : "";
        $descripcion_lugar = isset($_POST["descripcion_lugar"]) ? trim(mysqli_real_escape_string($conn, $_POST["descripcion_lugar"])) : "";
        $tarjeta_profesional = isset($_POST["tarjeta_profesional"]) ? trim(mysqli_real_escape_string($conn, $_POST["tarjeta_profesional"])) : "";
        $ciudad = isset($_POST["ciudad"]) ? "'" . trim(mysqli_real_escape_string($conn, $_POST["ciudad"])) . "'" : "NULL";

        $sql = "INSERT INTO tecnico (nombre, celular, correo, cedula, empresa, horarios, descripcion_lugar, tarjeta_profesional, ciudad) 
                VALUES ('$nombre', '$celular', '$correo', '$cedula', '$empresa', '$horarios', '$descripcion_lugar', '$tarjeta_profesional', $ciudad)";

    } else {
        // 📌 Cliente Comprador
        $sql = "INSERT INTO comprador (nombre, cedula, celular, correo) VALUES ('$nombre', '$cedula', '$celular', '$correo')";
    }

    // Ejecutar consulta
    if ($conn->query($sql) === TRUE) {
        $response = ["status" => "success", "message" => "Registro exitoso"];
    } else {
        $response = ["status" => "error", "message" => "Error en la consulta: " . $conn->error];
    }

    $conn->close();
} else {
    $response = ["status" => "error", "message" => "Método no permitido"];
}

echo json_encode($response);
?>
