<?php
session_start();

include '../../includes/validar_sesion.php';
require '../../config/database.php';

$db = new Database();
$con = $db->conectar();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador | Cargo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="../../css/styles-admin.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/styles-crud.css">
    <script src="../../js/script-read-crud.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();

        // Function to fetch and display filtered data
        function fetchFilteredData(keyword) {
            // Perform AJAX request to fetch filtered data
            $.ajax({
                url: ' ../fpdf/fetch_filtered_data-cargo.php',
                type: 'POST',
                data: {
                    search: keyword
                },
                success: function(data) {
                    $('#table-container').html(data);
                }
            });
        }

        // Add event listener for search input
        $('#search').on('input', function() {
            // Get the search keyword
            let keyword = $(this).val();
            fetchFilteredData(keyword);
        });

        // Add event listener for download icon
        $('.download-icon').on('click', function() {
            // Get the search keyword
            let keyword = $('#search').val();
            // Redirect to the PHP script to generate PDF with search parameter
            window.location.href = '../fpdf/informe-cargo.php?search=' + encodeURIComponent(keyword);
        });
    });
    </script>
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
                <h2 style="padding-left: 163px;" class="col-md-7">Cargos</h2> 
                <div class="wrapper">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <div style="margin-right:150px; margin-left: 120px;" class="section-content">
                                    <div class="col-md-6">
                                        <input type="text" id="search" placeholder="Buscar..." class="form-control">
                                    </div>
                                    <div style="margin-left: 340px;" class="col-md-6">
                                        <a href="Cargo/create-car.php" class="btn btn-success">
                                            Agregar
                                        </a>
                                    </div>
                                    <!-- Enlace al script PHP que genera el PDF -->
                                    <a href="#" class="download-icon" title="Descargar informe">
                                        <i class="fa fa-download" style="color: black;"></i>
                                    </a>
                                </div>

                                <!-- Container to hold filtered data -->
                                <div id="table-container">
                                    <?php include '../fpdf/fetch_filtered_data-cargo.php'; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>