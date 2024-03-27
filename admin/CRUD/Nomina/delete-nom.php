<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Eliminar Nómina</title>
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
                        <h1>Eliminar Nómina</h1>
                    </div>
                    <p>¿Estás seguro de que deseas eliminar este registro de nómina?</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <input type="hidden" name="id" class="form-control" value="<?php echo isset($_GET['id']) ? $_GET['id'] : ''; ?>"/>
                        </div>
                        <p>
                            <input type="submit" class="btn btn-danger" value="Eliminar">
                            <a href="../crud-Nomina.php" class="btn btn-default">Cancelar</a>
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
        $sql = "DELETE FROM nomina WHERE IDNomina = :id";

        if ($stmt = $con->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":id", $param_id, PDO::PARAM_INT);

            // Set parameters
            $param_id = trim($_POST["id"]);

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Records deleted successfully. Redirect to landing page
                header("location: ../crud-Nomina.php");
                exit();
            } else {
                echo "Algo salió mal al eliminar el registro de nómina. Por favor, inténtelo de nuevo más tarde.";
            }

            // Close statement
            unset($stmt);
        } else {
            echo "Error al preparar la consulta: " . $con->errorInfo()[2];
        }
    }

    // Close connection
    unset($con);
    ?>
</body>
</html>