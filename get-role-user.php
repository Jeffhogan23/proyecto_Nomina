<?php
include_once 'conexion.php';

$email = $_POST['email'];
$password = $_POST['password'];

$query = "SELECT * FROM usuarios WHERE Correo = '$email' AND Contraseña = '$password'";
$result = mysqli_query($link, $query);

if (mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
    $userRole = $user['Id_rol'];

    echo json_encode(['userRole' => $userRole]);
} else {
    echo json_encode(['userRole' => false]);
}

mysqli_close($link);
?>