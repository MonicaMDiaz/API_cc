<?php
require('../../../librerias/fpdf.php');
require('../../../librerias/font/times.php');
//require('../librerias/mc_table.php');
include_once '../../../databases/BD.php';
$conexionBD=BD::crearInstancia();

$id = $_GET['id'];
$sql = "SELECT * FROM datos INNER JOIN inventario ON datos.id = inventario.id WHERE datos.id = :id";
//"SELECT datos.placa, datos.id,datos.Empresa,datos.Nombre, datos.fecha, inventario.Estado FROM datos INNER JOIN inventario ON datos.id = inventario.id WHERE inventario.Estado LIKE '%".$buscar_valor."%'";   
$consulta = $conexionBD->prepare($sql);
$consulta->bindParam(':id', $id);
$consulta->execute();
$ficha = $consulta->fetch(PDO::FETCH_ASSOC);

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
$pdf->Cell(0, 10, 'ID de bus: ' . $ficha['id'], 1, 0, 'L');
$pdf->SetX(60);
$pdf->Cell(0, 10, utf8_decode('Número de ficha: ' . $ficha['n']), 1, 0, 'L');
$pdf->SetX(120);
$pdf->Cell(0, 10, 'Empresa: ' . $ficha['Empresa'], 1, 0, 'L');
$pdf->SetX(180);
$pdf->Cell(0, 10, 'Placa: ' . $ficha['placa'], 1, 1, 'L');
$pdf->Cell(0, 10, utf8_decode('Nombre conductor: ' . $ficha['Nombre']), 1, 0, 'L');
$pdf->SetX(100);
$pdf->Cell(0, 10, utf8_decode('Identificación: ' . $ficha['nit'] . ' ' . $ficha['nid']), 1, 0, 'L');
$pdf->SetX(200);
$pdf->Cell(0, 10, 'Fecha y hora: ' . $ficha['fecha'], 1, 1, 'L');

$pdf->Cell(0, 10, '', 0, 1, 'L');
$pdf->Cell(80, 10, 'Actividad', 1, 0, 'C'); 
$pdf->Cell(30, 10, 'Inicio', 1, 0, 'C');
$pdf->Cell(30, 10, 'Fin', 1, 0, 'C');
$pdf->Cell(50, 10, 'Responsable', 1, 0, 'C');
$pdf->Cell(80, 10, 'Resultados esperados', 1, 1, 'C');

$pdf->SetWidths(array(80,30,30,50,80)); // Definir los anchos de cada columna
$pdf->SetAligns(array('L','C','C','C','L'));

$fields = ['Trek', 'GPS', '3G', 'Sim', 'HDC', 'Cable_poder', 'IOCOVER', 'Tapa_IOCOVER', 'Cabezal_Bipode', 'Bipode', //10
    'Display', 'Extencion_poder', 'Extencion_datos', 'Soportes_L', //4
    'APC', 'Soporte_caja', 'poder_datos', 'DC_convertidor', //4
    'Sensor_pta1', 'Extencion_cable1', 'Soportes_angulo1', 'Sensor_pta2', 'Extencion_cable2', 'Soportes_angulo2', //6
    'panico', 'Extencion_panico', //2
    'radio', 'poder_radio', 'PI', 'mic', 'mic_L', 'mic_ambiente', 'TRS', 'euro', 'altavoz', 'PTT', 'inversor', //11
    'habitaculo', 'power_on', 'cable_2x1', 'amplificador', 'parlantes', 'rejillas', 'pcb', 'arnes'
];

foreach ($fields as $field) {
    // Verifica si al menos una variable relacionada con esta columna está presente en $_POST
    if (isset($_POST['act' . $field]) || isset($_POST['inicio' . $field]) || isset($_POST['fin' . $field]) || isset($_POST['Responsable' . $field]) || isset($_POST['Resultados' . $field])) {
        $act1 = isset($_POST['act' . $field]) ? $_POST['act' . $field] : '';
        $inicio1 = isset($_POST['inicio' . $field]) ? $_POST['inicio' . $field] : '';
        $fin1 = isset($_POST['fin' . $field]) ? $_POST['fin' . $field] : '';
        $Responsable1 = isset($_POST['Responsable' . $field]) ? $_POST['Responsable' . $field] : '';
        $Resultados1 = isset($_POST['Resultados' . $field]) ? $_POST['Resultados' . $field] : '';

        $pdf->Row(array(utf8_decode($act1), $inicio1, $fin1, utf8_decode($Responsable1), utf8_decode($Resultados1)));
    }
}

$pdf->Cell(0, 10, '', 0, 1, 'L');
$pdf->Cell(300, 10, 'Observaciones', 0, 0, 'C'); 
$pdf->Cell(0, 10, '', 0, 1, 'L');

$pdf->SetWidths(array(270)); // Definir los anchos de cada columna
$pdf->SetAligns(array('L'));

for ($i = 1; $i <= 8; $i++) {
    // Verifica si al menos una variable relacionada con esta columna está presente en $_POST
    if (isset($_POST['Obs' . $i])) {
        $Obs1= isset($_POST['Obs'.$i]) ? $_POST['Obs'.$i]:'';

        $pdf->Row(array(utf8_decode($Obs1)));
    }
}

$pdf->Output('Reporte.pdf', 'F');

header('Content-type: application/pdf');
header('Content-Disposition: inline; filename="Reporte.pdf"');

readfile('Reporte.pdf');

?>