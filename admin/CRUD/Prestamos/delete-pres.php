<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Eliminar Registro</title>
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
                        <h1>Eliminar Registro</h1>
                    </div>
                    <p>¿Estás seguro de que deseas eliminar este registro?</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <input type="hidden" name="id" class="form-control" value="<?php echo isset($_GET['id']) ? $_GET['id'] : ''; ?>"/>
                        </div>
                        <p>
                            <input type="submit" class="btn btn-danger" value="Eliminar">
                            <a href="../crud-Prestamos.php" class="btn btn-default">Cancelar</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php
    // Include config file
    require '../../../config/database.php';    
    $db = new Database();
    $con = $db->conectar();

    // Process form data when form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Prepare a delete statement
        $sql = "DELETE FROM prestamos WHERE IDpres = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);

            // Set parameters
            $param_id = trim($_POST["id"]);

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Records deleted successfully. Redirect to landing page
                header("location: ../crud-Prestamos.php");
                exit();
            } else {
                echo "Algo salió mal al eliminar el registro. Por favor, inténtelo de nuevo más tarde.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        } else {
            echo "Error al preparar la consulta: " . mysqli_error($link);
        }
    }

    // Close connection
    mysqli_close($link);
    ?>
</body>
</html>

