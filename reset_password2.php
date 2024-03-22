<?php
session_start();
require_once 'config/config.php'; // Asegúrate de configurar correctamente la conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener el correo electrónico, la nueva contraseña y la confirmación
    $email = $_POST['email'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Verificar que las contraseñas coincidan
    if ($new_password !== $confirm_password) {
        die("Las contraseñas no coinciden.");
    }

    // Ensure the database connection variables are defined
    global $db_host, $db_user, $db_pass, $db_name;

    // Create a new database connection
    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Verificar si el correo electrónico existe en la base de datos
    $query = "SELECT * FROM usuario WHERE Correo = ?";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        if ($result->num_rows > 0) {
            // Hash the new password
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

            // Actualizar la contraseña en la base de datos
            $update_query = "UPDATE usuario SET Contraseña = ? WHERE Correo = ?";
            if ($update_stmt = $conn->prepare($update_query)) {
                $update_stmt->bind_param('ss', $new_password, $email);
                if ($update_stmt->execute()) {
                    // Cerrar la conexión a la base de datos
                    $conn->close();
                    // Mostrar una alerta y redirigir al usuario
                    echo "<script>alert('¡Contraseña actualizada con éxito!'); window.location.href = 'index.html';</script>";
                    exit;
                } else {
                    echo "Error al actualizar la contraseña: " . $update_stmt->error;
                }
                $update_stmt->close();
            } else {
                echo "Error al preparar la consulta de actualización de contraseña: " . $conn->error;
            }
        } else {
            echo "El correo electrónico ingresado no existe en nuestra base de datos.";
        }
    } else {
        echo "Error al preparar la consulta de verificación del correo electrónico: " . $conn->error;
    }

    // Cierra la conexión a la base de datos
    $conn->close();
}
?>
