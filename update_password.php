<?php
session_start();
require_once 'config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $user_id = $_SESSION['IDusuario'];
  $new_password = mysqli_real_escape_string($conn, $_POST['new_password']);
  $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
  $sql = "UPDATE usuario SET Contraseña = '$hashed_password' WHERE IDusuario = '$user_id'";
  if (mysqli_query($conn, $sql)) {
    http_response_code(200);
  } else {
    http_response_code(500);
  }
}
?>
