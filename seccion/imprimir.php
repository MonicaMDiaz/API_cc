<?php
require('../librerias/fpdf.php');
require('../librerias/font/times.php');
//require('../librerias/mc_table.php');
include_once '../databases/BD.php';
$conexionBD=BD::crearInstancia();

$Obs= isset($_POST['Obs']) ? $_POST['Obs']:'';
$inicio=isset($_POST['inicio']) ? $_POST['inicio'] : '';
$fin=isset($_POST['fin']) ? $_POST['fin'] :'';
$Responsable= isset($_POST['Responsable']) ? $_POST['Responsable'] :'';
$Resultados= isset($_POST['Resultados']) ? $_POST['Resultados'] : '';

$id = $_GET['id'];
$sql = "SELECT * FROM datos INNER JOIN inventario ON datos.id = inventario.id WHERE datos.id = :id";
//"SELECT datos.placa, datos.id,datos.Empresa,datos.Nombre, datos.fecha, inventario.Estado FROM datos INNER JOIN inventario ON datos.id = inventario.id WHERE inventario.Estado LIKE '%".$buscar_valor."%'";   
$consulta = $conexionBD->prepare($sql);
$consulta->bindParam(':id', $id);
$consulta->execute();
$ficha = $consulta->fetch(PDO::FETCH_ASSOC);
//print_r($ficha);

// Crea un nuevo objeto FPDF
$pdf = new FPDF();

// Agrega una nueva página
$pdf->AddPage();
// Establece la fuente Arial
$pdf->SetFont('Arial','',12);
//$pdf->Cell(40,10,utf8_decode('¡Hóáéla, Mundo!'));
// Imprime el título de la ficha
$pdf->Cell(0,10,utf8_decode('Plan de acción'), 0, 1, 'C');

// Imprime la información de la ficha
$pdf->Cell(0, 10, 'ID de bus: ' . $ficha['id'], 0, 1, 'L');
$pdf->Cell(0, 10, 'Empresa: ' . $ficha['Empresa'], 0, 1, 'L');
$pdf->Cell(0, 10, 'Placa: ' . $ficha['placa'], 0, 1, 'L');
$pdf->Cell(0, 10, utf8_decode('Nombre conductor: ' . $ficha['Nombre']), 0, 1, 'L');
$pdf->Cell(0, 10, utf8_decode('Identificación: ' . $ficha['nit'] . ' ' . $ficha['nid']), 0, 1, 'L');
$pdf->Cell(0, 10, 'Fecha y hora: ' . $ficha['fecha'], 0, 1, 'L');

$pdf->Cell(0, 10, '', 0, 1, 'L');

$pdf->Cell(45, 10, 'Actividad', 1, 0, 'C'); 
$pdf->Cell(25, 10, 'Inicio', 1, 0, 'C');
$pdf->Cell(25, 10, 'Fin', 1, 0, 'C');
$pdf->Cell(40, 10, 'Responsable', 1, 0, 'C');
$pdf->Cell(50, 10, 'Resultados esperados', 1, 1, 'C');

$pdf->SetWidths(array(45,25,25,40,50)); // Definir los anchos de cada columna
$pdf->SetAligns(array('L','C','C','C','L'));

// Llenar la tabla con algunos datos
$pdf->Row(array(utf8_decode($Obs),$inicio,$fin,utf8_decode($Responsable),utf8_decode($Resultados)));

$pdf->Output('Reporte.pdf', 'F');

header('Content-type: application/pdf');
header('Content-Disposition: inline; filename="Reporte.pdf"');

readfile('Reporte.pdf');

?>