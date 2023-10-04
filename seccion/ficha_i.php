<?php include("../templates/cabecera.php"); ?>
<br>
<style>
body {
    background-color: orange;
}

h1 {
    color: white;
    text-align: center;
    font-family: Arial Rounded MT;
    font-weight: bold;
    font-size: 30px;
}

h2 {
    color: black;
    text-align: left;
    font-family: Arial Rounded MT;
    font-weight: bold;
    font-size: 20px;
}

h3 {
    color: white;
    text-align: left;
    font-family: Arial Rounded MT;
    font-weight: bold;
    font-size: 21px;
}

.buttons {
    justify-content: space-between;
    margin: 20px 2px;
}

p {
    font-family: Arial Rounded MT;
    font-size: 15px;
}
</style>
<br>
<?php
include_once '../databases/BD.php';
$conexionBD=BD::crearInstancia();

$id = $_GET['id'];
//$sql = "SELECT * FROM datos WHERE id = :id";
$sql = "SELECT * FROM datos INNER JOIN inventario ON datos.id = inventario.id WHERE datos.id = :id";
$consulta = $conexionBD->prepare($sql);
$consulta->bindParam(':id', $id);
$consulta->execute();
$ficha = $consulta->fetch(PDO::FETCH_ASSOC);

$accion=isset($_POST['accion'])?$_POST['accion']:'';

if($accion!=''){
    switch ($accion) {
        case 'Volver':
            header('Location: fichas.php');
            break;
        case 'Editar':
            header('Location: editarficha.php?id=' . $id);
            break;
        case 'Reporte':
            header('Location: Reporte_i.php?id='. $id);
            break;
        default:
            break;
    }
}
?>

<br>
<div style="display: flex; justify-content: space-between;">
    <img src="/images/der.jpg" alt="Cara derecha del bus" width="350" height="250">
    <img src="/images/frente.jpg" alt="Frente del bus" width="450" height="250">
    <img src="/images/frenteiz.jpeg" alt="Cara izuierda del bus" width="450" height="250">
</div>

<div class='table'>
    <table width='100%' bgcolor='oldlace' border='3'><br>
        <h1>Información vehículo</h1>
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
    <table class='table' width='100%' bgcolor='oldlace' border='3'><br>

        <h2>Estado: <?php echo $ficha['Estado']?></h2>
        <h3>Unidad Lógica</h3>
        <tr>
            <th>Trek 753:</th>
            <td><?php echo $ficha['Trek']?></td>
            <th>Antena GPS:</th>
            <td> <?php echo $ficha['GPS']?> </td>
            <th>Antena 3G:</th>
            <td><?php echo $ficha['3G']?></td>
            <th>Sim card:</th>
            <td> <?php echo $ficha['Sim']?> </td>
        </tr>
        <tr>
            <th>HDC (5m)</th>
            <td> <?php echo $ficha['HDC']?> </td>
            <th>Cable de poder</th>
            <td><?php echo $ficha['Cable_poder']?></td>
        </tr>
        <tr>
            <th>IOCOVER:</th>
            <td> <?php echo $ficha['IOCOVER']?> </td>
            <th>Tapa IOCOVER</th>
            <td> <?php echo $ficha['Tapa_IOCOVER']?> </td>
            <th>Cabezal Bipode</th>
            <td><?php echo $ficha['Cabezal_Bipode']?></td>
            <th>Bipode</th>
            <td><?php echo $ficha['Bipode']?></td>
        </tr>
    </table>
    <table class='table' width='100%' bgcolor='oldlace' border='3'><br>
        <h3>Pip</h3>
        <tr>
            <th>Display de información:</th>
            <td> <?php echo $ficha['Display']?> </td>
            <th>Extención del cable de poder:</th>
            <td> <?php echo $ficha['Extencion_poder']?> </td>
            <th>Extención del cable de datos:</th>
            <td><?php echo $ficha['Extencion_datos']?></td>
            <th>Soportes en L:</th>
            <td> <?php echo $ficha['Soportes_L']?> </td>
        </tr>
    </table>
    <table class='table' width='100%' bgcolor='oldlace' border='3'><br>
        <h3>APC</h3>
        <tr>
            <th>APC:</th>
            <td> <?php echo $ficha['APC']?> </td>
            <th>Soporte caja:</th>
            <td> <?php echo $ficha['Soporte_caja']?> </td>
            <th>cable de poder y datos:</th>
            <td><?php echo $ficha['poder_datos']?></td>
            <th>DC convertidor (12-24):</th>
            <td> <?php echo $ficha['DC_convertidor']?> </td>
        </tr>
    </table>
    <table class='table' width='100%' bgcolor='oldlace' border='3'><br>
        <h3>Sensor pta 1</h3>
        <tr>
            <th>Sensor puerta:</th>
            <td> <?php echo $ficha['Sensor_pta1']?> </td>
            <th>Extención del cable:</th>
            <td> <?php echo $ficha['Extencion_cable1']?> </td>
            <th>Soportes en angulo:</th>
            <td><?php echo $ficha['Soportes_angulo1']?></td>
        </tr>
    </table>
    <table class='table' width='100%' bgcolor='oldlace' border='3'><br>
        <h3>Sensor pta 2</h3>
        <tr>
            <th>Sensor puerta:</th>
            <td> <?php echo $ficha['Sensor_pta2']?> </td>
            <th>Extención del cable:</th>
            <td> <?php echo $ficha['Extencion_cable2']?> </td>
            <th>Soportes en angulo:</th>
            <td><?php echo $ficha['Soportes_angulo2']?></td>
        </tr>
    </table>
    <table class='table' width='100%' bgcolor='oldlace' border='3'><br>
        <h3>Botón pánico</h3>
        <tr>
            <th>Botón de pánico:</th>
            <td><?php echo $ficha['panico']?></td>
            <th> </th>
            <td> </td>
            <th> </th>
            <td> </td>
            <th> </th>
            <td> </td>
            <th> </th>
            <td> </td>
            <th>Extención:</th>
            <td><?php echo $ficha['Extencion_panico']?> </td>
            <th> </th>
            <td> </td>
            <th> </th>
            <td> </td>
            <th> </th>
            <td> </td>
            <th> </th>
            <td> </td>
        </tr>
    </table>
    <table class='table' width='100%' bgcolor='oldlace' border='3'><br>

        <h3>Sistema TRS</h3>
        <tr>
            <th>Radio MDT 400:</th>
            <td> <?php echo $ficha['radio']?> </td>
            <th>Cable de poder:</th>
            <td> <?php echo $ficha['poder_radio']?> </td>
            <th>Cable PI:</th>
            <td><?php echo $ficha['PI']?></td>
        </tr>
        <tr>
            <th>MIC conductor</th>
            <td> <?php echo $ficha['mic']?> </td>
            <th>Soporte MIC conductor L</th>
            <td> <?php echo $ficha['mic_L']?> </td>
            <th>MIC ambiente</th>
            <td> <?php echo $ficha['mic_ambiente']?> </td>
        </tr>
        <tr>
            <th>Antena TRS</th>
            <td><?php echo $ficha['TRS']?></td>
            <th>Euro base:</th>
            <td> <?php echo $ficha['euro']?> </td>
            <th>Altavoz</th>
            <td> <?php echo $ficha['altavoz']?> </td>
            <th>Botón PTT</th>
            <td><?php echo $ficha['PTT']?></td>
            <th>Inversor Voltaje (24-12)</th>
            <td><?php echo $ficha['inversor']?></td>
        </tr>
    </table>
    <table class='table' width='100%' bgcolor='oldlace' border='3'><br>
        <h3>Habitáculo</h3>
        <tr>
            <th>Habitáculo:</th>
            <td> <?php echo $ficha['habitaculo']?> </td>
            <th>Power on amplificador:</th>
            <td> <?php echo $ficha['power_on']?> </td>
            <th>cable 2x1:</th>
            <td><?php echo $ficha['cable_2x1']?></td>
            <th>Amplificador:</th>
            <td> <?php echo $ficha['amplificador']?> </td>
        </tr>
        <tr>
            <th>Parlantes:</th>
            <td> <?php echo $ficha['parlantes']?> </td>
            <th>Rejillas:</th>
            <td> <?php echo $ficha['rejillas']?> </td>
            <th>PCB:</th>
            <td><?php echo $ficha['pcb']?></td>
            <th>Arnés:</th>
            <td> <?php echo $ficha['arnes']?> </td>
        </tr>
    </table>
    <table width='100%' bgcolor='oldlace' border='3'><br>
        <th>Observaciones:</th>
        <tr></tr>
        <td><?php echo nl2br($ficha['observacion'])?></td>
        <tr></tr>
        <td><?php echo nl2br($ficha['observacion2'])?></td>
        <tr></tr>
        <td><?php echo nl2br($ficha['observacion3'])?></td>
        <tr></tr>
        <td><?php echo nl2br($ficha['observacion4'])?></td>
        <tr></tr>
        <td><?php echo nl2br($ficha['observacion5'])?></td>
        <tr></tr>
        <td><?php echo nl2br($ficha['observacion6'])?></td>
        <tr></tr>
        <td><?php echo nl2br($ficha['observacion7'])?></td>
        <tr></tr>
        <td><?php echo nl2br($ficha['observacion8'])?></td>
    </table>
</div>
<div class='buttons'>
    <form action="" method="post">
        <div class="btn-group" role="group" aria-label="" style="float: right">
            <button type="submit" name="accion" value="Editar" class="btn btn-danger">Editar</button>
            <button type="submit" name="accion" value="Reporte" class="btn btn-dark">Reporte</button>
            <button type="submit" name="accion" value="Volver" class="btn btn-secondary">Volver</button>
        </div>
    </form>
</div>
<?php include("../templates/pie.php"); ?>