<?php
require('../librerias/fpdf.php');
include_once '../databases/BD.php';
$conexionBD=BD::crearInstancia();
//print_r($_GET);
if (isset($_POST['inicio'])) {
    $inicio = $_POST['inicio'];}
    echo $inicio;
$id = isset($_POST['id']) ? $_POST['id'] : null;
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
// Agrega un título
$pdf->Cell(0, 10, 'Informe de Datos', 0, 1, 'C');

// Imprime la información de la tabla
$pdf->Cell(0, 10, 'ID de bus: ' . $ficha['id'], 0, 1);
$pdf->Cell(0, 10, 'Empresa: ' . $ficha['Empresa'], 0, 1);
$pdf->Cell(0, 10, 'Placa: ' . $ficha["placa"], 0, 1);
$pdf->Output('Informe.pdf', 'I');
//$pdf->Output();


$id = $_GET['id'];

// Consulta la información de la ficha
$sql = "SELECT * FROM datos INNER JOIN inventario ON datos.id = inventario.id WHERE datos.id = :id";
$conexionBD = BD::crearInstancia();
$consulta = $conexionBD->prepare($sql);
$consulta->bindParam(':id', $id);
$consulta->execute();
$ficha = $consulta->fetch(PDO::FETCH_ASSOC);

$fechaInicio = $_POST['fechaInicio'];
$fechaFin = $_POST['fechaFin'];
// Crea un nuevo objeto FPDF
$pdf = new FPDF();

// Agrega una nueva página
$pdf->AddPage();

// Establece la fuente
$pdf->SetFont('Arial', '', 12);

// Imprime el título de la ficha
$pdf->Cell(0, 10, 'Ficha de inspección de bus', 0, 1, 'C');

// Imprime la información de la ficha
$pdf->Cell(0, 10, 'ID de bus: ' . $ficha['id'], 0, 1, 'L');
$pdf->Cell(0, 10, 'Empresa: ' . $ficha['Empresa'], 0, 1, 'L');
$pdf->Cell(0, 10, 'Placa: ' . $ficha['placa'], 0, 1, 'L');
$pdf->Cell(0, 10, 'Nombre conductor: ' . $ficha['Nombre'], 0, 1, 'L');
$pdf->Cell(0, 10, 'Identificación: ' . $ficha['nit'] . ' ' . $ficha['nid'], 0, 1, 'L');
$pdf->Cell(0, 10, 'Fecha y hora: ' . $ficha['fecha'], 0, 1, 'L');

// Imprime el plan de acción
$pdf->Cell(0, 10, 'Plan de acción', 0, 1, 'C');

$pdf->Cell(40, 10, 'Actividad', 1, 0, 'C');
$pdf->Cell(20, 10, $fechaInicio, 1, 0, 'L');
$pdf->Cell(20, 10, $fechaFin, 1, 0, 'L');
$pdf->Cell(40, 10, 'Responsable', 1, 0, 'C');
$pdf->Cell(40, 10, 'Resultados esperados', 1, 1, 'C');

$pdf->Cell(40, 10, $ficha['observacion'], 1, 0, 'L');
$pdf->Cell(20, 10, '', 1, 0, 'L');
$pdf->Cell(20, 10, '', 1, 0, 'L');
$pdf->Cell(40, 10, 'Mónica Díaz', 1, 0, 'L');
$pdf->Cell(40, 10, '', 1, 1, 'L');

// Genera el PDF
$pdf->Output('ficha.pdf', 'F');

header('Content-type: application/pdf');
header('Content-Disposition: inline; filename="ficha.pdf"');

readfile('ficha.pdf');*/

?>