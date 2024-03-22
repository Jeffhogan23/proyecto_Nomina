<?php
// Include config file
require '../../../config/database.php';
$db = new Database();
$con = $db->conectar();

// Define variables and initialize with empty values
$idusuario = $nombre = $apellido = $correo = $contraseña = $fecha_registro = $telefono = $rol = $cargo = $ciudad = $tipo_contrato = "";
$idusuario_err = $nombre_err = $apellido_err = $correo_err = $contraseña_err = $fecha_registro_err = $telefono_err = $rol_err = $cargo_err = $ciudad_err = $tipo_contrato_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate idusuario
    $input_idusuario = trim($_POST["idusuario"]);
    if(empty($input_idusuario)){
        $idusuario_err = "Por favor ingrese un ID de usuario.";
    } else{
        $idusuario = $input_idusuario;
    }

    // Validate nombre
    $input_nombre = trim($_POST["nombre"]);
    if(empty($input_nombre)){
        $nombre_err = "Por favor ingrese un nombre.";
    } else{
        $nombre = $input_nombre;
    }

    // Validate apellido
    $input_apellido = trim($_POST["apellido"]);
    if(empty($input_apellido)){
        $apellido_err = "Por favor ingrese un apellido.";
    } else{
        $apellido = $input_apellido;
    }

    // Validate correo
    $input_correo = trim($_POST["correo"]);
    if(empty($input_correo)){
        $correo_err = "Por favor ingrese un correo electrónico.";
    } else{
        $correo = $input_correo;
    }

    // Validate contraseña
    $input_contraseña = trim($_POST["contraseña"]);
    if(empty($input_contraseña)){
        $contraseña_err = "Por favor ingrese una contraseña.";
    } else{
        $contraseña = $input_contraseña;
    }

    // Validate fecha_registro
    $input_fecha_registro = trim($_POST["fecha_registro"]);
    if(empty($input_fecha_registro)){
        $fecha_registro_err = "Por favor ingrese una fecha de registro.";
    } else{
        $fecha_registro = $input_fecha_registro;
    }

    // Validate telefono
    $input_telefono = trim($_POST["telefono"]);
    if(empty($input_telefono)){
        $telefono_err = "Por favor ingrese un número de teléfono.";
    } else{
        $telefono = $input_telefono;
    }

    // Validate rol
    $input_rol = trim($_POST["rol"]);
    if(empty($input_rol)){
        $rol_err = "Por favor seleccione un rol.";
    } else{
        $rol = $input_rol;
    }

    // Validate cargo
    $input_cargo = trim($_POST["cargo"]);
    if(empty($input_cargo)){
        $cargo_err = "Por favor seleccione un cargo.";
    } else{
        $cargo = $input_cargo;
    }

    // Validate ciudad
    $input_ciudad = trim($_POST["ciudad"]);
    if(empty($input_ciudad)){
        $ciudad_err = "Por favor seleccione una ciudad.";
    } else{
        $ciudad = $input_ciudad;
    }

    // Validate tipo_contrato
    $input_tipo_contrato = trim($_POST["tipo_contrato"]);
    if(empty($input_tipo_contrato)){
        $tipo_contrato_err = "Por favor seleccione un tipo de contrato.";
    } else{
        $tipo_contrato = $input_tipo_contrato;
    }

    // Check input errors before inserting in database
    if(empty($idusuario_err) && empty($nombre_err) && empty($apellido_err) && empty($correo_err) && empty($contraseña_err) && empty($fecha_registro_err) && empty($telefono_err) && empty($rol_err) && empty($cargo_err) && empty($ciudad_err) && empty($tipo_contrato_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO usuario (IDusuario, Nombre, Apellido, Correo, Contraseña, FechaRegistro, Telefono, IDrol, IDcargo, IDciu, IDtipContrato) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $con->prepare($sql);

        if($stmt){
            // Bind parameters
            $stmt->bindParam(1, $idusuario);
            $stmt->bindParam(2, $nombre);
            $stmt->bindParam(3, $apellido);
            $stmt->bindParam(4, $correo);
            $stmt->bindParam(5, $contraseña);
            $stmt->bindParam(6, $fecha_registro);
            $stmt->bindParam(7, $telefono);
            $stmt->bindParam(8, $rol);
            $stmt->bindParam(9, $cargo);
            $stmt->bindParam(10, $ciudad);
            $stmt->bindParam(11, $tipo_contrato);
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Records created successfully. Redirect to landing page
                header("location: ../crud-Usuario.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        $stmt = null;
    }

    // Close connection
    $con = null;
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Agregar Usuario</title>
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
                        <h2>Agregar Usuario</h2>
                    </div>
                    <p>Favor diligenciar el siguiente formulario para agregar un nuevo usuario.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($idusuario_err)) ? 'has-error' : ''; ?>">
                            <label>ID de Usuario</label>
                            <input type="text" name="idusuario" class="form-control" value="<?php echo $idusuario; ?>">
                            <span class="help-block"><?php echo $idusuario_err;?></span>
                        </div>
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
                            <label>Correo Electrónico</label>
                            <input type="email" name="correo" class="form-control" value="<?php echo $correo; ?>">
                            <span class="help-block"><?php echo $correo_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($contraseña_err)) ? 'has-error' : ''; ?>">
                            <label>Contraseña</label>
                            <input type="password" name="contraseña" class="form-control"
                                value="<?php echo $contraseña; ?>">
                            <span class="help-block"><?php echo $contraseña_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($fecha_registro_err)) ? 'has-error' : ''; ?>">
                            <label>Fecha de Registro</label>
                            <input type="date" name="fecha_registro" class="form-control"
                                value="<?php echo $fecha_registro; ?>">
                            <span class="help-block"><?php echo $fecha_registro_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($telefono_err)) ? 'has-error' : ''; ?>">
                            <label>Teléfono</label>
                            <input type="tel" name="telefono" class="form-control" value="<?php echo $telefono; ?>">
                            <span class="help-block"><?php echo $telefono_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($rol_err)) ? 'has-error' : ''; ?>">
                            <label>Rol</label>
                            <select name="rol" class="form-control">
                                <option value="" disabled selected>Seleccionar rol</option>
                                <?php
                                // Obtener los roles de la tabla 'roles' excepto el rol 'Administrador'
                                $sql_roles = "SELECT IDrol, NombreRol FROM roles WHERE NombreRol != 'Administrador'";
                                $result_roles = mysqli_query($link, $sql_roles);
                                while ($row_roles = mysqli_fetch_assoc($result_roles)) {
                                    $selected = ($row_roles['IDrol'] == $rol) ? 'selected' : '';
                                    echo "<option value='" . $row_roles['IDrol'] . "' " . $selected . ">" . $row_roles['NombreRol'] . "</option>";
                                }
                                ?>
                            </select>
                            <span class="help-block"><?php echo $rol_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($cargo_err)) ? 'has-error' : ''; ?>">
                            <label>Cargo</label>
                            <select name="cargo" class="form-control">
                                <option value="" disabled selected>Seleccionar cargo</option>
                                <?php
                                // Obtener los cargos de la tabla 'cargo'
                                $sql_cargos = "SELECT IDcargo, NombreCargo FROM cargo";
                                $result_cargos = mysqli_query($link, $sql_cargos);
                                while ($row_cargos = mysqli_fetch_assoc($result_cargos)) {
                                    $selected = ($row_cargos['IDcargo'] == $cargo) ? 'selected' : '';
                                    echo "<option value='" . $row_cargos['IDcargo'] . "' " . $selected . ">" . $row_cargos['NombreCargo'] . "</option>";
                                }
                                ?>
                            </select>
                            <span class="help-block"><?php echo $cargo_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($ciudad_err)) ? 'has-error' : ''; ?>">
                            <label>Ciudad</label>
                            <select name="ciudad" class="form-control">
                                <option value="" disabled selected>Seleccionar ciudad</option>
                                <?php
                                // Obtener las ciudades de la tabla 'ciudad'
                                $sql_ciudades = "SELECT IDciu, NombreCiu FROM ciudad ORDER BY NombreCiu ASC";
                                $result_ciudades = mysqli_query($link, $sql_ciudades);
                                while ($row_ciudades = mysqli_fetch_assoc($result_ciudades)) {
                                    $selected = ($row_ciudades['IDciu'] == $ciudad) ? 'selected' : '';
                                    echo "<option value='" . $row_ciudades['IDciu'] . "' " . $selected . ">" . $row_ciudades['NombreCiu'] . "</option>";
                                }
                                ?>
                            </select>
                            <span class="help-block"><?php echo $ciudad_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($tipo_contrato_err)) ? 'has-error' : ''; ?>">
                            <label>Tipo de Contrato</label>
                            <select name="tipo_contrato" class="form-control">
                                <option value="" disabled selected>Seleccionar tipo de contrato</option>
                                <?php
                                // Obtener los tipos de contrato de la tabla 'tipocontrato'
                                $sql_tipos_contrato = "SELECT IDtipContrato, NombreTipContrato FROM tipocontrato";
                                $result_tipos_contrato = mysqli_query($link, $sql_tipos_contrato);
                                while ($row_tipos_contrato = mysqli_fetch_assoc($result_tipos_contrato)) {
                                    $selected = ($row_tipos_contrato['IDtipContrato'] == $tipo_contrato) ? 'selected' : '';
                                    echo "<option value='" . $row_tipos_contrato['IDtipContrato'] . "' " . $selected . ">" . $row_tipos_contrato['NombreTipContrato'] . "</option>";
                                }
                                ?>
                            </select>
                            <span class="help-block"><?php echo $tipo_contrato_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Agregar">
                        <a href="../crud-Usuario.php" class="btn btn-default">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>