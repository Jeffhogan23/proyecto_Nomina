<?php
// Incluir el archivo de configuración
require 'config/database.php';
$db = new Database();
$con = $db->conectar();

// Obtener los departamentos
$sql_departamentos = "SELECT IDdep, NombreDep FROM departamento ORDER BY NombreDep ASC";
$resultado_departamentos = mysqli_query($link, $sql_departamentos);


// Obtener los cargos
$sql_cargos = "SELECT IDcargo, NombreCargo, SalarioCargo FROM cargo";
$resultado_cargos = mysqli_query($link, $sql_cargos);

// Obtener los tipos de contrato
$sql_tipos_contrato = "SELECT IDtipContrato, NombreTipContrato FROM tipocontrato";
$resultado_tipos_contrato = mysqli_query($link, $sql_tipos_contrato);


// Función para cargar las ciudades según el departamento seleccionado
function cargarCiudades($idDep = null)
{
  global $link;

  // Solo ejecutar la consulta si se seleccionó un departamento
  if ($idDep !== null) {
    $sql_ciudades = "SELECT IDciu, NombreCiu FROM ciudad WHERE IDdep = '$idDep'";
    $resultado_ciudades = mysqli_query($link, $sql_ciudades);
    $opciones_ciudades = "<option value=''>Seleccione una ciudad</option>";
    while ($row_ciudad = mysqli_fetch_assoc($resultado_ciudades)) {
      $opciones_ciudades .= "<option value='" . $row_ciudad['IDciu'] . "'>" . $row_ciudad['NombreCiu'] . "</option>";
    }
    return $opciones_ciudades;
  }

  // Si no se seleccionó un departamento, retornar una opción vacía
  return "<option value=''>Seleccione un departamento primero</option>";
}

// Función para validar el correo electrónico
function validarCorreo($email)
{
  $regex = '/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/';
  return preg_match($regex, $email);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="css/styles-register.css">
  <script>
    // Función para cargar el salario según el cargo seleccionado
    function cargarSalario() {
      const cargoSeleccionado = document.getElementById("cargo").value;
      const salarioInput = document.getElementById("salario");

      // Asignar el salario correspondiente al cargo seleccionado
      salarioInput.value = cargoSeleccionado;
    }

    // Función para habilitar/deshabilitar el botón de registro
    function habilitarBoton() {
      const aceptaTerminos = document.getElementById("aceptaTerminos").checked;
      const botonRegistro = document.getElementById("botonRegistro");
      botonRegistro.disabled = !aceptaTerminos;
    }

    // Función para mostrar/ocultar la contraseña
    const passwordField = document.querySelector('.password-field');
    const showPasswordBtn = passwordField.querySelector('.show-password');

    showPasswordBtn.addEventListener('click', function () {
      const passwordInput = passwordField.querySelector('input');
      const isPasswordVisible = passwordInput.type === 'text';

      if (isPasswordVisible) {
        passwordInput.type = 'password';
        showPasswordBtn.innerHTML = `
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
            <path d="M12 15a3 3 0 100-6 3 3 0 000 6z" />
            <path fill-rule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 010-1.113zM17.25 12a5.25 5.25 0 11-10.5 0 5.25 5.25 0 0110.5 0z" clip-rule="evenodd" />
          </svg>
        `;
      } else {
        passwordInput.type = 'text';
        showPasswordBtn.innerHTML = `
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
            <path d="M3.53 2.47a.75.75 0 00-1.06 1.06l18 18a.75.75 0 101.06-1.06l-18-18zM22.676 12.553a11.249 11.249 0 01-2.631 4.31l-3.099-3.099a5.25 5.25 0 00-6.71-6.71L7.759 4.577a11.217 11.217 0 014.242-.827c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113z" />
            <path d="M15.75 12c0 .18-.013.359-.037.535l3.037 3.037a11.198 11.198 0 004.37-5.327c-.078-.188-.144-.378-.198-.572l-7.172 2.327z" />
          </svg>
        `;
      }
    });

    function cargarCiudades(idDep) {
      var selectCiudad = document.getElementById("ciudad");
      var xhr = new XMLHttpRequest();

      xhr.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
          selectCiudad.innerHTML = this.responseText;
        }
      };

      xhr.open("GET", "cargar_ciudades.php?idDep=" + idDep, true);
      xhr.send();
    }
  </script>
</head>

<body>
  <div class="container">
    <div class="form-container">
      <form class="form-register" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <div class="form-column">
          <div class="form-group">
            <label for="nombre">Nombre </label>
            <input type="text" id="nombre" name="nombre" class="controls" required pattern="[a-zA-Z\s]+"
              title="Solo se permiten letras">
          </div>
          <div class="form-group">
            <label for="apellido">Apellido </label>
            <input type="text" id="apellido" name="apellido" class="controls" required pattern="[a-zA-Z\s]+"
              title="Solo se permiten letras">
          </div>
          <div class="form-group">
            <label for="telefono">Teléfono </label>
            <input type="text" id="telefono" name="telefono" class="controls" required pattern="[0-9]{1,11}"
              title="Solo se permiten números (máximo 11 dígitos)">
          </div>
          <div class="form-group">
            <label for="email">Correo electrónico </label>
            <input type="email" id="email" name="email" class="controls" required <?php if (isset ($_POST['email']) && !validarCorreo($_POST['email'])) {
              echo 'value="" style="border-color: red;"';
            } ?>>
            <?php if (isset ($_POST['email']) && !validarCorreo($_POST['email'])) {
              echo '<span style="color: red;">Correo electrónico inválido</span>';
            } ?>
          </div>
          <div class="form-group">
            <label for="password">Contraseña </label>
            <div class="password-field">
              <input style="padding-bottom: 11px; margin-top: 9px;" type="password" id="password" name="password" class="controls" required>
              <span class="show-password">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                  <path d="M12 15a3 3 0 100-6 3 3 0 000 6z" />
                  <path fill-rule="evenodd"
                    d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 010-1.113zM17.25 12a5.25 5.25 0 11-10.5 0 5.25 5.25 0 0110.5 0z"
                    clip-rule="evenodd" />
                </svg>
              </span>
            </div>
          </div>
        </div>
        <div class="form-column">
          <div class="form-group">
            <label for="Departamento">Departamento </label>
            <select class="controls select" name="Departamento" id="Departamento" onchange="cargarCiudades(this.value)">
              <option value="">Seleccione un departamento</option>
              <?php
              // Rellenar las opciones del select de departamentos
              while ($row_departamento = mysqli_fetch_assoc($resultado_departamentos)) {
                echo "<option value='" . $row_departamento['IDdep'] . "'>" . $row_departamento['NombreDep'] . "</option>";
              }
              ?>
            </select>
          </div>
          <div class="form-group">
            <label for="ciudad">Ciudad:</label>
            <select class="controls select" name="ciudad" id="ciudad">
              <?php echo cargarCiudades(); ?>
            </select>
          </div>
          <div class="form-group">
            <label for="cargo">Cargo:</label>
            <select class="controls select" name="cargo" id="cargo" onchange="cargarSalario()">
              <option value="">Seleccione un cargo</option>
              <?php
              // Rellenar las opciones del select de cargos
              while ($row_cargo = mysqli_fetch_assoc($resultado_cargos)) {
                echo "<option value='" . $row_cargo['SalarioCargo'] . "'>" . $row_cargo['NombreCargo'] . "</option>";
              }
              ?>
            </select>
          </div>
          <div class="form-group">
            <label for="salario">Salario:</label>
            <input class="controls" type="text" name="salario" id="salario" readonly>
          </div>
          <div class="form-group">
            <label for="tipo_contrato">Tipo de Contrato:</label>
            <select class="controls select" name="tipo_contrato" id="tipo_contrato">
              <option value="">Seleccione un tipo de contrato</option>
              <?php
              // Rellenar las opciones del select de tipos de contrato
              while ($row_tipo_contrato = mysqli_fetch_assoc($resultado_tipos_contrato)) {
                echo "<option value='" . $row_tipo_contrato['IDtipContrato'] . "'>" . $row_tipo_contrato['NombreTipContrato'] . "</option>";
              }
              ?>
            </select>
          </div>
        </div>
        <div class="checkbox-button-container">
          <div class="form-group">
            <input type="checkbox" id="aceptaTerminos" name="aceptaTerminos" onchange="habilitarBoton()"> 
            <label for="aceptaTerminos">Acepta términos y condiciones</label>
          </div>
        </div>
        <button type="submit" class="register-button" id="botonRegistro" disabled>Registrar</button>
      </form>
    </div>
  </div>
</body>

</html>