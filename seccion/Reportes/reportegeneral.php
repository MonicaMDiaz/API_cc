<!DOCTYPE html>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<head>
    <title>Reporte</title>
    <link rel="stylesheet" type="text/css" href="estilos.css">
    </link>
</head>

</html>
<?php include("../../templates/cabecera.php"); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    function deshabilitarEnlace(event) {
        event.preventDefault();
    }
    document.getElementById('linkReportes').addEventListener('click', deshabilitarEnlace);
});
</script>

<br>
<style>
body {
    background-color: white;
}

h1 {
    color: black;
    text-align: center;
    font-family: Arial Rounded MT;
    font-weight: bold;
    font-size: 30px;
}

.table1 {
    border: 3px solid black;
    border-collapse: collapse;
    text-align: center;
}

.table2 {
    border-bottom: 1px solid #4DCB45;
    border-collapse: collapse;
    text-align: center;
}

.th-title {
    border: 3px solid #ea5d2d;
    border-collapse: collapse;
    text-align: center;
    background-color: #ea5d2d;
    font-size: 20px;
    font-family: Arial Rounded MT;
}
</style>
<br>
<?php
//|SELECT * FROM datos
include_once '../../databases/BD.php';
$conexionBD=BD::crearInstancia();
$consulta=$conexionBD->prepare("SELECT * FROM datos");
$consulta->execute();
$result= $consulta->fetchALL();

$id=isset($_POST['id'])?$_POST['id']:'';
$placa=isset($_POST['placa'])?$_POST['placa']:'';

$accion=isset($_POST['accion'])?$_POST['accion']:'';

if($accion!=''){
    switch ($accion) {
        case 'Ver':
            //header('Location: ficha_i.php');
            header('Location: ../Fichas/fichas_bus.php?id=' . $id);
            break;
    }
}

$columnas = ['Trek', 'GPS','3G','Sim','HDC','Cable_poder','IOCOVER','Tapa_IOCOVER','Cabezal_Bipode','Bipode',  
            'Display','Extencion_poder','Extencion_datos','Soportes_L',
            'APC','Soporte_caja','poder_datos','DC_convertidor',
            'Sensor_pta1','Extencion_cable1','Soportes_angulo1','Sensor_pta2','Extencion_cable2','Soportes_angulo2',
            'panico','Extencion_panico',
            'radio','poder_radio','PI','mic','mic_L','mic_ambiente', 'TRS','euro','altavoz','PTT','inversor',
            'habitaculo','power_on','cable_2x1','amplificador','parlantes','rejillas','pcb','arnes'];

$obs= ['observacion1','observacion2','observacion3','observacion4','observacion5','observacion6','observacion7','observacion8'];
// Crea una función que genera la consulta SQL
function generar_sql($columnas) {
  $sql = "SELECT id, ";
  foreach ($columnas as $col) {
    $sql .= "(CASE WHEN $col = 'Bien' THEN 0 ELSE 1 END) + ";
  }
  $sql = rtrim($sql, "+ ");
  $sql .= "AS MalCount ";
  $sql .= "FROM inventario ";
  $sql .= "WHERE id = :id";
  return $sql;
}

function sql_obs($obs){
    $sql = "SELECT id, ";
  foreach ($obs as $obser) {
    $sql .= "(CASE WHEN $obser = '' THEN 0 ELSE 1 END) + ";
  }
  $sql = rtrim($sql, "+ ");
  $sql .= "AS obsCount ";
  $sql .= "FROM inventario ";
  $sql .= "WHERE id = :id";
  return $sql;
}

function compararPorMal($a, $b) {
    if ($a['sumaf'] == $b['sumaf']) {
        return 0;
    }
    return ($a['sumaf'] > $b['sumaf']) ? -1 : 1;
}

?>
<H1></H1>
<table class='table1' style="width:100%; border: 3px solid #4DCB45;">
    <tr>
        <th colspan="7" class='th-title'>Autobuses</th>
    </tr>
    <tr>
        <th class='table2'>ID</th>
        <th class='table2'>Placa</th>
        <th class='table2'>Nombre de conductor</th>
        <th class='table2'>Ultima actualización</th>
        <th class='table2'>N° de fallas</th>
        <th class='table2'>N° de observaciones</th>
        <th class='table2' style="text-align: center;">Acción</th>
    </tr>
    <?php $datosOrdenadosA = [];
    foreach($result as $ficha){
        if(($ficha["Empresa"])=="Autobuses"){
            $id = $ficha['id'];
            $datosOrdenadosA[] = [
                'id' => $ficha['id'],
                'placa' => $ficha['placa'],
                'Nombre' => $ficha['Nombre'],
                'fecha' => $ficha['fecha'],
                'sumaf' => $ficha['sumaf'],
                'sumaob' => $ficha['sumaob'],
            ];
        }}
    usort($datosOrdenadosA, 'compararPorMal');
    foreach ($datosOrdenadosA as $ficha) {
        if($ficha['sumaf'] != 0 || $ficha['sumaob'] != 0){?>
    <tr>
        <td> <?php echo $ficha['id']; ?> </td>
        <td> <?php echo $ficha["placa"]; ?> </td>
        <td> <?php echo $ficha["Nombre"]; ?> </td>
        <td> <?php echo $ficha["fecha"]; ?> </td>
        <td> <?php echo $ficha['sumaf']; ?> </td>
        <td> <?php echo $ficha['sumaob']; ?> </td>
        <td style="text-align: center;">
            <form action="" method="post">
                <input type="hidden" name="id" value="<?php echo $ficha['id']; ?>">
                <div class="btn-group" role="group" aria-label="">
                    <button type="submit" name="accion" value="Ver" class="btn btn-dark">Ver</button>
                </div>
            </form>
        </td>
    </tr>
    <?php }}?>
</table>
<H1></H1>
<H1></H1>
<H1></H1>
<table class='table1' style="width:100%; border: 3px solid #4DCB45;">
    <tr>
        <th colspan="7" class='th-title'>Cootranur</th>
    </tr>
    <tr>
        <th class='table2'>ID</th>
        <th class='table2'>Placa</th>
        <th class='table2'>Nombre de conductor</th>
        <th class='table2'>Ultima actualización</th>
        <th class='table2'>N° de fallas</th>
        <th class='table2'>N° de observaciones</th>
        <th class='table2' style="text-align: center;">Acción</th>
    </tr>
    <?php $datosOrdenadosC = [];
    foreach($result as $ficha){
        if(($ficha["Empresa"])=="Cootranur"){
            $id = $ficha['id'];
            $datosOrdenadosC[] = [
                'id' => $ficha['id'],
                'placa' => $ficha['placa'],
                'Nombre' => $ficha['Nombre'],
                'fecha' => $ficha['fecha'],
                'sumaf' => $ficha['sumaf'],
                'sumaob' => $ficha['sumaob'],
            ];
    }}         
    usort($datosOrdenadosC, 'compararPorMal');
    foreach ($datosOrdenadosC as $ficha) {
        if($ficha['sumaf'] != 0 || $ficha['sumaob'] != 0){?>
    <tr>
        <td> <?php echo $ficha['id']; ?> </td>
        <td> <?php echo $ficha["placa"]; ?> </td>
        <td> <?php echo $ficha["Nombre"]; ?> </td>
        <td> <?php echo $ficha["fecha"]; ?> </td>
        <td> <?php echo $ficha['sumaf']; ?> </td>
        <td> <?php echo $ficha['sumaob']; ?> </td>
        <td style="text-align: center;">
            <form action="" method="post">
                <input type="hidden" name="id" value="<?php echo $ficha['id']; ?>">
                <div class="btn-group" role="group" aria-label="">
                    <button type="submit" name="accion" value="Ver" class="btn btn-dark">Ver</button>
                </div>
            </form>
        </td>
    </tr> <?php }}?>
</table>
<H1></H1>
<H1></H1>
<H1></H1>
<table class='table1' style="width:100%; border: 3px solid #4DCB45;">
    <tr>
        <th colspan="7" class='th-title'>Americana</th>
    </tr>
    <tr>
        <th class='table2'>ID</th>
        <th class='table2'>Placa</th>
        <th class='table2'>Nombre de conductor</th>
        <th class='table2'>Ultima actualización</th>
        <th class='table2'>N° de fallas</th>
        <th class='table2'>N° de observaciones</th>
        <th class='table2' style="text-align: center;">Acción</th>
    </tr>
    <?php $datosOrdenadosC = [];
    foreach($result as $ficha){
        if(($ficha["Empresa"])=="Americana"){
            $id = $ficha['id'];
            $datosOrdenadosC[] = [
                'id' => $ficha['id'],
                'placa' => $ficha['placa'],
                'Nombre' => $ficha['Nombre'],
                'fecha' => $ficha['fecha'],
                'sumaf' => $ficha['sumaf'],
                'sumaob' => $ficha['sumaob'],
            ];
    }}         
    usort($datosOrdenadosC, 'compararPorMal');
    foreach ($datosOrdenadosC as $ficha) {
        if($ficha['sumaf'] != 0 || $ficha['sumaob'] != 0){?>
    <tr>
        <td> <?php echo $ficha['id']; ?> </td>
        <td> <?php echo $ficha["placa"]; ?> </td>
        <td> <?php echo $ficha["Nombre"]; ?> </td>
        <td> <?php echo $ficha["fecha"]; ?> </td>
        <td> <?php echo $ficha['sumaf']; ?> </td>
        <td> <?php echo $ficha['sumaob']; ?> </td>
        <td style="text-align: center;">
            <form action="" method="post">
                <input type="hidden" name="id" value="<?php echo $ficha['id']; ?>">
                <div class="btn-group" role="group" aria-label="">
                    <button type="submit" name="accion" value="Ver" class="btn btn-dark">Ver</button>
                </div>
            </form>
        </td>
    </tr> <?php }}?>
</table>
<h1></h1>
<h1></h1>
<h1></h1>
<table class='table1' style="width:100%; border: 3px solid #4DCB45;">
    <tr>
        <th colspan="7" class='th-title'>Tesa</th>
    </tr>
    <tr>
        <th class='table2'>ID</th>
        <th class='table2'>Placa</th>
        <th class='table2'>Nombre de conductor</th>
        <th class='table2'>Ultima actualización</th>
        <th class='table2'>N° de fallas</th>
        <th class='table2'>N° de observaciones</th>
        <th class='table2' style="text-align: center;">Acción</th>
    </tr>
    <?php $datosOrdenadosC = [];
    foreach($result as $ficha){
        if(($ficha["Empresa"])=="Tesa"){
            $id = $ficha['id'];
            $datosOrdenadosC[] = [
                'id' => $ficha['id'],
                'placa' => $ficha['placa'],
                'Nombre' => $ficha['Nombre'],
                'fecha' => $ficha['fecha'],
                'sumaf' => $ficha['sumaf'],
                'sumaob' => $ficha['sumaob'],
            ];
    }}         
    usort($datosOrdenadosC, 'compararPorMal');
    foreach ($datosOrdenadosC as $ficha) {
        if($ficha['sumaf'] != 0 || $ficha['sumaob'] != 0){?>
    <tr>
        <td> <?php echo $ficha['id']; ?> </td>
        <td> <?php echo $ficha["placa"]; ?> </td>
        <td> <?php echo $ficha["Nombre"]; ?> </td>
        <td> <?php echo $ficha["fecha"]; ?> </td>
        <td> <?php echo $ficha['sumaf']; ?> </td>
        <td> <?php echo $ficha['sumaob']; ?> </td>
        <td style="text-align: center;">
            <form action="" method="post">
                <input type="hidden" name="id" value="<?php echo $ficha['id']; ?>">
                <div class="btn-group" role="group" aria-label="">
                    <button type="submit" name="accion" value="Ver" class="btn btn-dark">Ver</button>
                </div>
            </form>
        </td>
    </tr> <?php }}?>
</table>
<?php include("../../templates/pie.php"); ?>