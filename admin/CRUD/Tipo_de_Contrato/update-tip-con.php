<?php
// Include config file
require '../../../config/database.php';    
$db = new Database();
$con = $db->conectar();

// Define variables and initialize with empty values
$id = $nombre_tipo_contrato = "";
$id_err = $nombre_tipo_contrato_err = "";

// Get the ID from the URL parameter
$id = $_GET['id'];

// Get the current row from the database
$sql = "SELECT * FROM tipocontrato WHERE IDtipContrato = ?";
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
        mysqli_stmt_bind_result($stmt, $id, $nombre_tipo_contrato);
        // Fetch the results
        if (mysqli_stmt_fetch($stmt)) {
            $nombre_tipo_contrato = $nombre_tipo_contrato;
        }
    }
    // Close statement
    mysqli_stmt_close($stmt);
}

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate nombre_tipo_contrato
    if (empty(trim($_POST["nombre_tipo_contrato"]))) {
        $nombre_tipo_contrato_err = "Por favor ingrese el nombre del tipo de contrato.";
    } else {
        $nombre_tipo_contrato = trim($_POST["nombre_tipo_contrato"]);
    }

    // Check input errors before updating in database
    if (empty($nombre_tipo_contrato_err)) {

        // Prepare an update statement
        $sql = "UPDATE tipocontrato SET NombreTipContrato = ? WHERE IDtipContrato = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "si", $param_nombre_tipo_contrato, $param_id);

            // Set parameters
            $param_nombre_tipo_contrato = $nombre_tipo_contrato;
            $param_id = $id;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Redirect to list page
                header("location: ../crud-Tipocontrato.php");
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
    <title>Editar Tipo de Contrato</title>
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
                        <h2>Actualizar Tipo de Contrato</h2>
                    </div>
                    <p>Edite los valores de entrada y envíe para actualizar el registro.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group <?php echo (!empty($nombre_tipo_contrato_err)) ? 'has-error' : ''; ?>">
                            <label>Nombre del Tipo de Contrato</label>
                            <input type="text" name="nombre_tipo_contrato" class="form-control" value="<?php echo $nombre_tipo_contrato; ?>">
                            <span class="help-block"><?php echo $nombre_tipo_contrato_err;?></span>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Enviar">
                        <a href="../crud-Tipocontrato.php" class="btn btn-default">Cancelar</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>