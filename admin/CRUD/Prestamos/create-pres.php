<?php
// Include config file
require '../../../config/database.php';    
$db = new Database();
$con = $db->conectar();

// Define variables and initialize with empty values
$idusuario = "";
$idusuario_err = "";
$fechaprestamo = "";
$fechaprestamo_err = "";
$valorprestamo = "";
$valorprestamo_err = "";
$cantidadcuotas = "";
$cantidadcuotas_err = "";
$valorcuotas = "";
$valorcuotas_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate idusuario
    $input_idusuario = trim($_POST["idusuario"]);
    if(empty($input_idusuario)){
        $idusuario_err = "Por favor ingrese el ID del usuario.";
    } elseif(!ctype_digit($input_idusuario)) {
        $idusuario_err = "Por favor ingrese un ID de usuario válido (solo números).";
    } else{
        $idusuario = $input_idusuario;
    }

    // Validate fechaprestamo
    $input_fechaprestamo = trim($_POST["fechaprestamo"]);
    if(empty($input_fechaprestamo)){
        $fechaprestamo_err = "Por favor ingrese la fecha del préstamo.";
    } else{
        $fechaprestamo = $input_fechaprestamo;
    }

    // Validate valorprestamo
    $input_valorprestamo = trim($_POST["valorprestamo"]);
    if(empty($input_valorprestamo)){
        $valorprestamo_err = "Por favor ingrese el valor del préstamo.";
    } elseif(!is_numeric($input_valorprestamo)) {
        $valorprestamo_err = "Por favor ingrese un valor de préstamo válido (solo números).";
    } else{
        $valorprestamo = $input_valorprestamo;
    }

    // Validate cantidadcuotas
    $input_cantidadcuotas = trim($_POST["cantidadcuotas"]);
    if(empty($input_cantidadcuotas)){
        $cantidadcuotas_err = "Por favor ingrese la cantidad de cuotas.";
    } elseif(!ctype_digit($input_cantidadcuotas)) {
        $cantidadcuotas_err = "Por favor ingrese una cantidad de cuotas válida (solo números).";
    } else{
        $cantidadcuotas = $input_cantidadcuotas;
    }

    // Validate valorcuotas
    $input_valorcuotas = trim($_POST["valorcuotas"]);
    if(empty($input_valorcuotas)){
        $valorcuotas_err = "Por favor ingrese el valor de las cuotas.";
    } elseif(!is_numeric($input_valorcuotas)) {
        $valorcuotas_err = "Por favor ingrese un valor de cuotas válido (solo números).";
    } else{
        $valorcuotas = $input_valorcuotas;
    }

    // Check input errors before inserting in database
    if(empty($idusuario_err) && empty($fechaprestamo_err) && empty($valorprestamo_err) && empty($cantidadcuotas_err) && empty($valorcuotas_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO prestamos (IDusuario, Fecha_pres, Valor_pres, CantidadCuotas, ValorCuotas) VALUES (?, ?, ?, ?, ?)";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "isiii", $param_idusuario, $param_fechaprestamo, $param_valorprestamo, $param_cantidadcuotas, $param_valorcuotas);

            // Set parameters
            $param_idusuario = $idusuario;
            $param_fechaprestamo = $fechaprestamo;
            $param_valorprestamo = $valorprestamo;
            $param_cantidadcuotas = $cantidadcuotas;
            $param_valorcuotas = $valorcuotas;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: ../crud-Prestamos.php");
                exit();
            } else{
                echo "Algo salió mal. Por favor, inténtelo de nuevo";
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
    <title>Crear Préstamo</title>
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
                        <h2>Crear Préstamo</h2>
                    </div>
                    <p>Favor diligenciar el siguiente formulario para crear un nuevo préstamo.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

                        <div class="form-group <?php echo (!empty($idusuario_err)) ? 'has-error' : ''; ?>">
                            <label>ID del Usuario</label>
                            <input type="text" name="idusuario" class="form-control" value="<?php echo $idusuario; ?>">
                            <span class="help-block"><?php echo $idusuario_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($fechaprestamo_err)) ? 'has-error' : ''; ?>">
                            <label>Fecha del Préstamo</label>
                            <input type="date" name="fechaprestamo" class="form-control" value="<?php echo $fechaprestamo; ?>">
                            <span class="help-block"><?php echo $fechaprestamo_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($valorprestamo_err)) ? 'has-error' : ''; ?>">
                            <label>Valor del Préstamo</label>
                            <input type="text" name="valorprestamo" class="form-control" value="<?php echo $valorprestamo; ?>">
                            <span class="help-block"><?php echo $valorprestamo_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($cantidadcuotas_err)) ? 'has-error' : ''; ?>">
                            <label>Cantidad de Cuotas</label>
                            <input type="text" name="cantidadcuotas" class="form-control" value="<?php echo $cantidadcuotas; ?>">
                            <span class="help-block"><?php echo $cantidadcuotas_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($valorcuotas_err)) ? 'has-error' : ''; ?>">
                            <label>Valor de las Cuotas</label>
                            <input type="text" name="valorcuotas" class="form-control" value="<?php echo $valorcuotas; ?>">
                            <span class="help-block"><?php echo $valorcuotas_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Agregar">
                        <a href="../crud-Prestamos.php" class="btn btn-default">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>