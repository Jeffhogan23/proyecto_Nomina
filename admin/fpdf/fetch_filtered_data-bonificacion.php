<?php
// Include config file
require '../../config/config.php';

// Initialize HTML variable
$html = '';

// Attempt select query execution
$sql = "SELECT * FROM bonificaciones WHERE 1=1";

// If search parameter is provided, apply filter by ID or name
if (isset($_POST['search']) && !empty($_POST['search'])) {
    $search = $_POST['search']; 
    $sql .= " AND (IDBonificacion LIKE '%$search%' OR TipoBonificacion LIKE '%$search%' OR MontoBonificacion LIKE '%$search%')";
}

if ($result = mysqli_query($conn, $sql)) {
    if (mysqli_num_rows($result) > 0) {
        $html .= "<div style='padding-left:105px; margin-left:30px;' class='table-responsive'>";
        $html .= "<table class='table table-bordered table-striped'>";
        $html .= "<thead>";
        $html .= "<tr>";
        $html .= "<th>#</th>";
        $html .= "<th>Tipo de Bonificación</th>";
        $html .= "<th>Monto de Bonificación</th>";
        $html .= "<th>Acción</th>";
        $html .= "</tr>";
        $html .= "</thead>";
        $html .= "<tbody>";

        while ($row = mysqli_fetch_array($result)) {
            $html .= "<tr>";
            $html .= "<td>" . $row['IDBonificacion'] . "</td>";
            $html .= "<td>" . $row['TipoBonificacion'] . "</td>";
            $html .= "<td>" . $row['MontoBonificacion'] . "</td>";
            $html .= "<td>";
            $html .= "<a href='../CRUD/Bonificaciones/update-boni.php?id=" . $row['IDBonificacion'] . "' title='Actualizar' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
            $html .= "<a href='../CRUD/Bonificaciones/delete-boni.php?id=" . $row['IDBonificacion'] . "' title='Borrar' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
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
    $html .= "ERROR: No se pudo ejecutar $sql. " . mysqli_error($conn); // Output error message
}

// Close connection
mysqli_close($conn);

// Output filtered data HTML
echo $html;
?>

