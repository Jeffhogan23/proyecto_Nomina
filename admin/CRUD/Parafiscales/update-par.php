<?php
// Include config file
require '../../../config/database.php';    
$db = new Database();
$con = $db->conectar();

// Define variables and initialize with empty values
$id = $tipoParafiscal = $tasaParafiscal = "";
$id_err = $tipoParafiscal_err = $tasaParafiscal_err = "";

// Get the ID from the URL parameter
$id = $_GET['id'];

// Get the current row from the database
$sql = "SELECT * FROM parafiscales WHERE IDparafiscal = ?";
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
        mysqli_stmt_bind_result($stmt, $id, $tipoParafiscal, $tasaParafiscal);
        // Fetch the results
        if (mysqli_stmt_fetch($stmt)) {
            $tipoParafiscal = $tipoParafiscal;
            $tasaParafiscal = $tasaParafiscal;
        }
    }
    // Close statement
    mysqli_stmt_close($stmt);
}

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate tipoParafiscal
    if (empty(trim($_POST["tipoParafiscal"]))) {
        $tipoParafiscal_err = "Por favor ingrese el tipo de parafiscal.";
    } else {
        $tipoParafiscal = trim($_POST["tipoParafiscal"]);
    }

    // Validate tasaParafiscal
    if (empty(trim($_POST["tasaParafiscal"]))) {
        $tasaParafiscal_err = "Por favor ingrese la tasa del parafiscal.";
    } elseif (!is_numeric(trim($_POST["tasaParafiscal"]))) {
        $tasaParafiscal_err = "La tasa del parafiscal debe ser un valor numérico.";
    } else {
        $tasaParafiscal = trim($_POST["tasaParafiscal"]);
    }

    // Check input errors before updating in database
    if (empty($tipoParafiscal_err) && empty($tasaParafiscal_err)) {

        // Prepare an update statement
        $sql = "UPDATE parafiscales SET TipoParafiscal = ?, TasaParafiscal = ? WHERE IDparafiscal = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sdi", $param_tipoParafiscal, $param_tasaParafiscal, $param_id);

            // Set parameters
            $param_tipoParafiscal = $tipoParafiscal;
            $param_tasaParafiscal = $tasaParafiscal;
            $param_id = $id;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Redirect to list page
                header("location: ../crud-Parafiscales.php");
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
    <title>Editar Parafiscal</title>
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
                        <h2>Actualizar Parafiscal</h2>
                    </div>
                    <p>Edite los valores de entrada y envíe para actualizar el registro.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group <?php echo (!empty($tipoParafiscal_err)) ? 'has-error' : ''; ?>">
                            <label>Tipo de Parafiscal</label>
                            <input type="text" name="tipoParafiscal" class="form-control" value="<?php echo $tipoParafiscal; ?>">
                            <span class="help-block"><?php echo $tipoParafiscal_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($tasaParafiscal_err)) ? 'has-error' : ''; ?>">
                            <label>Tasa del Parafiscal</label>
                            <input type="text" name="tasaParafiscal" class="form-control" value="<?php echo $tasaParafiscal; ?>">
                            <span class="help-block"><?php echo $tasaParafiscal_err;?></span>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Enviar">
                        <a href="../crud-Parafiscales.php" class="btn btn-default">Cancelar</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>