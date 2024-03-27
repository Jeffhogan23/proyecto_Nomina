<?php
// Include config file
require_once "../../config/config.php";

// Initialize HTML variable
$html = '';

// Attempt select query execution
$sql = "SELECT * FROM prestamos";

// If search parameter is provided, apply filter by ID or other columns
if (isset($_POST['search']) && !empty($_POST['search'])) {
    $search = $_POST['search'];
    $sql .= " WHERE IDpres LIKE '%$search%' OR IDusuario LIKE '%$search%' OR (SELECT Nombre FROM usuario WHERE IDusuario = prestamos.IDusuario) LIKE '%$search%'";
}

if ($result = mysqli_query($link, $sql)) {
    if (mysqli_num_rows($result) > 0) {
        $html .= "<div style='padding-left:105px; margin-left:30px;' class='table-responsive'>";
        $html .= "<table class='table table-bordered table-striped'>";
        $html .= "<thead>";
        $html .= "<tr>";
        $html .= "<th>#</th>";
        $html .= "<th>ID Usuario</th>";
        $html .= "<th>Nombre Usuario</th>";
        $html .= "<th>Fecha del Préstamo</th>";
        $html .= "<th>Valor del Préstamo</th>";
        $html .= "<th>Cantidad de Cuotas</th>";
        $html .= "<th>Valor de Cuotas</th>";
        $html .= "<th>Estado del Préstamo</th>";
        $html .= "<th>Acción</th>";
        $html .= "</tr>";
        $html .= "</thead>";
        $html .= "<tbody>";

        while ($row = mysqli_fetch_array($result)) {
            $userQuery = "SELECT Nombre FROM usuario WHERE IDusuario = " . $row['IDusuario'];
            $userResult = mysqli_query($link, $userQuery);
            $userName = mysqli_fetch_assoc($userResult)['Nombre'];

            $html .= "<tr>";
            $html .= "<td>" . $row['IDpres'] . "</td>";
            $html .= "<td>" . $row['IDusuario'] . "</td>";
            $html .= "<td>" . $userName . "</td>";
            $html .= "<td>" . $row['Fecha_pres'] . "</td>";
            $html .= "<td>" . $row['Valor_pres'] . "</td>";
            $html .= "<td>" . $row['CantidadCuotas'] . "</td>";
            $html .= "<td>" . $row['ValorCuotas'] . "</td>";
            $html .= "<td>" . $row['EstadoPres'] . "</td>";
            $html .= "<td>";
            $html .= "<a href='../CRUD/Prestamos/update-pres.php?id=" . $row['IDpres'] . "' title='Actualizar' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
            $html .= "<a href='../CRUD/Prestamos/delete-pres.php?id=" . $row['IDpres'] . "' title='Borrar' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
            $html .= "</td>";
            $html .= "</tr>";
        }

        $html .= "</tbody>";
        $html .= "</table>";
        $html .= "</div>";

        // Free result set
        mysqli_free_result($result);
    } else {
        $html .= "<p class='lead'><em>No se encontraron registros.</em></p>";
    }
} else {
    $html .= "ERROR: No se pudo ejecutar $sql. " . mysqli_error($link); // Output error message
}

// Close connection
mysqli_close($link);

// Output filtered data HTML
echo $html;
?>