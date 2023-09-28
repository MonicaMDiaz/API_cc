<?php include("../templates/cabecera.php"); ?>
<br>
<style>
body {
    background-color: oldlace;
}

h1 {
    color: black;
    text-align: center;
    font-family: Arial Rounded MT;
    font-weight: bold;
    font-size: 30px;
}
</style>
<?php
function verificarCampo($campo, $ficha) {
    if ($ficha[$campo]=='Mal'){ ?>
<th><?php echo $campo; ?>:</th>
<td>Arreglar</td>
<?php }
    elseif($ficha[$campo]=='Regular'){?>
<th><?php echo $campo; ?>:</th>
<td>Verificar</td>
<?php } 
    elseif($ficha[$campo]=='N/A'){?>
<th><?php echo $campo; ?>:</th>
<td>Poner</td>
<?php } 
  }
  
include_once '../databases/BD.php';
$conexionBD=BD::crearInstancia();

$id = $_GET['id'];
//$sql = "SELECT * FROM datos WHERE id = :id";
$sql = "SELECT * FROM datos INNER JOIN inventario ON datos.id = inventario.id WHERE datos.id = :id";
$consulta = $conexionBD->prepare($sql);
$consulta->bindParam(':id', $id);
$consulta->execute();
$ficha = $consulta->fetch(PDO::FETCH_ASSOC);
$fields = ['Trek', 'GPS','3G','Sim','HDC','Cable_poder','IOCOVER','Tapa_IOCOVER','Cabezal_Bipode','Bipode',
            'Display','Extencion_poder','Extencion_datos','Soportes_L',
            'APC','Soporte_caja','poder_datos','DC_convertidor',
            'Sensor_pta1','Extencion_cable1','Soportes_angulo1','Sensor_pta2','Extencion_cable2','Soportes_angulo2',
            'panico','Extencion_panico',
            'radio','poder_radio','PI','mic','mic_L','mic_ambiente',
            'habitaculo','power_on','cable_2x1','amplificador','parlantes','rejillas','pcb','arnes'];

$accion=isset($_POST['accion'])?$_POST['accion']:'';

if($accion!=''){
    switch ($accion) {
        case 'Volver':
            header('Location: fichas.php');
            break;
        case 'Editar':
            header('Location: editarficha.php?id=' . $id);
            break;
        case 'Imprimir':
            header('Location: Reporte_i.php?id='. $id);
            break;
        default:
            break;
    }
}
?>
<br>
<h1>Plan de acción</h1>
<div class='table'>
    <table width='100%' bgcolor='white' border='3'>
        <tr>
            <th>ID de bus:</th>
            <td> <?php echo $ficha['id']?> </td>
            <th>Empresa:</th>
            <td><?php echo $ficha['Empresa']?></td>
            <th>Placa:</th>
            <td> <?php echo $ficha["placa"]?> </td>
        </tr>
        <tr>
            <th>Nombre conductor:</th>
            <td><?php echo $ficha['Nombre']?></td>
            <th>Identificación</th>
            <td><?php echo $ficha['nit']?> <?php echo $ficha['nid']?> </td>
            <th>Fecha y hora</th>
            <td> <?php echo $ficha["fecha"]?> </td>
        </tr>
    </table>
    <table width='100%' bgcolor='white' border='3'><br>
        <tr>
            <?php verificarCampo('Trek', $ficha);?>


            <th>Sim card:</th>
            <td> <?php echo $ficha['Sim']?> </td>
        </tr>
        <tr><?php verificarCampo('Sim', $ficha);?></tr>
    </table>

</div>
<div class='button'>
    <form action='fichas.php' method='post'>
        <input type='submit' value='Volver' class='btn btn-secondary'>
    </form>
</div>

<?php include("../templates/pie.php"); ?>