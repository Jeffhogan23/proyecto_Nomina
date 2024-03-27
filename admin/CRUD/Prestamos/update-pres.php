<?php
// Include config file
require '../../../config/database.php';    
$db = new Database();
$con = $db->conectar();

// Define variables and initialize with empty values
$IDpres = $IDusuario = $Fecha_pres = $Valor_pres = $CantidadCuotas = $ValorCuotas = $EstadoPres = "";
$IDpres_err = $IDusuario_err = $Fecha_pres_err = $Valor_pres_err = $CantidadCuotas_err = $ValorCuotas_err = $EstadoPres_err = "";

// Get the ID from the URL parameter
$IDpres = $_GET['id'] ?? null;

// Get the current row from the database
$sql = "SELECT * FROM prestamos WHERE IDpres = ?";
if ($stmt = mysqli_prepare($link, $sql)) {
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "i", $param_IDpres);
    // Set parameters
    $param_IDpres = $IDpres;
    // Attempt to execute the prepared statement
    if (mysqli_stmt_execute($stmt)) {
        /* Store result */
        mysqli_stmt_store_result($stmt);
        // Bind result variables
        mysqli_stmt_bind_result($stmt, $IDpres, $IDusuario, $Fecha_pres, $Valor_pres, $CantidadCuotas, $ValorCuotas, $EstadoPres);
        // Fetch the results
        if (mysqli_stmt_fetch($stmt)) {
            // Assign values to variables
        }
    } else {
        echo "Error executing query: " . mysqli_stmt_error($stmt);
    }
    // Close statement
    mysqli_stmt_close($stmt);
} else {
    echo "Error preparing query: " . mysqli_error($link);
}

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate IDpres
    $IDpres_err = empty(trim($_POST["IDpres"])) ? "Please enter the ID of the prestamo." : "";
    $IDpres = !empty(trim($_POST["IDpres"])) ? trim($_POST["IDpres"]) : $IDpres;

    // Validate IDusuario
    $IDusuario_err = empty(trim($_POST["IDusuario"])) ? "Please enter the ID of the usuario." : "";
    $IDusuario = !empty(trim($_POST["IDusuario"])) ? trim($_POST["IDusuario"]) : $IDusuario;

    // Validate Fecha_pres
    $Fecha_pres_err = empty(trim($_POST["Fecha_pres"])) ? "Please enter the Fecha of the prestamo." : "";
    $Fecha_pres = !empty(trim($_POST["Fecha_pres"])) ? trim($_POST["Fecha_pres"]) : $Fecha_pres;

    // Validate Valor_pres
    $Valor_pres_err = empty(trim($_POST["Valor_pres"])) ? "Please enter the Valor of the prestamo." : "";
    $Valor_pres = !empty(trim($_POST["Valor_pres"])) ? trim($_POST["Valor_pres"]) : $Valor_pres;

    // Validate CantidadCuotas
    $CantidadCuotas_err = empty(trim($_POST["CantidadCuotas"])) ? "Please enter the Cantidad of the cuotas." : "";
    $CantidadCuotas = !empty(trim($_POST["CantidadCuotas"])) ? trim($_POST["CantidadCuotas"]) : $CantidadCuotas;

    // Validate ValorCuotas
    $ValorCuotas_err = empty(trim($_POST["ValorCuotas"])) ? "Please enter the Valor of the cuotas." : "";
    $ValorCuotas = !empty(trim($_POST["ValorCuotas"])) ? trim($_POST["ValorCuotas"]) : $ValorCuotas;

    // Validate EstadoPres
    $EstadoPres_err = empty(trim($_POST["EstadoPres"])) ? "Please enter the Estado of the prestamo." : "";
    $EstadoPres = !empty(trim($_POST["EstadoPres"])) ? trim($_POST["EstadoPres"]) : $EstadoPres;

    // Check input errors before updating in database
    if (empty($IDpres_err) && empty($IDusuario_err) && empty($Fecha_pres_err) && empty($Valor_pres_err) && empty($CantidadCuotas_err) && empty($ValorCuotas_err) && empty($EstadoPres_err)) {

        // Prepare an update statement
        $sql = "UPDATE prestamos SET IDusuario=?, Fecha_pres=?, Valor_pres=?, CantidadCuotas=?, ValorCuotas=?, EstadoPres=? WHERE IDpres=?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "issdiss", $param_IDusuario, $param_Fecha_pres, $param_Valor_pres, $param_CantidadCuotas, $param_ValorCuotas, $param_EstadoPres, $param_IDpres);

            // Set parameters
            $param_IDusuario = $IDusuario;
            $param_Fecha_pres = $Fecha_pres;
            $param_Valor_pres = $Valor_pres;
            $param_CantidadCuotas = $CantidadCuotas;
            $param_ValorCuotas = $ValorCuotas;
            $param_EstadoPres = $EstadoPres;
            $param_IDpres = $IDpres;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Redirect to list page
                header("location: ../crud-Prestamos.php");
                exit();
            } else {
                echo "Something went wrong. Please try again later.";
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
    <title>Edit</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
    .wrapper {
        width: 500px;
        margin: 0 auto;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .btn {
        margin-top: 10px;
        margin-bottom: 10px;
        /* Agrega un margen inferior de 5 píxeles */
    }
    </style>
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Actualizar Prestamos</h2>
                    </div>
                    <p>Edita los campos de prestamos, si es necesario</p>
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                        <div class="form-group <?php echo (!empty($IDpres_err)) ? 'has-error' : ''; ?>">
                            <label>ID Prestamo</label>
                            <input type="text" name="IDpres" class="form-control" value="<?php echo $IDpres; ?>"
                                readonly>
                            <span class="help-block"><?php echo $IDpres_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($IDusuario_err)) ? 'has-error' : ''; ?>">
                            <label>ID Usuario</label>
                            <input type="text" name="IDusuario" class="form-control" value="<?php echo $IDusuario; ?>">
                            <span class="help-block"><?php echo $IDusuario_err;?></span>
                        </div>

                        <div class="form-group <?php echo (!empty($Fecha_pres_err)) ? 'has-error' : ''; ?>">
                            <label>Fecha Prestamo</label>
                            <input type="date" name="Fecha_pres" class="form-control"
                                value="<?php echo $Fecha_pres; ?>">
                            <span class="help-block"><?php echo $Fecha_pres_err;?></span>
                        </div>


                        <div class="form-group <?php echo (!empty($Valor_pres_err)) ? 'has-error' : ''; ?>">
                            <label>Valor Prestamo</label>
                            <input type="text" name="Valor_pres" class="form-control"
                                value="<?php echo $Valor_pres; ?>">
                            <span class="help-block"><?php echo $Valor_pres_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($CantidadCuotas_err)) ? 'has-error' : ''; ?>">
                            <label>Cantidad Cuotas</label>
                            <input type="text" name="CantidadCuotas" class="form-control"
                                value="<?php echo $CantidadCuotas; ?>">
                            <span class="help-block"><?php echo $CantidadCuotas_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($ValorCuotas_err)) ? 'has-error' : ''; ?>">
                            <label>Valor Cuotas</label>
                            <input type="text" name="ValorCuotas" class="form-control"
                                value="<?php echo $ValorCuotas; ?>">
                            <span class="help-block"><?php echo $ValorCuotas_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($EstadoPres_err)) ? 'has-error' : ''; ?>">
                            <label>Estado Prestamo</label>
                            <input type="text" name="EstadoPres" class="form-control"
                                value="<?php echo $EstadoPres; ?>">
                            <span class="help-block"><?php echo $EstadoPres_err;?></span>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $IDpres; ?>" />
                        <input type="submit" class="btn btn-primary" value="Editar">
                        <a href="../crud-Prestamos.php" class="btn btn-default">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>