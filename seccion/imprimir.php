<?php
require('../librerias/fpdf.php');
include_once '../databases/BD.php';
$conexionBD=BD::crearInstancia();
print_r($_GET);

$id = $_GET['id'];
$sql = "SELECT * FROM datos INNER JOIN inventario ON datos.id = inventario.id WHERE datos.id = :id";
//"SELECT datos.placa, datos.id,datos.Empresa,datos.Nombre, datos.fecha, inventario.Estado FROM datos INNER JOIN inventario ON datos.id = inventario.id WHERE inventario.Estado LIKE '%".$buscar_valor."%'";   
$consulta = $conexionBD->prepare($sql);
$consulta->bindParam(':id', $id);
$consulta->execute();
$ficha = $consulta->fetch(PDO::FETCH_ASSOC);
print_r($ficha);

/*$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(40,10,'¡Hola, Mundo!');
$pdf->Output();*/
?>