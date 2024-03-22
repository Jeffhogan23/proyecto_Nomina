<?php
session_start();

include '../includes/validar_sesion.php';
require '../config/database.php';

$db = new Database();
$con = $db->conectar();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contador | Inicio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
    <link href="../css/styles-admin.css" rel="stylesheet">
</head>

<body>
    <!-- header -->
    <div class="container-fluid admin-header">
        <div class="row" id="header">
            <div class="col-md-9">
                <h2>Contax Employee</h2>
            </div>
            <div class="col-md-1">
                <a type="button" class="btn btn-link" aria-label="Right Align">
                    <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                </a>
                <a href="../includes/salir.php" type="button" class="btn btn-link" aria-label="Right Align">
                    <span class="glyphicon glyphicon-log-out" aria-hidden="true"></span>
                </a>
            </div>
        </div>
    </div>

    <!--  main content -->
    <div class="container">
        <div class="sidebar col-md-2">
            <a class="icon-sidebar" href="index-contador.php">
                <i class="bi bi-card-list"></i>
            </a>
            <?php
                $query = "SHOW TABLES";
                $stmt = $con->query($query);
                $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);

                foreach ($tables as $table) {
                    echo '<a href="CRUD/crud-' . ucfirst($table) . '.php"><li>' . ucfirst($table) . '</li></a>';
                }
                ?>  
        </div>
        <div class="main-content">
            <h2 style="padding-left: 110px;">Bienvenido, Contador</h2>
            <hr>
            <div class="crud-container">
                <!-- CRUD interface will be inserted here -->
            </div>
        </div>
    </div>
</body>

</html>