<?php
// Include config file
require '../../../config/database.php';    
$db = new Database();
$con = $db->conectar();

// Define variables and initialize with empty values
$id = $nombre = $apellido = $correo = $contrasena = $fecha_registro = $telefono = $id_rol = $id_cargo = $id_ciudad = $id_tipo_contrato = "";
$id_err = $nombre_err = $apellido_err = $correo_err = $contrasena_err = $fecha_registro_err = $telefono_err = $id_rol_err = $id_cargo_err = $id_ciudad_err = $id_tipo_contrato_err = "";

// Get the ID from the URL parameter
$id = $_GET['id'];

// Get the current row from the database
$sql = "SELECT * FROM usuario WHERE IDusuario =?";
if ($stmt = mysqli_prepare($link, $sql)) {
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "i", $id);
    // Attempt to execute the prepared statement
    if (mysqli_stmt_execute($stmt)) {
        /* store result */
        mysqli_stmt_store_result($stmt);
        // Bind result variables
        mysqli_stmt_bind_result($stmt, $id, $nombre, $apellido, $correo, $contrasena, $fecha_registro, $telefono, $id_rol, $id_cargo, $id_ciudad, $id_tipo_contrato);
        // Fetch the results
        if (mysqli_stmt_fetch($stmt)) {
            $nombre = $nombre;
            $apellido = $apellido;
            $correo = $correo;
            $contrasena = $contrasena;
            $fecha_registro = $fecha_registro;
            $telefono = $telefono;
            $id_rol = $id_rol;
            $id_cargo = $id_cargo;
            $id_ciudad = $id_ciudad;
            $id_tipo_contrato = $id_tipo_contrato;
        }
    }
    // Close statement
    mysqli_stmt_close($stmt);
}

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate nombre
    if (empty(trim($_POST["nombre"]))) {
        $nombre_err = "Por favor ingrese un nombre.";
    } else {
        $nombre = trim($_POST["nombre"]);
    }

    // Validate apellido
    if (empty(trim($_POST["apellido"]))) {
        $apellido_err = "Por favor ingrese un apellido.";
    } else {
        $apellido = trim($_POST["apellido"]);
    }

    // Validate correo
    if (empty(trim($_POST["correo"]))) {
        $correo_err = "Por favor ingrese un correo.";
    } else {
        $correo = trim($_POST["correo"]);
    }

    // Validate contraseña
    if (empty(trim($_POST["contrasena"]))) {
        $contrasena_err = "Por favor ingrese una contraseña.";
    } else {
        $contrasena = trim($_POST["contrasena"]);
    }

    // Validate fecha_registro
    $fecha_registro = trim($_POST["fecha_registro"]);

    // Validate telefono
    if (empty(trim($_POST["telefono"]))) {
        $telefono_err = "Por favor ingrese un número de teléfono.";
    } else {
        $telefono = trim($_POST["telefono"]);
    }

    // Validate id_rol
    if (empty(trim($_POST["id_rol"]))) {
        $id_rol_err = "Por favor seleccione un rol.";
    } else {
        $id_rol = trim($_POST["id_rol"]);
    }

    // Validate id_cargo
    if (empty(trim($_POST["id_cargo"]))) {
        $id_cargo_err = "Por favor seleccione un cargo.";
    } else {
        $id_cargo = trim($_POST["id_cargo"]);
    }

    // Validate id_ciudad
    if (empty(trim($_POST["id_ciudad"]))) {
        $id_ciudad_err = "Por favor seleccione una ciudad.";
    } else {
        $id_ciudad = trim($_POST["id_ciudad"]);
    }

    // Validate id_tipo_contrato
    if (empty(trim($_POST["id_tipo_contrato"]))) {
        $id_tipo_contrato_err = "Por favor seleccione un tipo de contrato.";
    } else {
        $id_tipo_contrato = trim($_POST["id_tipo_contrato"]);
    }

    // Check input errors before updating in database
    if (empty($nombre_err) && empty($apellido_err) && empty($correo_err) && empty($contrasena_err) && empty($telefono_err) && empty($id_rol_err) && empty($id_cargo_err) && empty($id_ciudad_err) && empty($id_tipo_contrato_err)) {

        $sql = "UPDATE usuario SET Nombre =?, Apellido =?, Correo =?, Contraseña =?, FechaRegistro =?, Telefono =?, IDrol =?, IDcargo =?, IDciu =?, IDtipContrato =? WHERE IDusuario =?";
        $stmt = $con->prepare($sql);
            
        if ($stmt) {
            $stmt->bindParam(1, $nombre);
            $stmt->bindParam(2, $apellido);
            $stmt->bindParam(3, $correo);
            $stmt->bindParam(4, $contrasena);
            $stmt->bindParam(5, $fecha_registro);
            $stmt->bindParam(6, $telefono);
            $stmt->bindParam(7, $id_rol);
            $stmt->bindParam(8, $id_cargo);
            $stmt->bindParam(9, $id_ciudad);
            $stmt->bindParam(10, $id_tipo_contrato);
            $stmt->bindParam(11, $id);
        
            if($stmt->execute()){
                header("location:../crud-Usuario.php");
                exit();
            } else{
                echo "Algo salió mal. Por favor, inténtalo de nuevo más tarde.";
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
    <title>Editar Usuario</title>
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
                        <h2>Actualizar Usuario</h2>
                    </div>
                    <p>Edite los valores de entrada y envíe para actualizar el registro.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group <?php echo (!empty($nombre_err)) ? 'has-error' : ''; ?>">
                            <label>Nombre</label>
                            <input type="text" name="nombre" class="form-control" value="<?php echo $nombre; ?>">
                            <span class="help-block"><?php echo $nombre_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($apellido_err)) ? 'has-error' : ''; ?>">
                            <label>Apellido</label>
                            <input type="text" name="apellido" class="form-control" value="<?php echo $apellido; ?>">
                            <span class="help-block"><?php echo $apellido_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($correo_err)) ? 'has-error' : ''; ?>">
                            <label>Correo</label>
                            <input type="email" name="correo" class="form-control" value="<?php echo $correo; ?>">
                            <span class="help-block"><?php echo $correo_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($contrasena_err)) ? 'has-error' : ''; ?>">
                            <label>Contraseña</label>
                            <input type="password" name="contrasena" class="form-control" value="<?php echo $contrasena; ?>">
                            <span class="help-block"><?php echo $contrasena_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($fecha_registro_err)) ? 'has-error' : ''; ?>">
                            <label>Fecha de Registro</label>
                            <input type="date" name="fecha_registro" class="form-control" value="<?php echo $fecha_registro; ?>">
                            <span class="help-block"><?php echo $fecha_registro_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($telefono_err)) ? 'has-error' : ''; ?>">
                            <label>Teléfono</label>
                            <input type="text" name="telefono" class="form-control" value="<?php echo $telefono; ?>">
                            <span class="help-block"><?php echo $telefono_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($id_rol_err)) ? 'has-error' : ''; ?>">
                            <label>Rol</label>
                            <select name="id_rol" class="form-control">
                                <option value="">Seleccione un rol</option>
                                <?php
                                // Consulta para obtener los roles
                                $sql_roles = "SELECT * FROM roles";
                                $result_roles = mysqli_query($link, $sql_roles);
                                while ($row_roles = mysqli_fetch_assoc($result_roles)) {
                                    $selected = ($row_roles['IDrol'] == $id_rol) ? 'selected' : '';
                                    echo '<option value="' . $row_roles['IDrol'] . '" ' . $selected . '>' . $row_roles['NombreRol'] . '</option>';
                                }
                                ?>
                            </select>
                            <span class="help-block"><?php echo $id_rol_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($id_cargo_err)) ? 'has-error' : ''; ?>">
                            <label>Cargo</label>
                            <select name="id_cargo" class="form-control">
                                <option value="">Seleccione un cargo</option>
                                <?php
                                // Consulta para obtener los cargos
                                $sql_cargos = "SELECT * FROM cargo";
                                $result_cargos = mysqli_query($link, $sql_cargos);
                                while ($row_cargos = mysqli_fetch_assoc($result_cargos)) {
                                    $selected = ($row_cargos['IDcargo'] == $id_cargo) ? 'selected' : '';
                                    echo '<option value="' . $row_cargos['IDcargo'] . '" ' . $selected . '>' . $row_cargos['NombreCargo'] . '</option>';
                                }
                                ?>
                            </select>
                            <span class="help-block"><?php echo $id_cargo_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($id_ciudad_err)) ? 'has-error' : ''; ?>">
                            <label>Ciudad</label>
                            <select name="id_ciudad" class="form-control">
                                <option value="">Seleccione una ciudad</option>
                                <?php
                                // Consulta para obtener las ciudades
                                $sql_ciudades = "SELECT c.IDciu, c.NombreCiu, d.NombreDep FROM ciudad c JOIN departamento d ON c.IDdep = d.IDdep";
                                $result_ciudades = mysqli_query($link, $sql_ciudades);
                                while ($row_ciudades = mysqli_fetch_assoc($result_ciudades)) {
                                    $selected = ($row_ciudades['IDciu'] == $id_ciudad) ? 'selected' : '';
                                    echo '<option value="' . $row_ciudades['IDciu'] . '" ' . $selected . '>' . $row_ciudades['NombreCiu'] . ' (' . $row_ciudades['NombreDep'] . ')</option>';
                                }
                                ?>
                            </select>
                            <span class="help-block"><?php echo $id_ciudad_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($id_tipo_contrato_err)) ? 'has-error' : ''; ?>">
                            <label>Tipo de Contrato</label>
                            <select name="id_tipo_contrato" class="form-control">
                                <option value="">Seleccione un tipo de contrato</option>
                                <?php
                                // Consulta para obtener los tipos de contrato
                                $sql_tipos_contrato = "SELECT * FROM tipocontrato";
                                $result_tipos_contrato = mysqli_query($link, $sql_tipos_contrato);
                                while ($row_tipos_contrato = mysqli_fetch_assoc($result_tipos_contrato)) {
                                    $selected = ($row_tipos_contrato['IDtipContrato'] == $id_tipo_contrato) ? 'selected' : '';
                                    echo '<option value="' . $row_tipos_contrato['IDtipContrato'] . '" ' . $selected . '>' . $row_tipos_contrato['NombreTipContrato'] . '</option>';
                                }
                                ?>
                            </select>
                            <span class="help-block"><?php echo $id_tipo_contrato_err;?></span>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Enviar">
                        <a href="../crud-Usuario.php" class="btn btn-default">Cancelar</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>