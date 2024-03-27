<?php
// Include config file
require '../../../config/database.php';    
$db = new Database();
$con = $db->conectar();

// Define variables and initialize with empty values
$id = $id_usuario = $fecha_nomina = $mes = $dias_trabajados = $salario_neto = $valor_parafiscales = $valor_prestamo = $total_deducidos = $id_bonificacion = $neto_pagado = "";
$id_err = $id_usuario_err = $fecha_nomina_err = $mes_err = $dias_trabajados_err = $salario_neto_err = $valor_parafiscales_err = $valor_prestamo_err = $total_deducidos_err = $id_bonificacion_err = $neto_pagado_err = "";

// Get the ID from the URL parameter
$id = $_GET['id'];

// Get the current row from the database
$sql = "SELECT * FROM nomina WHERE IDNomina = ?";
if ($stmt = mysqli_prepare($link, $sql)) {
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "i", $id);
    // Attempt to execute the prepared statement
    if (mysqli_stmt_execute($stmt)) {
        /* store result */
        mysqli_stmt_store_result($stmt);
        // Bind result variables
        mysqli_stmt_bind_result($stmt, $id, $id_usuario, $fecha_nomina, $mes, $dias_trabajados, $salario_neto, $valor_parafiscales, $valor_prestamo, $total_deducidos, $id_bonificacion, $neto_pagado);
        // Fetch the results
        if (mysqli_stmt_fetch($stmt)) {
            $id_usuario = $id_usuario;
            $fecha_nomina = $fecha_nomina;
            $mes = $mes;
            $dias_trabajados = $dias_trabajados;
            $salario_neto = $salario_neto;
            $valor_parafiscales = $valor_parafiscales;
            $valor_prestamo = $valor_prestamo;
            $total_deducidos = $total_deducidos;
            $id_bonificacion = $id_bonificacion;
            $neto_pagado = $neto_pagado;
        }
    }
    // Close statement
    mysqli_stmt_close($stmt);
}

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate id_usuario
    if (empty(trim($_POST["id_usuario"]))) {
        $id_usuario_err = "Por favor seleccione un empleado.";
    } else {
        $id_usuario = trim($_POST["id_usuario"]);
    }

    // Validate fecha_nomina
    $fecha_nomina = trim($_POST["fecha_nomina"]);

    // Validate mes
    if (empty(trim($_POST["mes"]))) {
        $mes_err = "Por favor ingrese el mes.";
    } else {
        $mes = trim($_POST["mes"]);
    }

    // Validate dias_trabajados
    if (empty(trim($_POST["dias_trabajados"]))) {
        $dias_trabajados_err = "Por favor ingrese los días trabajados.";
    } else {
        $dias_trabajados = trim($_POST["dias_trabajados"]);
    }

    // Validate salario_neto
    if (empty(trim($_POST["salario_neto"]))) {
        $salario_neto_err = "Por favor ingrese el salario neto.";
    } else {
        $salario_neto = trim($_POST["salario_neto"]);
    }

    // Validate valor_parafiscales
    if (empty(trim($_POST["valor_parafiscales"]))) {
        $valor_parafiscales_err = "Por favor ingrese el valor de los parafiscales.";
    } else {
        $valor_parafiscales = trim($_POST["valor_parafiscales"]);
    }

    // Validate valor_prestamo
    if (empty(trim($_POST["valor_prestamo"]))) {
        $valor_prestamo_err = "Por favor ingrese el valor del préstamo.";
    } else {
        $valor_prestamo = trim($_POST["valor_prestamo"]);
    }

    // Validate total_deducidos
    if (empty(trim($_POST["total_deducidos"]))) {
        $total_deducidos_err = "Por favor ingrese el total deducido.";
    } else {
        $total_deducidos = trim($_POST["total_deducidos"]);
    }

    // Validate id_bonificacion
    if (empty(trim($_POST["id_bonificacion"]))) {
        $id_bonificacion_err = "Por favor seleccione una bonificación.";
    } else {
        $id_bonificacion = trim($_POST["id_bonificacion"]);
    }

    // Validate neto_pagado
    if (empty(trim($_POST["neto_pagado"]))) {
        $neto_pagado_err = "Por favor ingrese el neto pagado.";
    } else {
        $neto_pagado = trim($_POST["neto_pagado"]);
    }

    // Check input errors before updating in database
    if (empty($id_usuario_err) && empty($fecha_nomina_err) && empty($mes_err) && empty($dias_trabajados_err) && empty($salario_neto_err) && empty($valor_parafiscales_err) && empty($valor_prestamo_err) && empty($total_deducidos_err) && empty($id_bonificacion_err) && empty($neto_pagado_err)) {

        $sql = "UPDATE nomina SET IDusuario = ?, FechaNomina = ?, Mes = ?, DiasTrabajados = ?, SalarioNeto = ?, ValorParafiscales = ?, ValorPrestamo = ?, TotalDeducidos = ?, IDBonificacion = ?, NetoPagado = ? WHERE IDNomina = ?";
        $stmt = $con->prepare($sql);
            
        if ($stmt) {
            $stmt->bindParam(1, $id_usuario);
            $stmt->bindParam(2, $fecha_nomina);
            $stmt->bindParam(3, $mes);
            $stmt->bindParam(4, $dias_trabajados);
            $stmt->bindParam(5, $salario_neto);
            $stmt->bindParam(6, $valor_parafiscales);
            $stmt->bindParam(7, $valor_prestamo);
            $stmt->bindParam(8, $total_deducidos);
            $stmt->bindParam(9, $id_bonificacion);
            $stmt->bindParam(10, $neto_pagado);
            $stmt->bindParam(11, $id);
        
            if($stmt->execute()){
                header("location:../crud-Nomina.php");
                exit();
            } else{
                echo "Algo salió mal. Por favor, inténtalo de nuevo más tarde.";
            }
        }
        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Close connection
    mysqli_close($link);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Editar Nómina</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Actualizar Nómina</h2>
                    </div>
                    <p>Edite los valores de entrada y envíe para actualizar el registro.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group <?php echo (!empty($id_usuario_err)) ? 'has-error' : ''; ?>">
                            <label>Usuario</label>
                            <select name="id_usuario" class="form-control">
                                <option value="" selected disabled>Seleccione un usuario</option>
                                <?php
                                // Consulta para obtener los empleados
                                $sql_empleados = "SELECT u.IDusuario, CONCAT(u.Nombre, ' ', u.Apellido) AS NombreCompleto 
                                                FROM usuario u";
                                $result_empleados = mysqli_query($link, $sql_empleados);
                                while ($row_empleados = mysqli_fetch_assoc($result_empleados)) {
                                    $selected = ($row_empleados['IDusuario'] == $id_usuario) ? 'selected' : '';
                                    echo '<option value="' . $row_empleados['IDusuario'] . '" ' . $selected . '>' . $row_empleados['NombreCompleto'] . '</option>';
                                }
                                ?>
                            </select>
                            <span class="help-block"><?php echo $id_usuario_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($fecha_nomina_err)) ? 'has-error' : ''; ?>">
                            <label>Fecha de Nómina</label>
                            <input type="date" name="fecha_nomina" class="form-control" value="<?php echo $fecha_nomina; ?>">
                            <span class="help-block"><?php echo $fecha_nomina_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($mes_err)) ? 'has-error' : ''; ?>">
                            <label>Mes</label>
                            <input type="text" name="mes" class="form-control" value="<?php echo $mes; ?>">
                            <span class="help-block"><?php echo $mes_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($dias_trabajados_err)) ? 'has-error' : ''; ?>">
                            <label>Días Trabajados</label>
                            <input type="number" name="dias_trabajados" class="form-control" value="<?php echo $dias_trabajados; ?>">
                            <span class="help-block"><?php echo $dias_trabajados_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($salario_neto_err)) ? 'has-error' : ''; ?>">
                            <label>Salario Neto</label>
                            <input type="number" step="0.01" name="salario_neto" class="form-control" value="<?php echo $salario_neto; ?>">
                            <span class="help-block"><?php echo $salario_neto_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($valor_parafiscales_err)) ? 'has-error' : ''; ?>">
                            <label>Valor Parafiscales</label>
                            <input type="number" step="0.01" name="valor_parafiscales" class="form-control" value="<?php echo $valor_parafiscales; ?>">
                            <span class="help-block"><?php echo $valor_parafiscales_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($valor_prestamo_err)) ? 'has-error' : ''; ?>">
                            <label>Valor Préstamo</label>
                            <input type="number" step="0.01" name="valor_prestamo" class="form-control" value="<?php echo $valor_prestamo; ?>">
                            <span class="help-block"><?php echo $valor_prestamo_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($total_deducidos_err)) ? 'has-error' : ''; ?>">
                            <label>Total Deducidos</label>
                            <input type="number" step="0.01" name="total_deducidos" class="form-control" value="<?php echo $total_deducidos; ?>">
                            <span class="help-block"><?php echo $total_deducidos_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($id_bonificacion_err)) ? 'has-error' : ''; ?>">
                            <label>Bonificación</label>
                            <select name="id_bonificacion" class="form-control">
                                <option value="" selected disabled>Seleccione una bonificación</option>
                                <?php
                                // Consulta para obtener las bonificaciones
                                $sql_bonificaciones = "SELECT IDBonificacion, TipoBonificacion FROM bonificaciones";
                                $result_bonificaciones = mysqli_query($link, $sql_bonificaciones);
                                while ($row_bonificaciones = mysqli_fetch_assoc($result_bonificaciones)) {
                                    $selected = ($row_bonificaciones['IDBonificacion'] == $id_bonificacion) ? 'selected' : '';
                                    echo '<option value="' . $row_bonificaciones['IDBonificacion'] . '" ' . $selected . '>' . $row_bonificaciones['TipoBonificacion'] . '</option>';
                                }
                                ?>
                            </select>
                            <span class="help-block"><?php echo $id_bonificacion_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($neto_pagado_err)) ? 'has-error' : ''; ?>">
                            <label>Neto Pagado</label>
                            <input type="number" step="0.01" name="neto_pagado" class="form-control" value="<?php echo $neto_pagado; ?>">
                            <span class="help-block"><?php echo $neto_pagado_err;?></span>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Enviar">
                        <a href="../crud-Nomina.php" class="btn btn-default">Cancelar</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>