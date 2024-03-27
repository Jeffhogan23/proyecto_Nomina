<?php
require '../../../config/database.php';    
$db = new Database();
try {
    $con = $db->conectar();
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$IDusuario = $FechaNomina = $Mes = $DiasTrabajados = $SalarioNeto = $ValorParafiscales = $ValorPrestamo = $TotalDeducidos = $IDBonificacion = $NetoPagado = "";
$IDusuario_err = $FechaNomina_err = $Mes_err = $DiasTrabajados_err = $SalarioNeto_err = $ValorParafiscales_err = $ValorPrestamo_err = $TotalDeducidos_err = $IDBonificacion_err = $NetoPagado_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $input_IDusuario = trim($_POST["IDusuario"]);
    if(empty($input_IDusuario)){
        $IDusuario_err = "Por favor ingrese el ID del usuario.";
    } else{
        $IDusuario = $input_IDusuario;
    }

    $input_FechaNomina = trim($_POST["FechaNomina"]);
    if(empty($input_FechaNomina)){
        $FechaNomina_err = "Por favor ingrese la fecha de la nómina.";
    } else{
        $FechaNomina = $input_FechaNomina;
    }

    $input_Mes = trim($_POST["Mes"]);
    if(empty($input_Mes)){
        $Mes_err = "Por favor ingrese el mes de la nómina.";
    } else{
        $Mes = $input_Mes;
    }

    $input_DiasTrabajados = trim($_POST["DiasTrabajados"]);
    if(empty($input_DiasTrabajados)){
        $DiasTrabajados_err = "Por favor ingrese los días trabajados.";
    } else{
        $DiasTrabajados = $input_DiasTrabajados;
    }

    $input_SalarioNeto = trim($_POST["SalarioNeto"]);
    if(empty($input_SalarioNeto)){
        $SalarioNeto_err = "Por favor ingrese el salario neto.";
    } else{
        $SalarioNeto = $input_SalarioNeto;
    }

    $input_ValorParafiscales = trim($_POST["ValorParafiscales"]);
    if(empty($input_ValorParafiscales)){
        $ValorParafiscales_err = "Por favor ingrese el valor de parafiscales.";
    } else{
        $ValorParafiscales = $input_ValorParafiscales;
    }

    $input_ValorPrestamo = trim($_POST["ValorPrestamo"]);
    if(empty($input_ValorPrestamo)){
        $ValorPrestamo_err = "Por favor ingrese el valor del préstamo.";
    } else{
        $ValorPrestamo = $input_ValorPrestamo;
    }

    $input_TotalDeducidos = trim($_POST["TotalDeducidos"]);
    if(empty($input_TotalDeducidos)){
        $TotalDeducidos_err = "Por favor ingrese el total deducidos.";
    } else{
        $TotalDeducidos = $input_TotalDeducidos;
    }

    $input_IDBonificacion = trim($_POST["IDBonificacion"]);
    $IDBonificacion = $input_IDBonificacion;

    $input_NetoPagado = trim($_POST["NetoPagado"]);
    if(empty($input_NetoPagado)){
        $NetoPagado_err = "Por favor ingrese el neto pagado.";
    } else{
        $NetoPagado = $input_NetoPagado;
    }

    if(empty($IDusuario_err) && empty($FechaNomina_err) && empty($Mes_err) && empty($DiasTrabajados_err) && empty($SalarioNeto_err) && empty($ValorParafiscales_err) && empty($ValorPrestamo_err) && empty($TotalDeducidos_err) && empty($NetoPagado_err)) {
        // Obtener el valor máximo actual de la columna IDNomina
        $sql_max_id = "SELECT MAX(IDNomina) AS max_id FROM nomina";
        $result_max_id = $con->query($sql_max_id);
        $row_max_id = $result_max_id->fetch(PDO::FETCH_ASSOC);
        $next_id = $row_max_id['max_id'] + 1;
    
        $sql = "INSERT INTO nomina (IDNomina, IDusuario, FechaNomina, Mes, DiasTrabajados, SalarioNeto, ValorParafiscales, ValorPrestamo, TotalDeducidos, IDBonificacion, NetoPagado) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $con->prepare($sql);
        $stmt->execute([$next_id, $IDusuario, $FechaNomina, $Mes, $DiasTrabajados, $SalarioNeto, $ValorParafiscales, $ValorPrestamo, $TotalDeducidos, $IDBonificacion, $NetoPagado]);
    
        if ($stmt->rowCount() > 0) {
            header("location: ../crud-Nomina.php");
            exit();
        } else {
            echo "Error: " . $stmt->errorInfo()[2];
        }
    
        $stmt->close();
    }
    $con = null;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Agregar Bonificación</title>
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
                        <h2>Agregar Nomina</h2>
                    </div>
                    <p>Favor diligenciar el siguiente formulario para agregar una nueva nomina.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($IDusuario_err)) ? 'has-error' : ''; ?>">
                            <label>ID del Usuario</label>
                            <select name="IDusuario" class="form-control">
                                <option value="" disabled selected>Seleccionar un Usuario</option>
                                <?php
                                // Query para obtener los usuarios existentes
                                $sql = "SELECT IDusuario, Nombre, Apellido FROM usuario";
                                $result = mysqli_query($link, $sql);

                                // Iterar sobre los resultados y crear opciones para el select
                                while ($row = mysqli_fetch_array($result)) {
                                    echo "<option value='" . $row['IDusuario'] . "'";
                                    if ($IDusuario == $row['IDusuario']) {
                                        echo "selected";
                                    }
                                    echo "<option>" . $row['Nombre'] ." ". $row['Apellido'] . "</option>";
                                }
                                ?>
                            </select>
                            <span class="help-block"><?php echo $IDusuario_err; ?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($FechaNomina_err)) ? 'has-error' : ''; ?>">
                            <label>Fecha de la Nómina</label>
                            <input type="date" name="FechaNomina" class="form-control"
                                value="<?php echo $FechaNomina; ?>">
                            <span class="help-block"><?php echo $FechaNomina_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($Mes_err)) ? 'has-error' : ''; ?>">
                            <label>Mes</label>
                            <input type="text" name="Mes" class="form-control" value="<?php echo $Mes; ?>">
                            <span class="help-block"><?php echo $Mes_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($DiasTrabajados_err)) ? 'has-error' : ''; ?>">
                            <label>Días Trabajados</label>
                            <input type="text" name="DiasTrabajados" class="form-control"
                                value="<?php echo $DiasTrabajados; ?>">
                            <span class="help-block"><?php echo $DiasTrabajados_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($SalarioNeto_err)) ? 'has-error' : ''; ?>">
                            <label>Salario Neto</label>
                            <input type="text" name="SalarioNeto" class="form-control"
                                value="<?php echo $SalarioNeto; ?>">
                            <span class="help-block"><?php echo $SalarioNeto_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($ValorParafiscales_err)) ? 'has-error' : ''; ?>">
                            <label>Valor de Parafiscales</label>
                            <input type="text" name="ValorParafiscales" class="form-control"
                                value="<?php echo $ValorParafiscales; ?>">
                            <span class="help-block"><?php echo $ValorParafiscales_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($ValorPrestamo_err)) ? 'has-error' : ''; ?>">
                            <label>Valor del Préstamo</label>
                            <input type="text" name="ValorPrestamo" class="form-control"
                                value="<?php echo $ValorPrestamo; ?>">
                            <span class="help-block"><?php echo $ValorPrestamo_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($TotalDeducidos_err)) ? 'has-error' : ''; ?>">
                            <label>Total Deducidos</label>
                            <input type="text" name="TotalDeducidos" class="form-control"
                                value="<?php echo $TotalDeducidos; ?>">
                            <span class="help-block"><?php echo $TotalDeducidos_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($IDBonificacion_err)) ? 'has-error' : ''; ?>">
                            <label>ID de la Bonificación</label>
                            <select name="IDBonificacion" class="form-control">
                                <option value="" disabled selected>Seleccionar una Bonificacion</option>
                                <?php
                                // Query para obtener las bonificaciones existentes
                                $sql = "SELECT IDBonificacion, TipoBonificacion FROM bonificaciones";
                                $result = mysqli_query($link, $sql);

                                // Iterar sobre los resultados y crear opciones para el select
                                while ($row = mysqli_fetch_array($result)) {
                                    echo "<option value='" . $row['IDBonificacion'] . "'";
                                    if ($IDBonificacion == $row['IDBonificacion']) {
                                        echo "selected";
                                    }
                                    echo "<option>" . $row['TipoBonificacion'] . "</option>";
                                }
                                ?>
                            </select>
                            <span class="help-block"><?php echo $IDBonificacion_err; ?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($NetoPagado_err)) ? 'has-error' : ''; ?>">
                            <label>Neto Pagado</label>
                            <input type="text" name="NetoPagado" class="form-control"
                                value="<?php echo $NetoPagado; ?>">
                            <span class="help-block"><?php echo $NetoPagado_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="../crud-Nomina.php" class="btn btn-default">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>