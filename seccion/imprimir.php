<?php
require('../librerias/fpdf.php');
require('../librerias/font/times.php');
/*include_once '../databases/BD.php';
$conexionBD=BD::crearInstancia();

if (isset($_POST['inicio'])) {
    $inicio = $_POST['inicio'];}

$id = $_GET['id'];
$sql = "SELECT * FROM datos INNER JOIN inventario ON datos.id = inventario.id WHERE datos.id = :id";
//"SELECT datos.placa, datos.id,datos.Empresa,datos.Nombre, datos.fecha, inventario.Estado FROM datos INNER JOIN inventario ON datos.id = inventario.id WHERE inventario.Estado LIKE '%".$buscar_valor."%'";   
$consulta = $conexionBD->prepare($sql);
$consulta->bindParam(':id', $id);
$consulta->execute();
$ficha = $consulta->fetch(PDO::FETCH_ASSOC);*/
//print_r($ficha);

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(40,10,utf8_decode('¡Hóáéla, Mundo!'));
$pdf->Output();

// Crea un nuevo objeto FPDF
/*$pdf = new FPDF();

// Agrega una nueva página
$pdf->AddPage();

// Agrega la fuente Arial
// Comprueba si el navegador admite UTF-8
if (mb_detect_encoding($_SERVER['HTTP_ACCEPT_LANGUAGE'], 'UTF-8', true)) {
    // Establece el juego de caracteres como UTF-8
    mb_internal_encoding('UTF-8');
    // Establece la configuración de salida como UTF-8
    mb_http_output('UTF-8');
}

// Establece la fuente Arial
$pdf->SetFont('Arial','',12);

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

// Obtiene el ancho del texto de la actividad
$pdf->SetWidths(array(40, 20, 20, 40, 40));

$pdf->Cell(40, 10, 'Actividad', 1, 0, 'C');
$pdf->Cell(20, 10, 'inicio', 1, 0, 'L');
$pdf->Cell(20, 10, 'Fin', 1, 0, 'L');
$pdf->Cell(40, 10, 'Responsable', 1, 0, 'C');
$pdf->Cell(40, 10, 'Resultados esperados', 1, 1, 'C');

// Imprime el contenido de la tabla
$pdf->MultiCell(0, 5, $ficha['observacion'], 1, 'L', false, false);
$pdf->Cell(20, 10, '', 1, 0, 'L');
$pdf->Cell(20, 10, '', 1, 0, 'L');
$pdf->Cell(40, 10, 'Mónica Díaz', 1, 0, 'L');
$pdf->Cell(40, 10, '', 1, 1, 'L');

// Genera el PDF
$pdf->Output('Reporte.pdf', 'F');

header('Content-type: application/pdf');
header('Content-Disposition: inline; filename="ficha.pdf"');

readfile('Reporte.pdf');*/

?>