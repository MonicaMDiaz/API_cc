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
<?php
function generateSelectOptions($name, $selectedOption, $options) {
    $index = array_search($selectedOption, $options);
    if($index !== false){
        unset($options[$index]);
    }

    echo '<select name="'.$name.'">';
    echo '<option value="'.$selectedOption.'">'.$selectedOption.'</option>';
    foreach($options as $option) {
        echo '<option value="'.$option.'">'.$option.'</option>';
    }
    echo '</select>';
}
?>
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

$opciones = array("Bien", "Regular", "Mal", "N/A");

$accion=isset($_POST['accion'])?$_POST['accion']:'';

if($accion!=''){
    switch ($accion) {
        case 'Volver':
            header('Location: fichas.php');
            break;
        case 'Guardar':
            $id=$_POST['id'];
            $placa = $_POST['placa'];
            $Estado = $_POST['Estado'];
            $fields = ['Trek', 'GPS','3G','Sim','HDC','Cable_poder','IOCOVER','Tapa_IOCOVER','Cabezal_Bipode','Bipode',
                        'Display','Extencion_poder','Extencion_datos','Soportes_L',
                        'APC','Soporte_caja','poder_datos','DC_convertidor',
                        'Sensor_pta1','Extencion_cable1','Soportes_angulo1','Sensor_pta2','Extencion_cable2','Soportes_angulo2',
                        'panico','Extencion_panico',
                        'radio','poder_radio','PI','mic','mic_L','mic_ambiente',
                        'habitaculo','power_on','cable_2x1','amplificador','parlantes','rejillas','pcb','arnes'];
            // Actualizar solo el campo placa en la base de datos
            $sql = "UPDATE datos SET placa =:placa WHERE id = $id";
            $consulta = $conexionBD->prepare($sql);
            $consulta->bindParam(':placa', $placa);
            $consulta->execute();
            // Actualizar el campo Estado en la tabla inventario
            $sql = "UPDATE inventario SET Estado ='$Estado' WHERE id = $id";
            $consulta = $conexionBD->prepare($sql);
            $consulta->execute();
            $sql = "UPDATE inventario SET ";
            foreach ($fields as $field) {
                if (!isset($_POST[$field])) {
                    die("Missing field: $field");
                }            
                $sql .= "$field = :$field, ";
            }
            $sql = rtrim($sql, ', ');           
            $sql .= " WHERE id = $id";
            $consulta = $conexionBD->prepare($sql);           
            foreach ($fields as $field) {
                $consulta->bindParam(":$field", $_POST[$field]);
            }          
            $consulta->execute();              
            // Recargar los datos actualizados desde la base de datos
            $sql = "SELECT * FROM datos INNER JOIN inventario ON datos.id = inventario.id WHERE datos.id = :id";
            $consulta = $conexionBD->prepare($sql);
            $consulta->bindParam(':id', $id);
            $consulta->execute();
            $ficha = $consulta->fetch(PDO::FETCH_ASSOC);

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
            </tr>
        </table>
        <br>
        <div role="group">
            <h2 style="float: left">Estado: </h2>
            <?php
            $estados = array("Activo", "Inactivo", "En reparación");
            $index = array_search($ficha['Estado'], $estados);
            if($index !== false){
                unset($estados[$index]);
            }
            ?>
            <select name="Estado">
                <option value="<?php echo $ficha['Estado']; ?>"><?php echo $ficha['Estado']; ?></option>
                <?php foreach($estados as $estado): ?>
                <option value="<?php echo $estado; ?>"><?php echo $estado; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <br>
        <h3>Unidad Lógica</h3>
        <div class="row">
            <div class="col-md-7">
                <table class='table' bgcolor='oldlace' width='100%' border='3'>
                    <tr>
                        <th>Trek 753:</th>
                        <td><?php generateSelectOptions('Trek', $ficha['Trek'], $opciones);?></td>
                        <th>Antena GPS:</th>
                        <td><?php generateSelectOptions('GPS', $ficha['GPS'], $opciones);?></td>
                        <th>Antena 3G:</th>
                        <td><?php generateSelectOptions('3G', $ficha['3G'], $opciones);?></td>
                    </tr>
                    <tr>
                        <th>Sim card:</th>
                        <td><?php generateSelectOptions('Sim', $ficha['Sim'], $opciones);?></td>
                        <th>HDC (5m)</th>
                        <td><?php generateSelectOptions('HDC', $ficha['HDC'], $opciones);?></td>
                        <th>Cable de poder</th>
                        <td><?php generateSelectOptions('Cable_poder', $ficha['Cable_poder'], $opciones);?></td>
                    </tr>
                    <tr>
                        <th>IOCOVER:</th>
                        <td> <?php generateSelectOptions('IOCOVER', $ficha['IOCOVER'], $opciones);?></td>
                        <th>Tapa IOCOVER</th>
                        <td> <?php generateSelectOptions('Tapa_IOCOVER', $ficha['Tapa_IOCOVER'], $opciones);?></td>
                    </tr>
                    <tr>
                        <th>Cabezal Bipode</th>
                        <td> <?php generateSelectOptions('Cabezal_Bipode', $ficha['Cabezal_Bipode'], $opciones);?></td>
                        <th>Bipode</th>
                        <td> <?php generateSelectOptions('Bipode', $ficha['Bipode'], $opciones);?></td>
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
                        <td> <?php generateSelectOptions('Display', $ficha['Display'], $opciones);?></td>
                    </tr>
                    <tr>
                        <th>Extención del cable de poder:</th>
                        <td> <?php generateSelectOptions('Extencion_poder', $ficha['Extencion_poder'], $opciones);?>
                        </td>
                    </tr>
                    <tr>
                        <th>Extención del cable de datos:</th>
                        <td> <?php generateSelectOptions('Extencion_datos', $ficha['Extencion_datos'], $opciones);?>
                        </td>
                    </tr>
                    <tr>
                        <th>Soportes en L:</th>
                        <td> <?php generateSelectOptions('Soportes_L', $ficha['Soportes_L'], $opciones);?></td>
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
                        <td> <?php generateSelectOptions('APC', $ficha['APC'], $opciones);?></td>
                    </tr>
                    <tr>
                        <th>Soporte caja:</th>
                        <td> <?php generateSelectOptions('Soporte_caja', $ficha['Soporte_caja'], $opciones);?></td>
                    </tr>
                    <tr>
                        <th>cable de poder y datos:</th>
                        <td> <?php generateSelectOptions('poder_datos', $ficha['poder_datos'], $opciones);?></td>
                    </tr>
                    <tr>
                        <th>DC convertidor (12-24):</th>
                        <td> <?php generateSelectOptions('DC_convertidor', $ficha['DC_convertidor'], $opciones);?></td>
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
                        <td> <?php generateSelectOptions('Sensor_pta1', $ficha['Sensor_pta1'], $opciones);?></td>
                        </td>
                    </tr>
                    <tr>
                        <th>Extención del cable:</th>
                        <td> <?php generateSelectOptions('Extencion_cable1', $ficha['Extencion_cable1'], $opciones);?>
                        </td>
                    </tr>
                    <tr>
                        <th>Soportes en angulo:</th>
                        <td> <?php generateSelectOptions('Soportes_angulo1', $ficha['Soportes_angulo1'], $opciones);?>
                        </td>
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
                        <td> <?php generateSelectOptions('Sensor_pta2', $ficha['Sensor_pta2'], $opciones);?></td>
                    </tr>
                    <tr>
                        <th>Extención del cable:</th>
                        <td> <?php generateSelectOptions('Extencion_cable2', $ficha['Extencion_cable2'], $opciones);?>
                        </td>
                    </tr>
                    <tr>
                        <th>Soportes en angulo:</th>
                        <td> <?php generateSelectOptions('Soportes_angulo2', $ficha['Soportes_angulo2'], $opciones);?>
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
                        <td> <?php generateSelectOptions('panico', $ficha['panico'], $opciones);?></td>
                    </tr>
                    <tr>
                        <th>Extención:</th>
                        <td> <?php generateSelectOptions('Extencion_panico', $ficha['Extencion_panico'], $opciones);?>
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
                        <td> <?php generateSelectOptions('radio', $ficha['radio'], $opciones);?></td>
                        <th>Cable de poder:</th>
                        <td> <?php generateSelectOptions('poder_radio', $ficha['poder_radio'], $opciones);?></td>
                        <th>Cable PI:</th>
                        <td> <?php generateSelectOptions('PI', $ficha['PI'], $opciones);?></td>
                    </tr>
                    <tr>
                        <th>MIC conductor</th>
                        <td> <?php generateSelectOptions('mic', $ficha['mic'], $opciones);?></td>
                        <th>Soporte MIC conductor L</th>
                        <td> <?php generateSelectOptions('mic_L', $ficha['mic_L'], $opciones);?></td>
                        <th>MIC ambiente</th>
                        <td> <?php generateSelectOptions('mic_ambiente', $ficha['mic_ambiente'], $opciones);?></td>
                    </tr>
                    <tr>
                        <th>Antena TRS</th>
                        <td> <?php generateSelectOptions('TRS', $ficha['TRS'], $opciones);?></td>
                        <th>Euro base:</th>
                        <td> <?php generateSelectOptions('euro', $ficha['euro'], $opciones);?></td>
                        <th>Altavoz</th>
                        <td> <?php generateSelectOptions('altavoz', $ficha['altavoz'], $opciones);?></td>
                    </tr>
                    <tr>
                        <th>Botón PTT</th>
                        <td> <?php generateSelectOptions('PTT', $ficha['PTT'], $opciones);?></td>
                        <th>Inversor Voltaje (24-12)</th>
                        <td> <?php generateSelectOptions('inversor', $ficha['inversor'], $opciones);?></td>
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
                        <td> <?php generateSelectOptions('habitaculo', $ficha['habitaculo'], $opciones);?></td>
                        <th>Power on amplificador:</th>
                        <td> <?php generateSelectOptions('power_on', $ficha['power_on'], $opciones);?></td>
                        <th>cable 2x1:</th>
                        <td> <?php generateSelectOptions('cable_2x1', $ficha['cable_2x1'], $opciones);?></td>
                    </tr>
                    <tr>
                        <th>Amplificador:</th>
                        <td> <?php generateSelectOptions('amplificador', $ficha['amplificador'], $opciones);?></td>
                        <th>Parlantes:</th>
                        <td> <?php generateSelectOptions('parlantes', $ficha['parlantes'], $opciones);?></td>
                        <th>Rejillas:</th>
                        <td> <?php generateSelectOptions('rejillas', $ficha['rejillas'], $opciones);?></td>
                    </tr>
                    <tr>
                        <th>PCB:</th>
                        <td> <?php generateSelectOptions('pcb', $ficha['pcb'], $opciones);?></td>
                        <th>Arnés:</th>
                        <td> <?php generateSelectOptions('arnes', $ficha['arnes'], $opciones);?></td>
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