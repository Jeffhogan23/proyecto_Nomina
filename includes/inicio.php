<?php 
session_start();

require '../config/database.php';
$db = new Database();
$con = $db->conectar();

if($_POST["inicio"]){
    $correo = $_POST["email"];
	$clave = $_POST["password"];
    if ($correo == "" || $clave == "")
    {
        echo"<script>alert('Datos Vacios')</script>";
	    echo"<script>window.location='../index_iniciar_sesion.html'</script>";
    }
    else
    {
        $sql = $con->prepare("SELECT * FROM usuario LEFT OUTER JOIN roles ON usuario.IDrol = roles.IDrol WHERE usuario.Correo = '$correo' AND usuario.Contraseña = '$clave'");
        $sql->execute();
        $fila = $sql->fetch();
        
        if ($fila) {
            $_SESSION['usuario'] = $fila['IDusuario'];
            $_SESSION['tipo'] = $fila['IDrol'];
            if ($_SESSION['tipo'] == 3) {
                header("Location: ../registrados/b_empleo.php");
                exit();
            }
            if ($_SESSION['tipo'] == 2) {
                header("Location: ../users/index-contador.php");
                exit();
            }
            if ($_SESSION['tipo'] == 1) {
                header("Location: ../admin/index-admin.php");
                exit();
            }
        }
        else
        {
            echo"<script>alert('Credenciales invalidas o usuario inactivo.')</script>";
            echo"<script>window.location='../index_iniciar_sesion.html'</script>";
            exit();
        }
}
}	
?>