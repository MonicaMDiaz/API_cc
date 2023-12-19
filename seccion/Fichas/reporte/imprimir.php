<?php
require('../../../librerias/fpdf.php');
require('../../../librerias/font/times.php');
//require('../librerias/mc_table.php');
include_once '../../../databases/BD.php';
$conexionBD=BD::crearInstancia();

$Obs1= isset($_POST['Obs1']) ? $_POST['Obs1']:'';
$inicio1=isset($_POST['inicio1']) ? $_POST['inicio1'] : '';
$fin1=isset($_POST['fin1']) ? $_POST['fin1'] :'';
$Responsable1= isset($_POST['Responsable1']) ? $_POST['Responsable1'] :'';
$Resultados1= isset($_POST['Resultados2']) ? $_POST['Resultados2'] : '';

$Obs2= isset($_POST['Obs2']) ? $_POST['Obs2']:'';
$inicio2=isset($_POST['inicio2']) ? $_POST['inicio2'] : '';
$fin2=isset($_POST['fin2']) ? $_POST['fin2'] :'';
$Responsable2= isset($_POST['Responsable2']) ? $_POST['Responsable2'] :'';
$Resultados2= isset($_POST['Resultados2']) ? $_POST['Resultados2'] : '';

$id = $_GET['id'];
$sql = "SELECT * FROM datos INNER JOIN inventario ON datos.id = inventario.id WHERE datos.id = :id";
//"SELECT datos.placa, datos.id,datos.Empresa,datos.Nombre, datos.fecha, inventario.Estado FROM datos INNER JOIN inventario ON datos.id = inventario.id WHERE inventario.Estado LIKE '%".$buscar_valor."%'";   
$consulta = $conexionBD->prepare($sql);
$consulta->bindParam(':id', $id);
$consulta->execute();
$ficha = $consulta->fetch(PDO::FETCH_ASSOC);
//print_r($ficha);

// Crea un nuevo objeto FPDF
$pdf = new FPDF("L");

// Agrega una nueva página
$pdf->AddPage();
// Establece la fuente Arial
$pdf->SetFont('Arial','',12);
//$pdf->Cell(40,10,utf8_decode('¡Hóáéla, Mundo!'));
// Imprime el título de la ficha
$pdf->Cell(0,10,utf8_decode('Plan de acción'), 0, 1, 'C');

// Imprime la información de la ficha
$pdf->Cell(0, 10, 'ID de bus: ' . $ficha['id'], 0, 0, 'L');
$pdf->SetX(60);
$pdf->Cell(0, 10, utf8_decode('Número de ficha: ' . $ficha['n']), 0, 0, 'L');
$pdf->SetX(120);
$pdf->Cell(0, 10, 'Empresa: ' . $ficha['Empresa'], 0, 0, 'L');
$pdf->SetX(180);
$pdf->Cell(0, 10, 'Placa: ' . $ficha['placa'], 0, 1, 'L');
$pdf->Cell(0, 10, utf8_decode('Nombre conductor: ' . $ficha['Nombre']), 0, 0, 'L');
$pdf->SetX(100);
$pdf->Cell(0, 10, utf8_decode('Identificación: ' . $ficha['nit'] . ' ' . $ficha['nid']), 0, 0, 'L');
$pdf->SetX(200);
$pdf->Cell(0, 10, 'Fecha y hora: ' . $ficha['fecha'], 0, 1, 'L');

$pdf->Cell(0, 10, '', 0, 1, 'L');
$pdf->Cell(55, 10, 'Falla(s)', 1, 0, 'C'); 
$pdf->Cell(55, 10, 'Actividad', 1, 0, 'C'); 
$pdf->Cell(25, 10, 'Inicio', 1, 0, 'C');
$pdf->Cell(25, 10, 'Fin', 1, 0, 'C');
$pdf->Cell(40, 10, 'Responsable', 1, 0, 'C');
$pdf->Cell(55, 10, 'Resultados esperados', 1, 1, 'C');

$pdf->SetWidths(array(55,55,25,25,40,55)); // Definir los anchos de cada columna
$pdf->SetAligns(array('L','L','C','C','C','L'));

// Llenar la tabla con algunos datos
$pdf->Row(array(utf8_decode($Obs1),$inicio1,$fin1,utf8_decode($Responsable1),utf8_decode($Resultados1)));
$pdf->Row(array(utf8_decode($Obs2),$inicio2,$fin2,utf8_decode($Responsable2),utf8_decode($Resultados2)));

$pdf->Output('Reporte.pdf', 'F');

header('Content-type: application/pdf');
header('Content-Disposition: inline; filename="Reporte.pdf"');

readfile('Reporte.pdf');

?>