
<?php
require 'config/database.php';
require 'config/config.php';
$db = new Database();
$con = $db->conectar();
$sql = $con->prepare("SELECT id, nombres, precio FROM productos WHERE activo= 1");
$sql->execute();
$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
//destruir la sesion y borrar todo lo que haya en la pagina

//session_destroy();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Consultoria Arquitectura Friend Constructor</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/LOGO.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600&family=Rubik:wght@500;600;700&display=swap"
        rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <!-- Spinner Start -->
    <div id="spinner"
        class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;"></div>
    </div>
    <!-- Spinner End -->


    <!-- Topbar Start -->
    <div class="container-fluid bg-dark px-0">
        <div class="row g-0 d-none d-lg-flex">
            <div class="col-lg-6 ps-5 text-start">
                <div class="h-100 d-inline-flex align-items-center text-white">
                    <span>Nuestras Redes:</span>
                    <a class="btn btn-link text-light" href="https://www.facebook.com/profile.php?id=100088458352909" target="_blank"><i class="fab fa-facebook-f"></i></a>
                    <a class="btn btn-link text-light" href="https://api.whatsapp.com/send?phone=3118830638" target="_blank" ><i class="fab fa-whatsapp"></i></a>
                    <a class="btn btn-link text-light" href=""><i class="fab fa-linkedin-in"></i></a>
                    <a class="btn btn-link text-light" href="https://www.instagram.com/friendconstructorsas/" target="_blank"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
            <div class="col-lg-6 text-end">
                <div class="h-100 topbar-right d-inline-flex align-items-center text-white py-2 px-5">
                    <span class="fs-5 fw-bold me-2"><i class="fa fa-phone-alt me-2"></i>Comunicate:</span>
                    <span class="fs-5 fw-bold">311 8830 638</span>
                </div>
            </div>
        </div>
    </div>
    <!-- Topbar End -->


    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light sticky-top py-0 pe-5">
        <a href="index.html" class="navbar-brand ps-5 me-0">
            <h1 class="text-white m-0">Friend Constructor</h1>
        </a>
        <button type="button" class="navbar-toggler me-0" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <a href="index.html" class="nav-item nav-link">Inicio</a>
                <!--<a href="about.html" class="nav-item nav-link">Sobre Nosotros</a>-->
                
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle active" data-bs-toggle="dropdown">Consultoria</a>
                    <div class="dropdown-menu bg-light m-0">
                        <a href="c_arquitectura.html" class="dropdown-item active">Arquitectura</a>
                        <a href="c_ingenieria.html" class="dropdown-item">Ingenieria </a>
                        <a href="c_topografia.html" class="dropdown-item">Topografia</a>
                    </div>
                </div>
                <a href="proyectos.html" class="nav-item nav-link">Proyectos</a>
                <a href="b_empleo.html" class="nav-item nav-link">Empleo</a>
                <a href="cursos.html" class="nav-item nav-link">Cursos</a>
                <a href="contacto.html" class="nav-item nav-link">Contacto</a>
            </div>
            <a href="" class="btn btn-primary px-3 d-none d-lg-block">Ingresar</a>
            
        </div>
    </nav>
    <!-- Navbar End -->


    <!-- Page Header Start -->
    <div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <h1 class="display-3 text-white animated slideInRight">Consultoria en Arquitectura</h1>
           <!--

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb animated slideInRight mb-0">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Paginas</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Servicios</li>
                </ol>
            </nav>-->
        </div>
    </div>
    <!-- Page Header End -->


    <!-- Service Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center mx-auto pb-4 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                <p class="fw-medium text-uppercase text-primary1 mb-2">Nuestros Servicios y Consultorias</p>
                <h1 class="display-5 mb-4">Ingenieria Civil </h1>
            </div>
            <div class="row gy-5 gx-4">
                
            </div>
        </div>
    </div>
    <!-- Service End -->

    <div class="container-fluid py-5 my-5 px-0">
        <div class="text-center mx-auto wow fadeIn" data-wow-delay="0.1s" style="max-width: 600px;">
            <p class="fw-medium text-uppercase text-primary1 mb-2">Pagina 1 de 3</p>
            <div class="flex-shrink-0 btn-squaree bg-primary rounded-circle">
                <a class="der" href="c_arquitectura1.html"><i class="fa fa-arrow-right text-white"></i></a>
                
            </div>
            
        </div>
    </div>
           
        
    <!-- Footer Start -->
    <div class="container-fluid bg-dark footer mt-5 py-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-3 col-md-6">
                    <h5 class="text-white mb-4">Nuestra oficina</h5>
                    <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>Ibague Tolima Colombia </p>
                    <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>311 8830-638</p>
                    <p class="mb-2"><i class="fa fa-envelope me-3"></i>friendconstructor@gmail.com</p>
                    <div class="d-flex pt-3">
                        <a target="_blank" class="btn btn-square btn-primary rounded-circle me-2" href="https://www.instagram.com/friendconstructorsas/"><i
                                class="fab fa-instagram"></i></a>
                        <a target="_blank" class="btn btn-square btn-primary rounded-circle me-2" href="https://www.facebook.com/profile.php?id=100088458352909"><i
                                class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-square btn-primary rounded-circle me-2" href="https://api.whatsapp.com/send?phone=3118830638" target="_blank"><i class="fab fa-whatsapp"></i></a>
                        <a class="btn btn-square btn-primary rounded-circle me-2" href=""><i
                                class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5 class="text-white mb-4">Links</h5>
                    <a class="btn btn-link" href="https://www.sena.edu.co/es-co/Paginas/default.aspx" target="_blank">SENA</a>
                    <a class="btn btn-link" href="https://www.unibague.edu.co/" target="_blank">Universidad de Ibagué</a>
                    <a class="btn btn-link" href="https://ibague.gov.co/portal/index.php#gsc.tab=0" target="_blank">Alcaldia de Ibagué</a>
                    <a class="btn btn-link" href="https://www.tolima.gov.co/" target="_blank">Gobernación de Tolima</a>
                    <a class="btn btn-link" href="https://ibague.gov.co/portal/seccion/contenido/index.php?type=2&cnt=129#gsc.tab=0" target="_blank">Ibagué Vibra</a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5 class="text-white mb-4">Hora de trabajo</h5>
                    <p class="mb-1">lunes - viernes</p>
                    <h6 class="text-light">08:00 am - 12:00 m <br>02:00 pm - 06:00 pm</h6>
                    <p class="mb-1">Sabados</p>
                    <h6 class="text-light">08:00 am - 12:00 m</h6>
                    <p class="mb-1">domingo</p>
                    <h6 class="text-light">Cerrado</h6>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5 class="text-white mb-4">Información Legal</h5>
                    <p class="mb-2"><i class="fa fa-file-contract"></i> Términos y condiciones </p>
                    <p class="mb-2"><i class="fa fa-file-archive"></i> Politica de datos</p>
                    <p class="mb-2"><i class="fas fa-copyright"></i> Copyright friendconstructor 2023</p>
                   
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->


    <!-- Copyright Start -->
    <div class="container-fluid copyright bg-dark py-4">
        <div class="container text-center">
            <p class="mb-2">Copyright &copy; <a class="fw-semi-bold" href="#">Friend Constructora</a>, All Right Reserved.
            </p>
            <p class="mb-0">Designed By <a class="fw-semi-bold" href="">HTML Codex</a> Distributed
                By: <a href="https://www.facebook.com/Esquivel7809" target="_blank">Esquivel-Ingeniero</a> </p>
        </div>
    </div>
    <!-- Copyright End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square rounded-circle back-to-top"><i
            class="bi bi-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>
