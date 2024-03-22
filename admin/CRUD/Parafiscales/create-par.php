<?php
// Include config file
require '../../../config/database.php';    
$db = new Database();
$con = $db->conectar();
 
// Define variables and initialize with empty values
$tipoParafiscal = "";
$tasaParafiscal = "";
$tipoParafiscal_err = "";
$tasaParafiscal_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate tipoParafiscal
    $input_tipoParafiscal = trim($_POST["tipoParafiscal"]);
    if(empty($input_tipoParafiscal)){
        $tipoParafiscal_err = "Por favor ingrese el tipo de parafiscal.";
    } else{
        $tipoParafiscal = $input_tipoParafiscal;
    }

    // Validate tasaParafiscal
    $input_tasaParafiscal = trim($_POST["tasaParafiscal"]);
    if(empty($input_tasaParafiscal)){
        $tasaParafiscal_err = "Por favor ingrese la tasa del parafiscal.";
    } elseif(!is_numeric($input_tasaParafiscal)){
        $tasaParafiscal_err = "La tasa del parafiscal debe ser un valor numérico.";
    } else{
        $tasaParafiscal = $input_tasaParafiscal;
    }
    
    if(empty($tipoParafiscal_err) && empty($tasaParafiscal_err)){
        // Obtener el valor máximo actual de la columna IDparafiscal
        $sql_max_id = "SELECT MAX(IDparafiscal) AS max_id FROM parafiscales";
        $result_max_id = mysqli_query($link, $sql_max_id);
        $row_max_id = mysqli_fetch_assoc($result_max_id);
        $next_id = $row_max_id['max_id'] + 1;
    
        // Prepare an insert statement
        $sql = "INSERT INTO parafiscales (IDparafiscal, TipoParafiscal, TasaParafiscal) VALUES (?, ?, ?)";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "isd", $next_id, $param_tipoParafiscal, $param_tasaParafiscal);
            
            // Set parameters
            $param_tipoParafiscal = $tipoParafiscal;
            $param_tasaParafiscal = $tasaParafiscal;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: ../crud-Parafiscales.php");
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
    <title>Agregar Parafiscal</title>
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
                        <h2>Agregar Parafiscal</h2>
                    </div>
                    <p>Favor diligenciar el siguiente formulario para agregar un nuevo parafiscal.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
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
                        <input type="submit" class="btn btn-primary" value="Agregar">
                        <a href="../crud-Parafiscales.php" class="btn btn-default">Cancelar</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>