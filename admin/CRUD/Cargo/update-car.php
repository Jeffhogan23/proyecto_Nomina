<?php
// Include config file
require '../../../config/database.php';    
$db = new Database();
$con = $db->conectar();

// Define variables and initialize with empty values
$id = $nombre = $salario = "";
$id_err = $nombre_err = $salario_err = "";

// Get the ID from the URL parameter
$id = $_GET['id'];

// Get the current row from the database
$sql = "SELECT * FROM cargo WHERE IDcargo = ?";
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
        mysqli_stmt_bind_result($stmt, $id, $nombre, $salario);
        // Fetch the results
        if (mysqli_stmt_fetch($stmt)) {
            $nombre = $nombre;
            $salario = $salario;
        }
    }
    // Close statement
    mysqli_stmt_close($stmt);
}

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate nombre
    if (empty(trim($_POST["nombre"]))) {
        $nombre_err = "Por favor ingrese el nombre del cargo.";
    } else {
        $nombre = trim($_POST["nombre"]);
    }

    // Validate salario
    if (empty(trim($_POST["salario"]))) {
        $salario_err = "Por favor ingrese el salario del cargo.";
    } else {
        $salario = trim($_POST["salario"]);
    }

    // Check input errors before updating in database
    if (empty($nombre_err) && empty($salario_err)) {

        // Prepare an update statement
        $sql = "UPDATE cargo SET NombreCargo=?, SalarioCargo=? WHERE IDcargo=?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sdi", $param_nombre, $param_salario, $param_id);

            // Set parameters
            $param_nombre = $nombre;
            $param_salario = $salario;
            $param_id = $id;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Redirect to list page
                header("location: ../crud-Cargo.php");
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
    <title>Editar Cargo</title>
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
                        <h2>Actualizar Cargo</h2>
                    </div>
                    <p>Edite los valores de entrada y envíe para actualizar el cargo.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group <?php echo (!empty($nombre_err)) ? 'has-error' : ''; ?>">
                            <label>Nombre del Cargo</label>
                            <input type="text" name="nombre" class="form-control" value="<?php echo $nombre; ?>">
                            <span class="help-block"><?php echo $nombre_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($salario_err)) ? 'has-error' : ''; ?>">
                            <label>Salario del Cargo</label>
                            <input type="text" name="salario" class="form-control" value="<?php echo $salario; ?>">
                            <span class="help-block"><?php echo $salario_err;?></span>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Enviar">
                        <a href="crud-cargo.php" class="btn btn-default">Cancelar</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
