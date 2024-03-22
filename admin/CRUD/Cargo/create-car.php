<?php
// Include config file
require '../../../config/database.php';    
$db = new Database();
$con = $db->conectar();

// Define variables and initialize with empty values
$name = $salary = "";
$name_err = $salary_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate name
    $input_name = trim($_POST["name"]);
    if (empty($input_name)) {
        $name_err = "Por favor ingrese el nombre del cargo.";
    } else {
        $name = $input_name;
    }

    // Validate salary
    $input_salary = trim($_POST["salary"]);
    if (empty($input_salary)) {
        $salary_err = "Por favor ingrese el salario del cargo.";
    } else {
        $salary = $input_salary;
    }
    

    // Check input errors before inserting in database
    if (empty($name_err) && empty($salary_err)) {
        // Prepare an insert statement
        $sql = "INSERT INTO cargo (NombreCargo, SalarioCargo) VALUES (?, ?)";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sd", $param_name, $param_salary);

            // Set parameters
            $param_name = $name;
            $param_salary = $salary;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Records created successfully. Redirect to landing page
                header("location: ../crud-Cargo.php");
                exit();
            } else {
                echo "Error al ejecutar la consulta. Por favor, inténtelo de nuevo más tarde.";
            }
        } else {
            echo "Error al preparar la consulta.";
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Close connection
    mysqli_close($link);
}

// Eliminar registro si se recibe un ID válido
if (isset($_GET["id"]) && !empty($_GET["id"])) {
    // Eliminar registro
    $id = $_GET["id"];

    // Delete statement
    $sql_delete = "DELETE FROM cargo WHERE IDcargo = ?";

    if ($stmt_delete = mysqli_prepare($link, $sql_delete)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt_delete, "i", $param_id);

        // Set parameters
        $param_id = $id;

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt_delete)) {
            // Close statement
            mysqli_stmt_close($stmt_delete);

            // Replace the original table with a temporary table having re-sequenced IDs
            $sql_replace_table = "CREATE TEMPORARY TABLE cargo_temp AS
                                    (SELECT @id := @id + 1 AS new_id, NombreCargo, SalarioCargo
                                    FROM cargo, (SELECT @id := 0) AS dummy ORDER BY IDcargo);
                                 DROP TABLE cargo;
                                 ALTER TABLE cargo_temp RENAME TO cargo;";

            if (mysqli_multi_query($link, $sql_replace_table)) {
                // Success, redirect to crud-cargo.php
                header("location: ../crud-Cargo.php");
                exit();
            } else {
                echo "Error al reemplazar la tabla.";
            }
        } else {
            echo "Error al eliminar el registro.";
        }
    } else {
        echo "Error al preparar la consulta de eliminación.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Agregar Cargo</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
    .wrapper {
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
                        <h2>Agregar Cargo</h2>
                    </div>
                    <p>Por favor diligencie el siguiente formulario para agregar un nuevo cargo.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                            <label>Nombre del Cargo</label>
                            <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
                            <span class="help-block"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($salary_err)) ? 'has-error' : ''; ?>">
                            <label>Salario del Cargo</label>
                            <input type="text" name="salary" class="form-control" value="<?php echo $salary; ?>">
                            <span class="help-block"><?php echo $salary_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Agregar">
                        <a href="../crud-Cargo.php" class="btn btn-default">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>