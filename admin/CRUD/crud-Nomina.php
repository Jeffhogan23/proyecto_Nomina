<?php
session_start();

include '../../includes/validar_sesion.php';
require '../../config/database.php';

$db = new Database();
$con = $db->conectar();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador | Nomina</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="../../css/styles-admin.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/styles-crud.css">
    <script src="../../js/script-read-crud.js"></script>
</head>

<body>
    <!-- header -->
    <div class="container-fluid admin-header">
        <div class="row" id="header">
            <div class="col-md-9">
                <h2>Contax Employee</h2>
            </div>
            <div class="col-md-1">
                <a href="../../includes/salir.php" type="button" class="btn btn-link" aria-label="Right Align">
                    <span class="glyphicon glyphicon-log-out" aria-hidden="true"></span>
                </a>
            </div>
        </div>
    </div>

    <!-- main content -->
    <div class="container-fluid">
        <div class="sidebar col-md-2">
            <a class="icon-sidebar" href="../index-admin.php">
                <i class="bi bi-card-list"></i>
            </a>
            <?php
                $query = "SHOW TABLES";
                $stmt = $con->query($query);
                $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
                foreach ($tables as $table) {
                    echo '<a href="crud-' . ucfirst($table) . '.php"><li>' . ucfirst($table) . '</li></a>';
                }
                ?>
        </div>

        <div class="main-content">
            <div class="crud-container">
                <h2 style="padding-left: 163px;" class="col-md-7">Nomina</h2>
                <div class="wrapper">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-9">
                                <div class="section-content">
                                    <div class="col-md-6">
                                        <input type="text" id="search" placeholder="Buscar..." class="form-control">
                                    </div>
                                    <div class="col-md-3">
                                        <a href="Nomina/create-nom.php" class="btn btn-success">
                                            Agregar
                                        </a>
                                    </div>
                                </div>
                                <?php

                                    // Attempt select query execution
                                    $sql = "SELECT n.*, u.Nombre, u.Apellido, b.TipoBonificacion FROM nomina n 
                                            INNER JOIN usuario u ON n.IDusuario = u.IDusuario
                                            LEFT JOIN bonificaciones b ON n.IDBonificacion = b.IDBonificacion";
                                    $result = mysqli_query($link, $sql);

                                    if ($result= mysqli_query($link, $sql)) {
                                        if (mysqli_num_rows($result) > 0) {
                                            echo "<table style='margin-left: 15px; width: 1000px;' class='table table-bordered table-striped'>";
                                                echo "<thead>";
                                                echo "<tr>";
                                                    echo "<th>#</th>";
                                                    echo "<th>Empleado</th>";
                                                    echo "<th>Fecha Nómina</th>";
                                                    echo "<th>Mes</th>";
                                                    echo "<th>Días Trabajados</th>";
                                                    echo "<th>Salario Neto</th>";
                                                    echo "<th>Valor Parafiscales</th>";
                                                    echo "<th>Valor Préstamo</th>";
                                                    echo "<th>Total Deducidos</th>";
                                                    echo "<th>Bonificación</th>";
                                                    echo "<th>Neto Pagado</th>";
                                                    echo "<th>Acción</th>";
                                                echo "</tr>";
                                                echo "</thead>";
                                                echo "<tbody>";
                                                while ($row = mysqli_fetch_array($result)) {
                                                    echo "<tr>";
                                                        echo "<td>" . $row['IDNomina'] . "</td>";
                                                        echo "<td>" . $row['Nombre'] . " " . $row['Apellido'] . "</td>";
                                                        echo "<td>" . $row['FechaNomina'] . "</td>";
                                                        echo "<td>" . $row['Mes'] . "</td>";
                                                        echo "<td>" . $row['DiasTrabajados'] . "</td>";
                                                        echo "<td>" . $row['SalarioNeto'] . "</td>";
                                                        echo "<td>" . $row['ValorParafiscales'] . "</td>";
                                                        echo "<td>" . $row['ValorPrestamo'] . "</td>";
                                                        echo "<td>" . $row['TotalDeducidos'] . "</td>";
                                                        echo "<td>" . $row['TipoBonificacion'] . "</td>";
                                                        echo "<td>" . $row['NetoPagado'] . "</td>";
                                                        echo "<td>";
                                                            echo "<a href='Nomina/update-nom.php?id=" . $row['IDNomina'] . "' title='Actualizar' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                                                            echo "<a href='Nomina/delete-nom.php?id=" . $row['IDNomina'] . "' title='Borrar' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
                                                        echo "</td>";
                                                    echo "</tr>";
                                                }
                                                echo "</tbody>";
                                            echo "</table>";
                                            
                                            // Free result set
                                            mysqli_free_result($result);
                                        } else {
                                            echo "<p class='lead'><em>No records were found.</em></p>";
                                        }
                                    } else {
                                        echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                                    }

                                    // Close connection
                                    mysqli_close($link);
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>