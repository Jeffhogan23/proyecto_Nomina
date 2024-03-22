<?php
require 'config/database.php';
$db = new Database();
$con = $db->conectar();

if (isset($_GET['idDep'])) {
    $idDep = $_GET['idDep'];

    $sql_ciudades = "SELECT IDciu, NombreCiu FROM ciudad WHERE IDdep = '$idDep'";
    $resultado_ciudades = mysqli_query($link, $sql_ciudades);

    $opciones_ciudades = "<option value=''>Seleccione una ciudad</option>";
    while ($row_ciudad = mysqli_fetch_assoc($resultado_ciudades)) {
        $opciones_ciudades .= "<option value='" . $row_ciudad['IDciu'] . "'>" . $row_ciudad['NombreCiu'] . "</option>";
    }

    echo $opciones_ciudades;
} else {
    echo "<option value=''>Seleccione un departamento primero</option>";
}
?>