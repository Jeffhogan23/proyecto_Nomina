<?php
require '../../config/config.php';
// Initialize HTML variable
$html = '';

// Attempt select query execution
$sql = "SELECT * FROM cargo WHERE 1=1";

// If search parameter is provided, apply filter by ID or name
if (isset($_POST['search']) && !empty($_POST['search'])) {
    $search = $_POST['search'];
    $sql .= " AND (IDcargo LIKE '%$search%' OR NombreCargo LIKE '%$search%' OR SalarioCargo LIKE '%$search%')";
}

if ($result = mysqli_query($conn, $sql)) {
    if (mysqli_num_rows($result) > 0) {
        $html .= "<div style='padding-left:105px; margin-left:30px;' class='table-responsive'>";
        $html .= "<table class='table table-bordered table-striped'>";
        $html .= "<thead>";
        $html .= "<tr>";
        $html .= "<th>#</th>";
        $html .= "<th>Nombre del Cargo</th>";
        $html .= "<th>Salario</th>";
        $html .= "<th>Acción</th>";
        $html .= "</tr>";
        $html .= "</thead>";
        $html .= "<tbody>";

        while ($row = mysqli_fetch_array($result)) {
            $html .= "<tr>";
            $html .= "<td>" . $row['IDcargo'] . "</td>";
            $html .= "<td>" . $row['NombreCargo'] . "</td>";
            $html .= "<td>$" .$row['SalarioCargo'] . "</td>";
            $html .= "<td>";
            $html .= "<a href='../CRUD/Cargo/update-car.php?id=" . $row['IDcargo'] . "' title='Actualizar' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
            $html .= "<a href='../CRUD/Cargo/delete-car.php?id=" . $row['IDcargo'] . "' title='Borrar' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
            $html .= "</td>";
            $html .= "</tr>";
        }

        $html .= "</tbody>";
        $html .= "</table>";
        $html .= "</div>";

        // Free result set
        mysqli_free_result($result);
    } else {
        $html .= "<p style='padding-left:150px;' class='lead'><em>No se encontraron registros.</em></p>";
    }
} else {
    $html .= "ERROR: No se pudo ejecutar $sql. " . mysqli_error($conn);
}

// Close connection
mysqli_close($conn);

// Output filtered data HTML
echo $html;
?>
