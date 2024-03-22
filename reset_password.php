<?php
session_start();
require_once 'config/config.php'; // Asegúrate de configurar correctamente la conexión a la base de datos


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $table_name = "usuario";

    // Ensure the database connection variables are defined
    global $db_host, $db_user, $db_pass, $db_name;

    // Create a new database connection
    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Verifica si el correo electrónico existe en la base de datos
    $query = "SELECT * FROM $table_name WHERE Correo = ?";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Genera un código de recuperación
            $recovery_code = bin2hex(random_bytes(16));

            // Envía el correo electrónico con el código de recuperación
            $to = $email;
            $subject = "Recuperación de Contraseña";
            $message = "Por favor, visita el siguiente enlace para recuperar tu contraseña: " .
                        "http://localhost/proyectoNomina/index_Ncontrase%C3%B1a.php";
            $headers = "From: noreply@yourwebsite.com";

            // Envía el correo electrónico
            if (mail($to, $subject, $message, $headers)) {
                // Muestra el mensaje de éxito en un alert
                echo "<script>";
                echo "alert('Se ha enviado un correo electrónico con instrucciones para recuperar tu contraseña.');";
                echo "window.location.href = 'index.html';";
                echo "</script>";
            } else {
                echo "Error al enviar el correo electrónico.";
            }
        } else {
            echo "El correo electrónico ingresado no existe en nuestra base de datos.";
        }
    } else {
        echo "Error al preparar la consulta de verificación del correo electrónico: " . $conn->error;
    }

    // Cierra la conexión a la base de datos
    $stmt->close();
    $conn->close();
}
?>
