<!DOCTYPE html>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<head>
    <title>Fichas</title>
    <link rel="stylesheet" type="text/css" href="estilos.css">
    </link>
</head>
<style>
body {
    background-color: orange;
}

.buttons {
    display: flex;
    justify-content: space-between;
    margin: 4px 2px;
}
</style>

</html>

<?php
//INSERT INTO `datos` (`id`, `placa`, `fecha`) VALUES ('', NULL, current_timestamp())
include("fichas.php");
$buscar=$_POST["buscar"];
$buscar_valor=$_POST["buscar_valor"];

if ($buscar == "placa") {
    $sql = "SELECT placa,id,fecha from datos WHERE placa LIKE '%".$buscar_valor."%'";
}
else if ($buscar == "id") {
    $sql = "SELECT placa,id,fecha from datos WHERE id=".$buscar_valor;
}
else {
    echo "Opción no válida";
}
?>

<?php include("../templates/pie.php"); ?>