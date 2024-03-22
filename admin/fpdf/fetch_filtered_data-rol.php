<?php
require '../../config/database.php';    
$db = new Database();
$con = $db->conectar();

// Initialize HTML variable
$html = '';

// Attempt select query execution
$sql = "SELECT * FROM roles WHERE 1=1 ";

// If search parameter is provided, apply filter by ID or name
if (isset($_POST['search']) && !empty($_POST['search'])) {
    $search = $_POST['search'];
    $sql .= "AND (IDrol LIKE '%$search%' OR NombreRol LIKE '%$search%')";
}

if ($result = mysqli_query($link, $sql)) {
    if (mysqli_num_rows($result) > 0) {
        $html .= "<div class='table-responsive'>";
        $html .= "<table class='table table-bordered table-striped'>";
        $html .= "<thead>";
        $html .= "<tr>";
        $html .= "<th>#</th>";
        $html .= "<th>Nombre</th>";
        $html .= "<th>Acción</th>";
        $html .= "</tr>";
        $html .= "</thead>";
        $html .= "<tbody>";

        while ($row = mysqli_fetch_array($result)) {
            $html .= "<tr>";
            $html .= "<td>" . $row['IDrol'] . "</td>";
            $html .= "<td>" . $row['NombreRol'] . "</td>";
            $html .= "<td>";
            $html .= "<a href='../CRUD/Roles/update-rol.php?id=" . $row['IDrol'] . "' title='Actualizar' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
            $html .= "<a href='../CRUD/Roles/delete-rol.php?id=" . $row['IDrol'] . "' title='Borrar' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
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
    $html .= "ERROR: No se pudo ejecutar $sql. " . mysqli_error($link);
}

// Close connection
mysqli_close($link);

// Output filtered data HTML
echo $html;
?>
