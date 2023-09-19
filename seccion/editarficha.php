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
}

p {
    font-family: Arial Rounded MT;
    font-size: 15px;
}

.tabla {
    background-color: oldlace;
}

textarea {
    width: 100%;

    box-sizing: border-box;
    font-family: Arial Rounded MT;
}
</style>
<br>
<?php
// Inicia la sesión (si aún no está iniciada)
session_start();
include_once '../databases/BD.php';
$conexionBD=BD::crearInstancia();

$id = $_GET['id'];
$sql = "SELECT * FROM datos WHERE id = :id";
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
        case 'Guardar':
            $id=$_POST['id'];
            $placa = $_POST['placa'];

            // Actualizar solo el campo placa en la base de datos
            $sql = "UPDATE datos SET placa =:placa WHERE id = $id";
            $consulta = $conexionBD->prepare($sql);
            $consulta->bindParam(':placa', $placa);
            $consulta->execute();
            
            // Recargar los datos actualizados desde la base de datos
            $sql = "SELECT * FROM datos WHERE id = :id";
            $consulta = $conexionBD->prepare($sql);
            $consulta->bindParam(':id', $id);
            $consulta->execute();
            $ficha = $consulta->fetch(PDO::FETCH_ASSOC);

            // Obtén el valor seleccionado de "Trek 753" desde el formulario
            $trek753 = $_POST['Trek'];
            // Guarda el valor en una variable de sesión
            $_SESSION['trek753'] = $trek753;

            echo "<h1>Cambios guardados correctamente</h1>";
            break;
        case 'Reporte':
            header('Location: fichas.php');
            break;
        default:
            break;
    }
}
?>
<h1></h1>
<div style="display: flex; justify-content: space-between;">
    <img src="/images/der.jpg" alt="Cara derecha del bus" width="350" height="250">
    <img src="/images/frente.jpg" alt="Frente del bus" width="450" height="250">
    <img src="/images/frenteiz.jpeg" alt="Cara izquierda del bus" width="450" height="250">
</div>

<div>
    <form action="" method="post">
        <table width='100%' bgcolor='oldlace' border='3'><br>
            <h1>Información vehículo</h1>
            <tr>
                <th>ID de bus:</th>
                <td><?php echo $ficha['id']?></td>
                <th>Placa:</th>
                <td><input type="text" name="placa" value="<?php echo $ficha['placa']?>"></td>
                <th>Empresa:</th>
                <td><input type="text" name="empresa" value="Autobuses"></td>
            </tr>
            <tr>
                <th>Nombre conductor:</th>
                <td><input type="text" name="Nombre" value="Pepito pable perez meza"></td>
                <th>Identificación</th>
                <td><input type="text" name="tipo_id" value="CC."></td>
                <td><input type="text" name="Identificacion" value="123456789"></td>
                <th>Fecha y hora</th>
                <td><?php echo $ficha['fecha']?></td>
        </table>
        <br>
        <div role="group">
            <h2 style="float: left">Estado: </h2>
            <select name="estado">
                <option value="Activo">Activo</option>
                <option value="Inactivo">Inactivo</option>
                <option value="En reparación">En reparación</option>
            </select>
        </div>
        <br>
        <h3>Unidad Lógica</h3>
        <div class="row">
            <div class="col-md-7">
                <table class='table' bgcolor='oldlace' width='100%' border='3'>
                    <tr>
                        <th>Trek 753:</th>
                        <td>
                            <select name="Trek">
                                <option value="Bien">Bien</option>
                                <option value="Regular">Regular</option>
                                <option value="Mal">Mal</option>
                                <option value="N/A">N/A</option>
                            </select>
                        </td>
                        <th>Antena GPS:</th>
                        <td>
                            <select name="GPS">
                                <option value="Bien">Bien</option>
                                <option value="Regular">Regular</option>
                                <option value="Mal">Mal</option>
                                <option value="N/A">N/A</option>
                            </select>
                        </td>
                        <th>Antena 3G:</th>
                        <td>
                            <select name="3G">
                                <option value="Bien">Bien</option>
                                <option value="Regular">Regular</option>
                                <option value="Mal">Mal</option>
                                <option value="N/A">N/A</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>Sim card:</th>
                        <td>
                            <select name="Sim">
                                <option value="Bien">Bien</option>
                                <option value="Regular">Regular</option>
                                <option value="Mal">Mal</option>
                                <option value="N/A">N/A</option>
                            </select>
                        </td>
                        <th>HDC (5m)</th>
                        <td>
                            <select name="HDC">
                                <option value="Bien">Bien</option>
                                <option value="Regular">Regular</option>
                                <option value="Mal">Mal</option>
                                <option value="N/A">N/A</option>
                            </select>
                        </td>
                        <th>Cable de poder</th>
                        <td>
                            <select name="Cable_poder">
                                <option value="Bien">Bien</option>
                                <option value="Regular">Regular</option>
                                <option value="Mal">Mal</option>
                                <option value="N/A">N/A</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>IOCOVER:</th>
                        <td>
                            <select name="IOCOVER">
                                <option value="Bien">Bien</option>
                                <option value="Regular">Regular</option>
                                <option value="Mal">Mal</option>
                                <option value="N/A">N/A</option>
                            </select>
                        </td>
                        <th>Tapa IOCOVER</th>
                        <td>
                            <select name="Tapa_IOCOVER">
                                <option value="Bien">Bien</option>
                                <option value="Regular">Regular</option>
                                <option value="Mal">Mal</option>
                                <option value="N/A">N/A</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>Cabezal Bipode</th>
                        <td>
                            <select name="Cabezal_Bipode">
                                <option value="Bien">Bien</option>
                                <option value="Regular">Regular</option>
                                <option value="Mal">Mal</option>
                                <option value="N/A">N/A</option>
                            </select>
                        </td>
                        <th>Bipode</th>
                        <td>
                            <select name="Bipode">
                                <option value="Bien">Bien</option>
                                <option value="Regular">Regular</option>
                                <option value="Mal">Mal</option>
                                <option value="N/A">N/A</option>
                            </select>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-md-5">
                <table class='table' width='100%' bgcolor='oldlace' border='3'>
                    <textarea name="obs" style="height: 170px;" placeholder="Observaciones:"></textarea>
                </table>
            </div>
        </div>
        <br>
        <h3>Pip</h3>
        <div class="row">
            <div class="col-md-7">
                <table class='table tabla' width='100%' bgcolor='oldlace' border='3'>
                    <tr>
                        <th>Display de información:</th>
                        <td>
                            <select name="Display">
                                <option value="Bien">Bien</option>
                                <option value="Regular">Regular</option>
                                <option value="Mal">Mal</option>
                                <option value="N/A">N/A</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>Extención del cable de poder:</th>
                        <td>
                            <select name="Extencion_poder">
                                <option value="Bien">Bien</option>
                                <option value="Regular">Regular</option>
                                <option value="Mal">Mal</option>
                                <option value="N/A">N/A</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>Extención del cable de datos:</th>
                        <td>
                            <select name="Extencion_datos">
                                <option value="Bien">Bien</option>
                                <option value="Regular">Regular</option>
                                <option value="Mal">Mal</option>
                                <option value="N/A">N/A</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>Soportes en L:</th>
                        <td>
                            <select name="Soportes_L">
                                <option value="Bien">Bien</option>
                                <option value="Regular">Regular</option>
                                <option value="Mal">Mal</option>
                                <option value="N/A">N/A</option>
                            </select>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-md-5">
                <table class='table' bgcolor='oldlace' border='3'>
                    <textarea name="obs" style="height: 170px;" placeholder="Observaciones:"></textarea>
                </table>
            </div>
        </div>
        <br>
        <h3>APC</h3>
        <div class="row">
            <div class="col-md-7">
                <table class='table' width='100%' bgcolor='oldlace' border='3'>
                    <tr>
                        <th>APC:</th>
                        <td>
                            <select name="APC">
                                <option value="Bien">Bien</option>
                                <option value="Regular">Regular</option>
                                <option value="Mal">Mal</option>
                                <option value="N/A">N/A</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>Soporte caja:</th>
                        <td>
                            <select name="Soporte_caja">
                                <option value="Bien">Bien</option>
                                <option value="Regular">Regular</option>
                                <option value="Mal">Mal</option>
                                <option value="N/A">N/A</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>cable de poder y datos:</th>
                        <td>
                            <select name="poder_datos">
                                <option value="Bien">Bien</option>
                                <option value="Regular">Regular</option>
                                <option value="Mal">Mal</option>
                                <option value="N/A">N/A</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>DC convertidor (12-24):</th>
                        <td>
                            <select name="DC_convertidor">
                                <option value="Bien">Bien</option>
                                <option value="Regular">Regular</option>
                                <option value="Mal">Mal</option>
                                <option value="N/A">N/A</option>
                            </select>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-md-5">
                <table class='table' bgcolor='oldlace' border='3'>
                    <textarea name="obs" style="height: 170px;" placeholder="Observaciones:"></textarea>
                </table>
            </div>
        </div>
        <br>
        <h3>Sensor pta 1</h3>
        <div class="row">
            <div class="col-md-7">
                <table class='table' width='100%' bgcolor='oldlace' border='3'>
                    <tr>
                        <th>Sensor puerta:</th>
                        <td>
                            <select name="Sensor_pta1">
                                <option value="Bien">Bien</option>
                                <option value="Regular">Regular</option>
                                <option value="Mal">Mal</option>
                                <option value="N/A">N/A</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>Extención del cable:</th>
                        <td>
                            <select name="Extencion_cable1">
                                <option value="Bien">Bien</option>
                                <option value="Regular">Regular</option>
                                <option value="Mal">Mal</option>
                                <option value="N/A">N/A</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>Soportes en angulo:</th>
                        <td>
                            <select name="Soportes_angulo1">
                                <option value="Bien">Bien</option>
                                <option value="Regular">Regular</option>
                                <option value="Mal">Mal</option>
                                <option value="N/A">N/A</option>
                            </select>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-md-5">
                <table class='table' bgcolor='oldlace' border='3'>
                    <textarea name="obs" style="height: 130px;" placeholder="Observaciones:"></textarea>
                </table>
            </div>
        </div>
        <br>
        <h3>Sensor pta 2</h3>
        <div class="row">
            <div class="col-md-7">
                <table class='table' width='100%' bgcolor='oldlace' border='3'>
                    <tr>
                        <th>Sensor puerta:</th>
                        <td>
                            <select name="Sensor_pta2">
                                <option value="Bien">Bien</option>
                                <option value="Regular">Regular</option>
                                <option value="Mal">Mal</option>
                                <option value="N/A">N/A</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>Extención del cable:</th>
                        <td>
                            <select name="Extencion_cable2">
                                <option value="Bien">Bien</option>
                                <option value="Regular">Regular</option>
                                <option value="Mal">Mal</option>
                                <option value="N/A">N/A</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>Soportes en angulo:</th>
                        <td>
                            <select name="Soportes_angulo2">
                                <option value="Bien">Bien</option>
                                <option value="Regular">Regular</option>
                                <option value="Mal">Mal</option>
                                <option value="N/A">N/A</option>
                            </select>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-md-5">
                <table class='table' bgcolor='oldlace' border='3'>
                    <textarea name="obs" style="height: 130px;" placeholder="Observaciones:"></textarea>
                </table>
            </div>
        </div>
        <br>
        <h3>Botón pánico</h3>
        <div class="row">
            <div class="col-md-7">
                <table class='table' width='100%' bgcolor='oldlace' border='3'>
                    <tr>
                        <th>Botón de pánico:</th>
                        <td>
                            <select name="panico">
                                <option value="Bien">Bien</option>
                                <option value="Regular">Regular</option>
                                <option value="Mal">Mal</option>
                                <option value="N/A">N/A</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>Extención:</th>
                        <td>
                            <select name="Extencion_panico">
                                <option value="Bien">Bien</option>
                                <option value="Regular">Regular</option>
                                <option value="Mal">Mal</option>
                                <option value="N/A">N/A</option>
                            </select>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-md-5">
                <table class='table' bgcolor='oldlace' border='3'>
                    <textarea name="obs" style="height: 87px;" placeholder="Observaciones:"></textarea>
                </table>
            </div>
        </div>
        <br>
        <h3>Sistema TRS</h3>
        <div class="row">
            <div class="col-md-7">
                <table class='table' width='100%' bgcolor='oldlace' border='3'>
                    <tr>
                        <th>Radio MDT 400:</th>
                        <td>
                            <select name="radio">
                                <option value="Bien">Bien</option>
                                <option value="Regular">Regular</option>
                                <option value="Mal">Mal</option>
                                <option value="N/A">N/A</option>
                            </select>
                        </td>
                        <th>Cable de poder:</th>
                        <td>
                            <select name="poder_radio">
                                <option value="Bien">Bien</option>
                                <option value="Regular">Regular</option>
                                <option value="Mal">Mal</option>
                                <option value="N/A">N/A</option>
                            </select>
                        </td>
                        <th>Cable PI:</th>
                        <td>
                            <select name="PI">
                                <option value="Bien">Bien</option>
                                <option value="Regular">Regular</option>
                                <option value="Mal">Mal</option>
                                <option value="N/A">N/A</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>MIC conductor</th>
                        <td>
                            <select name="mic">
                                <option value="Bien">Bien</option>
                                <option value="Regular">Regular</option>
                                <option value="Mal">Mal</option>
                                <option value="N/A">N/A</option>
                            </select>
                        </td>
                        <th>Soporte MIC conductor L</th>
                        <td>
                            <select name="mic_L">
                                <option value="Bien">Bien</option>
                                <option value="Regular">Regular</option>
                                <option value="Mal">Mal</option>
                                <option value="N/A">N/A</option>
                            </select>
                        </td>
                        <th>MIC ambiente</th>
                        <td>
                            <select name="mic_ambiente">
                                <option value="Bien">Bien</option>
                                <option value="Regular">Regular</option>
                                <option value="Mal">Mal</option>
                                <option value="N/A">N/A</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>Antena TRS</th>
                        <td>
                            <select name="TRS">
                                <option value="Bien">Bien</option>
                                <option value="Regular">Regular</option>
                                <option value="Mal">Mal</option>
                                <option value="N/A">N/A</option>
                            </select>
                        </td>
                        <th>Euro base:</th>
                        <td>
                            <select name="euro">
                                <option value="Bien">Bien</option>
                                <option value="Regular">Regular</option>
                                <option value="Mal">Mal</option>
                                <option value="N/A">N/A</option>
                            </select>
                        </td>
                        <th>Altavoz</th>
                        <td>
                            <select name="altavoz">
                                <option value="Bien">Bien</option>
                                <option value="Regular">Regular</option>
                                <option value="Mal">Mal</option>
                                <option value="N/A">N/A</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>Botón PTT</th>
                        <td>
                            <select name="PTT">
                                <option value="Bien">Bien</option>
                                <option value="Regular">Regular</option>
                                <option value="Mal">Mal</option>
                                <option value="N/A">N/A</option>
                            </select>
                        </td>
                        <th>Inversor Voltaje (24-12)</th>
                        <td>
                            <select name="inversor">
                                <option value="Bien">Bien</option>
                                <option value="Regular">Regular</option>
                                <option value="Mal">Mal</option>
                                <option value="N/A">N/A</option>
                            </select>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-md-5">
                <table class='table' bgcolor='oldlace' border='3'>
                    <textarea name="obs" style="height: 170px;" placeholder="Observaciones:"></textarea>
                </table>
            </div>
        </div>
        <br>
        <h3>Habitáculo</h3>
        <div class="row">
            <div class="col-md-7">
                <table class='table' width='100%' bgcolor='oldlace' border='3'>
                    <tr>
                        <th>Habitáculo:</th>
                        <td>
                            <select name="habitaculo">
                                <option value="Bien">Bien</option>
                                <option value="Regular">Regular</option>
                                <option value="Mal">Mal</option>
                                <option value="N/A">N/A</option>
                            </select>
                        </td>
                        <th>Power on amplificador:</th>
                        <td>
                            <select name="power_on">
                                <option value="Bien">Bien</option>
                                <option value="Regular">Regular</option>
                                <option value="Mal">Mal</option>
                                <option value="N/A">N/A</option>
                            </select>
                        </td>
                        <th>cable 2x1:</th>
                        <td>
                            <select name="cable_2x1">
                                <option value="Bien">Bien</option>
                                <option value="Regular">Regular</option>
                                <option value="Mal">Mal</option>
                                <option value="N/A">N/A</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>Amplificador:</th>
                        <td>
                            <select name="amplificador">
                                <option value="Bien">Bien</option>
                                <option value="Regular">Regular</option>
                                <option value="Mal">Mal</option>
                                <option value="N/A">N/A</option>
                            </select>
                        </td>
                        <th>Parlantes:</th>
                        <td>
                            <select name="parlantes">
                                <option value="Bien">Bien</option>
                                <option value="Regular">Regular</option>
                                <option value="Mal">Mal</option>
                                <option value="N/A">N/A</option>
                            </select>
                        </td>
                        <th>Rejillas:</th>
                        <td>
                            <select name="rejillas">
                                <option value="Bien">Bien</option>
                                <option value="Regular">Regular</option>
                                <option value="Mal">Mal</option>
                                <option value="N/A">N/A</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>PCB:</th>
                        <td>
                            <select name="pcb">
                                <option value="Bien">Bien</option>
                                <option value="Regular">Regular</option>
                                <option value="Mal">Mal</option>
                                <option value="N/A">N/A</option>
                            </select>
                        </td>
                        <th>Arnés:</th>
                        <td>
                            <select name="arnes">
                                <option value="Bien">Bien</option>
                                <option value="Regular">Regular</option>
                                <option value="Mal">Mal</option>
                                <option value="N/A">N/A</option>
                            </select>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-md-5">
                <table class='table' bgcolor='oldlace' border='3'>
                    <textarea name="obs" style="height: 128px;" placeholder="Observaciones:"></textarea>
                </table>
            </div>
        </div>
        <div class='buttons'>
            <input type="hidden" name="id" value="<?php echo $ficha['id'];?>">
            <div class="btn-group" role="group" aria-label="" style="float: right">
                <button type="submit" name="accion" value="Guardar" class="btn btn-success">Guardar</button>
                <button type="submit" name="accion" value="Reporte" class="btn btn-dark">Reporte</button>
                <button type="submit" name="accion" value="Volver" class="btn btn-secondary">Volver</button>
            </div>
        </div>
    </form>
</div>
<?php include("../templates/pie.php"); ?>
<br>