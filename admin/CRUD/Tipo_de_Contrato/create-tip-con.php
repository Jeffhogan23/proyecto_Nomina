<?php
// Include config file
require '../../../config/database.php';    
$db = new Database();
$con = $db->conectar();
 
// Define variables and initialize with empty values
$nombre_tipo_contrato = "";
$nombre_tipo_contrato_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate nombre_tipo_contrato
    $input_nombre_tipo_contrato = trim($_POST["nombre_tipo_contrato"]);
    if(empty($input_nombre_tipo_contrato)){
        $nombre_tipo_contrato_err = "Por favor ingrese el nombre del tipo de contrato.";
    } else{
        $nombre_tipo_contrato = $input_nombre_tipo_contrato;
    }
    
    // Check input errors before inserting in database
    if(empty($nombre_tipo_contrato_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO tipocontrato (NombreTipContrato) VALUES (?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_nombre_tipo_contrato);
            
            // Set parameters
            $param_nombre_tipo_contrato = $nombre_tipo_contrato;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: ../crud-Tipocontrato.php");
                exit();
            } else{
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
    <title>Agregar Tipo de Contrato</title>
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
                        <h2>Agregar Tipo de Contrato</h2>
                    </div>
                    <p>Favor diligenciar el siguiente formulario para agregar un nuevo tipo de contrato.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($nombre_tipo_contrato_err)) ? 'has-error' : ''; ?>">
                            <label>Nombre del Tipo de Contrato</label>
                            <input type="text" name="nombre_tipo_contrato" class="form-control" value="<?php echo $nombre_tipo_contrato; ?>">
                            <span class="help-block"><?php echo $nombre_tipo_contrato_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Agregar">
                        <a href="../crud-TiposContrato.php" class="btn btn-default">Cancelar</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>