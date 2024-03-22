<?php
    if (!isset($_SESSION['usuario']) || !isset($_SESSION['tipo'])) {

        unset($_SESSION['usuario']);
        unset($_SESSION['tipo']);
        $_SESSION = array();
        session_destroy();
        session_write_close();
        echo "<script>alert('INGRESE CREDENCIALES DE ACCESO')</script>";
        echo "<script>window.location='../index_iniciar_sesion.html'</script>";
        exit;
    }
?>