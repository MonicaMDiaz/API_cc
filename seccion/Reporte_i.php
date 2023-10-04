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

.table1 {
    border: 3px solid black;
    border-collapse: collapse;
    text-align: center;
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
            header('Location: ficha_i.php?id=' . $id);
            break;
        case 'Imprimir':
            header('Location: imprimir.php?id='. $id);
            break;
        default:
            break;
    }
}
?>
<br>
<h1> </h1>
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
</div>
<br>
<h2></h2>
<h1>Plan de acción</h1>
<table class='table1' style="width:100%" border="3">
    <tr>
        <th rowspan="2" class='table1'>Actividad</th>
        <th colspan="2">Tiempo</th>
        <th rowspan="2" class='table1'>Responsable</th>
        <th rowspan="2" class='table1'>Resultados esperados</th>
    </tr>
    <tr>
        <td class='table1'>Inicio</td>
        <td class='table1'>Final</td>
    </tr>
    <tr>
        <td class='table1' contenteditable="true"> <?php echo nl2br($ficha["observacion"])?> </td>
        <td class='table1'><input type="date" name="inicio"></td>
        <td class='table1'><input type="date"></td>
        <td class='table1'><span contenteditable="true"> Mónica Diaz</span></td>
        <td class='table1' contenteditable="true"> Se espera que xxxx xxxx xxx </td>
    </tr>
</table>
<div class='buttons'>
    <form action="" method="post">
        <div class="btn-group" role="group" aria-label="" style="float: right">
            <button type="submit" name="accion" value="Volver" class="btn btn-secundary">Volver</button>
            <button type="submit" name="accion" value="Imprimir" class="btn btn-secundary">Imprimir</button>
        </div>
    </form>
</div>
<form method="post" action="imprimir.php">

    <table class='table1' style="width:100%" border="3">
        <tr>
            <th rowspan="2" class='table1'>Actividad</th>
            <th colspan="2">Tiempo</th>
            <th rowspan="2" class='table1'>Responsable</th>
            <th rowspan="2" class='table1'>Resultados esperados</th>
        </tr>
        <tr>
            <td class='table1'>Inicio</td>
            <td class='table1'>Final</td>
        </tr>
        <tr>
            <td class='table1' contenteditable="true"> <?php echo nl2br($ficha["observacion"])?> </td>
            <td class='table1'>
                <input type="date" name="inicio">
            </td>
            <td class='table1'>
                <input type="date" name="fin">
            </td>
            <td class='table1'><span contenteditable="true"> Mónica Diaz</span></td>
            <td class='table1' contenteditable="true"> Se espera que xxxx xxxx xxx </td>
        </tr>
    </table>
    <div class='buttons'>
        <form action="imprimir.php" method="post" style="display: inline;">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <button type="submit" name="accion" value="Imprimir" class="btn btn-secondary">Imprimir</button>
        </form>
        <form action="ficha_i.php" method="get" style="display: inline;">
            <button type="submit" name="accion" value="Volver" class="btn btn-secondary">Volver</button>
        </form>
    </div>


    <?php include("../templates/pie.php"); ?>