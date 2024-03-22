<?php
// Include config file
require '../../../config/database.php';    
$db = new Database();
$con = $db->conectar();

// Define variables and initialize with empty values
$id = $tipo = $monto = "";
$id_err = $tipo_err = $monto_err = "";

// Get the ID from the URL parameter
$id = $_GET['id'];

// Get the current row from the database
$sql = "SELECT * FROM bonificaciones WHERE IDBonificacion = ?";
if ($stmt = mysqli_prepare($link, $sql)) {
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "i", $param_id);
    // Set parameters
    $param_id = $id;
    // Attempt to execute the prepared statement
    if (mysqli_stmt_execute($stmt)) {
        /* store result */
        mysqli_stmt_store_result($stmt);
        // Bind result variables
        mysqli_stmt_bind_result($stmt, $id, $tipo, $monto);
        // Fetch the results
        if (mysqli_stmt_fetch($stmt)) {
            $tipo = $tipo;
            $monto = $monto;
        }
    }
    // Close statement
    mysqli_stmt_close($stmt);
}

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate tipo
    if (empty(trim($_POST["tipo"]))) {
        $tipo_err = "Por favor ingrese el tipo de bonificación.";
    } else {
        $tipo = trim($_POST["tipo"]);
    }

    // Validate monto
    if (empty(trim($_POST["monto"]))) {
        $monto_err = "Por favor ingrese el monto de bonificación.";
    } else {
        $monto = trim($_POST["monto"]);
    }

    // Check input errors before updating in database
    if (empty($tipo_err) && empty($monto_err)) {

        // Prepare an update statement
        $sql = "UPDATE bonificaciones SET TipoBonificacion=?, MontoBonificacion=? WHERE IDBonificacion=?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sdi", $param_tipo, $param_monto, $param_id);

            // Set parameters
            $param_tipo = $tipo;
            $param_monto = $monto;
            $param_id = $id;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Redirect to list page
                header("location: ../crud-Bonificaciones.php");
            } else {
                echo "Algo salió mal. Por favor, inténtelo de nuevo más tarde.";
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
    <title>Editar Bonificación</title>
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
                        <h2>Actualizar Bonificación</h2>
                    </div>
                    <p>Edite los valores de entrada y envíe para actualizar la bonificación.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group <?php echo (!empty($tipo_err)) ? 'has-error' : ''; ?>">
                            <label>Tipo de Bonificación</label>
                            <input type="text" name="tipo" class="form-control" value="<?php echo $tipo; ?>">
                            <span class="help-block"><?php echo $tipo_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($monto_err)) ? 'has-error' : ''; ?>">
                            <label>Monto de Bonificación</label>
                            <input type="text" name="monto" class="form-control" value="<?php echo $monto; ?>">
                            <span class="help-block"><?php echo $monto_err;?></span>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Enviar">
                        <a href="../crud-Bonificaciones.php" class="btn btn-default">Cancelar</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
