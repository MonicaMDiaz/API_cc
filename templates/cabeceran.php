<?php
session_start();
error_reporting(0);
$varsesion=$_SESSION['usuario'];
if ($varsesion==null || $varsesion==''){
    header("Location:/iniciosesion.html");
    die();
}
?>
<!doctype html>
<html lang="en">

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.2.1 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css"
        integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">


</head>

<body>
    <nav class="navbar navbar-expand navbar-light bg-light">
        <div class="nav navbar-nav">
            <a id="linkInicio" class="nav-item nav-link active" href="../../seccionn/index.php" aria-current="page"
                style="font-family:Arial Rounded MT">Inicio
            </a>
            <a id="linkReportes" class="nav-item nav-link" href="../../seccionn/Reportes/reportegeneral.php"
                style="font-family:Arial Rounded MT">Reportes</a>
            <a id="linkFichas" class="nav-item nav-link" href="../../seccionn/Fichas/fichas.php"
                style="font-family:Arial Rounded MT">Fichas</a>
            <a id="linkCerrarSesion" class="nav-item nav-link" href="/cerrarsesion.php"
                style="font-family:Arial Rounded MT">Cerrar sesión</a>
        </div>
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="row">