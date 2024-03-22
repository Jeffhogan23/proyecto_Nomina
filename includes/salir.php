<?php
session_start();
	unset($_SESSION['usuario']); 
	unset($_SESSION['tipo']);
	$_SESSION = array();
	session_destroy();
	session_write_close();
	header("Location: ../index.html");
?>
	