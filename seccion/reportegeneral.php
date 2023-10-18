<!DOCTYPE html>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<head>
    <title>Reporte</title>
    <link rel="stylesheet" type="text/css" href="estilos.css">
    </link>
</head>

</html>
<?php include("../templates/cabecera.php"); ?>
<br>
<style>
body {
    background-color: orange;
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
    border-bottom: 1px solid black;
    border-collapse: collapse;
    text-align: center;
}

.th-title {
    border: 3px solid black;
    border-collapse: collapse;
    text-align: center;
    background-color: red;
    font-size: 20px;
    font-family: Arial Rounded MT;
}

.buttons {
    justify-content: space-between;
    margin: 20px 2px;
}

.btn-black {
    background-color: black;
    color: white;
    border-color: black;
}

.btn-white {
    background-color: orange;
    color: black;
    border-color: black;
}
</style>
<br>
<?php
//INSERT INTO `datos` (`id`, `placa`, `fecha`) VALUES ('', NULL, current_timestamp()) |SELECT * FROM datos
include_once '../databases/BD.php';
$conexionBD=BD::crearInstancia();
$consulta=$conexionBD->prepare("SELECT * FROM datos INNER JOIN inventario ON datos.id = inventario.id");
$consulta->execute();
$result= $consulta->fetchALL();

$id=isset($_POST['id'])?$_POST['id']:'';
$placa=isset($_POST['placa'])?$_POST['placa']:'';

$accion=isset($_POST['accion'])?$_POST['accion']:'';

if($accion!=''){
    switch ($accion) {
        case 'Ver':
            //header('Location: ficha_i.php');
            header('Location: ficha_i.php?id=' . $id);
            break;
    }
}

// Supongamos que $datos es tu array de resultados
$columnas = ['Trek', 'GPS','3G','Sim','HDC','Cable_poder','IOCOVER','Tapa_IOCOVER','Cabezal_Bipode','Bipode',  
            'Display','Extencion_poder','Extencion_datos','Soportes_L',
            'APC','Soporte_caja','poder_datos','DC_convertidor',
            'Sensor_pta1','Extencion_cable1','Soportes_angulo1','Sensor_pta2','Extencion_cable2','Soportes_angulo2',
            'panico','Extencion_panico',
            'radio','poder_radio','PI','mic','mic_L','mic_ambiente', 'TRS','euro','altavoz','PTT','inversor',
            'habitaculo','power_on','cable_2x1','amplificador','parlantes','rejillas','pcb','arnes'];
// Crear un arreglo para contar los "mal" en cada fila.

// Crea una función que genera la consulta SQL
function generar_sql($columnas) {

  $sql = "SELECT id, ";
  foreach ($columnas as $col) {
    $sql .= "(CASE WHEN $col = 'Bien' THEN 0 ELSE 1 END) + ";
  }
  // $sql .= "(CASE WHEN $col = 'mal' THEN 1 ELSE 0 END) + ";
  $sql = rtrim($sql, "+ ");
  $sql .= "AS MalCount ";
  $sql .= "FROM inventario ";
  $sql .= "WHERE id = :id";
  return $sql;
}

?>
<H1></H1>

<table class='table1' style="width:100%" border="3" bgcolor='oldlace'>
    <tr>
        <th colspan="7" class='th-title'>Autobuses</th>
    </tr>
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
    <?php 
    foreach($result as $ficha){
        if(($ficha["Empresa"])=="Autobuses"){
            $id = $ficha['id'];
        // Llama a la función para generar la consulta SQL con el arreglo de columnas
            $consulta = generar_sql($columnas);
            // Prepara la consulta con el parámetro id
            $stmt = $conexionBD->prepare($consulta);
            $stmt->bindParam(':id', $id);
            // Ejecuta la consulta
            $stmt->execute();
            // Obtiene el resultado como un array asociativo
            $resultado= $stmt->fetch(PDO::FETCH_ASSOC);
            // Obtiene el número de valores "mal" para la ficha actual
            $malcount = $resultado['MalCount'];?>
    <tr>
        <td> <?php echo $ficha['id']?> </td>
        <td> <?php echo $ficha["placa"]?> </td>
        <td> <?php echo $ficha["Nombre"]?> </td>
        <td> <?php echo $ficha["fecha"]?> </td>
        <td> <?php echo $malcount?> </td>
        <td> <?php echo $malcount?> </td>
        <td style="text-align: center;">
            <form action="" method="post">
                <input type="hidden" name="id" value="<?php echo $ficha['id'];?>">
                <div class="btn-group" role="group" aria-label="">
                    <button type="submit" name="accion" value="Ver" class="btn btn-dark">Ver</button>
                </div>
            </form>
        </td>
    </tr> <?php }}  ?>
</table>
<H1></H1>
<H1></H1>
<H1></H1>

<table class='table1' style="width:100%" border="3" bgcolor='oldlace'>
    <tr>
        <th colspan="7" class='th-title'>
            Cootranur</th>
    </tr>
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
    <?php 
    foreach($result as $ficha){
        if(($ficha["Empresa"])=="Cootranur"){
            $id = $ficha['id'];
        // Llama a la función para generar la consulta SQL con el arreglo de columnas
        $consulta = generar_sql($columnas);
        // Prepara la consulta con el parámetro id
        $stmt = $conexionBD->prepare($consulta);
        $stmt->bindParam(':id', $id);
        // Ejecuta la consulta
        $stmt->execute();
        // Obtiene el resultado como un array asociativo
        $resultado= $stmt->fetch(PDO::FETCH_ASSOC);
        // Obtiene el número de valores "mal" para la ficha actual
        $malcount = $resultado['MalCount'];?>
    <tr>
        <td> <?php echo $ficha['id']?> </td>
        <td> <?php echo $ficha["placa"]?> </td>
        <td> <?php echo $ficha["Nombre"]?> </td>
        <td> <?php echo $ficha["fecha"]?> </td>
        <td> <?php echo $malcount?> </td>
        <td> <?php echo $malcount?> </td>
        <td style="text-align: center;">
            <form action="" method="post">
                <input type="hidden" name="id" value="<?php echo $ficha['id'];?>">
                <div class="btn-group" role="group" aria-label="">
                    <button type="submit" name="accion" value="Ver" class="btn btn-dark">Ver</button>
                </div>
            </form>
        </td>
    </tr> <?php }}  ?>
</table>

<?php include("../templates/pie.php"); ?>