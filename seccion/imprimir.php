<?php
require('../librerias/fpdf.php');
require('../librerias/font/times.php');
//require('../librerias/mc_table.php');
include_once '../databases/BD.php';
$conexionBD=BD::crearInstancia();

if (isset($_POST['inicio'])) {
    $inicio = $_POST['inicio'];}

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
$pdf->Cell(25, 10, 'inicio', 1, 0, 'C');
$pdf->Cell(25, 10, 'Fin', 1, 0, 'C');
$pdf->Cell(40, 10, 'Responsable', 1, 0, 'C');
$pdf->Cell(50, 10, 'Resultados esperados', 1, 1, 'C');
// Imprime el contenido de la tabla $pdf->$pdf->MultiCell(45, 10, utf8_decode($ficha['observacion']), 1,'L',0);
$pdf->MultiCell(45, 10, utf8_decode($ficha['observacion']), 1, 'L', 0);
$pdf->MultiCell(25, 10, $inicio, 1, 'L', 0);
$pdf->MultiCell(25, 10, '', 1, 'L', 0);
$pdf->MultiCell(40, 10, utf8_decode('Mónica Díaz'), 1, 'C', 0);
$pdf->MultiCell(50, 10, utf8_decode(''), 1, 'L', 0);

$pdf->SetWidths(array(30,40,50,60)); // Definir los anchos de cada columna

// Llenar la tabla con algunos datos
$pdf->Row(array(utf8_decode($ficha['observacion']),"Otro texto largo","Más texto","Y más texto"));

$pdf->Output('Reporte.pdf', 'F');

header('Content-type: application/pdf');
header('Content-Disposition: inline; filename="Reporte.pdf"');

readfile('Reporte.pdf');

?>