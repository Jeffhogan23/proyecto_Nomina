<?php
// Include config file
require '../../../config/database.php';    
$db = new Database();
$con = $db->conectar();

// Define variables and initialize with empty values
$name = $amount = "";
$name_err = $amount_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate name
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Por favor ingrese el tipo de bonificación.";
    } else{
        $name = $input_name;
    }

    // Validate amount
    $input_amount = trim($_POST["amount"]);
    if(empty($input_amount) && $input_amount !== '0'){
        $amount_err = "Por favor ingrese el monto de la bonificación.";
    } else{
        $amount = $input_amount;
    }
    
    // Check input errors before inserting in database
    if(empty($name_err) && empty($amount_err)){
        // Obtener el valor máximo actual de la columna IDparafiscal
        $sql_max_id = "SELECT MAX(IDBonificacion) AS max_id FROM bonificaciones";
        $result_max_id = mysqli_query($link, $sql_max_id);
        $row_max_id = mysqli_fetch_assoc($result_max_id);
        $next_id = $row_max_id['max_id'] + 1;

        // Prepare an insert statement
        $sql = "INSERT INTO bonificaciones (IDBonificacion, TipoBonificacion, MontoBonificacion) VALUES (?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "isd", $next_id, $param_name, $param_amount);
            
            // Set parameters
            $param_name = $name;
            $param_amount = $amount;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: ../crud-Bonificaciones.php");
                exit();
            } else{
                echo "Error: " . mysqli_error($link);
            }
        } else{
            echo "Error al preparar la consulta.";
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    } else {
        echo "Por favor, corrija los errores y vuelva a intentarlo.";
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Agregar Bonificación</title>
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
                        <h2>Agregar Bonificación</h2>
                    </div>
                    <p>Favor diligenciar el siguiente formulario para agregar una nueva bonificación.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                            <label>Tipo de Bonificación</label>
                            <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
                            <span class="help-block"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($amount_err)) ? 'has-error' : ''; ?>">
                            <label>Monto de Bonificación</label>
                            <input type="text" name="amount" class="form-control" value="<?php echo $amount; ?>">
                            <span class="help-block"><?php echo $amount_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Agregar">
                        <a href="../crud-Bonificaciones.php" class="btn btn-default">Cancelar</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
