<?php include("../../../templates/cabecera_scu.php"); ?>
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
</style>
<?php
include_once '../../../databases/BD.php';

$conexionBD=BD::crearInstancia();
$n = $_GET['n'];
$sql = "SELECT * FROM inventario WHERE n = :n";
$consulta = $conexionBD->prepare($sql);
$consulta->bindParam(':n', $n);
$consulta->execute();
$ficha = $consulta->fetch(PDO::FETCH_ASSOC);

$id = $ficha['id'];
$sqld = "SELECT * FROM datos WHERE id = :id";
$consultad = $conexionBD->prepare($sqld);
$consultad->bindParam(':id', $id);
$consultad->execute();
$dato = $consultad->fetch(PDO::FETCH_ASSOC);

$fields = ['Trek', 'GPS','3G','Sim','HDC','Cable_poder','IOCOVER','Tapa_IOCOVER','Cabezal_Bipode','Bipode',          //10
            'Display','Extencion_poder','Extencion_datos','Soportes_L',                                              //4
            'APC','Soporte_caja','poder_datos','DC_convertidor',                                                     //4
            'Sensor_pta1','Extencion_cable1','Soportes_angulo1','Sensor_pta2','Extencion_cable2','Soportes_angulo2', //6
            'panico','Extencion_panico',                                                                             //2
            'radio','poder_radio','PI','mic','mic_L','mic_ambiente', 'TRS','euro','altavoz','PTT','inversor',        //11
            'habitaculo','power_on','cable_2x1','amplificador','parlantes','rejillas','pcb','arnes']; 
function generar_sql($columnas) {
    $sql = "SELECT n, ";
    foreach ($columnas as $col) {
        $sql .= "(CASE WHEN $col = 'Bien' THEN 0 ELSE 1 END) + ";
    }
    // $sql .= "(CASE WHEN $col = 'mal' THEN 1 ELSE 0 END) + ";
    $sql = rtrim($sql, "+ ");
    $sql .= "AS MalCount ";
    $sql .= "FROM inventario ";
    $sql .= "WHERE n = :n";
    return $sql;
}

$accion=isset($_POST['accion'])?$_POST['accion']:'';

if($accion!=''){
    switch ($accion) {
        case 'volver':
            header('Location: ../ficha_i.php?n=' . $n);
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
            <td> <?php echo $dato['id']?> </td>
            <th># de ficha:</th>
            <td> <?php echo $ficha['n_ficha']?> </td>
            <th>Empresa:</th>
            <td><?php echo $dato['Empresa']?></td>
            <th>Placa:</th>
            <td> <?php echo $dato["placa"]?> </td>
        </tr>
        <tr>
            <th>Nombre conductor:</th>
            <td><?php echo $dato['Nombre']?></td>
            <th>Identificación</th>
            <td><?php echo $dato['nit']?> <?php echo $dato['nid']?> </td>
            <th>Estado:</th>
            <td><?php echo $dato['Estado']?> </td>
            <th>Fecha y hora</th>
            <td> <?php echo $dato["fecha"]?> </td>
        </tr>
    </table>
</div>
<br>
<h2></h2>
<h1>Plan de acción</h1>
<form method="post" action="imprimir.php?id=<?php echo $id; ?>">
    <table class='table1' style="width:100%" border="3">
        <tr>
            <th rowspan="2" class='table1'>Falla</th>
            <th rowspan="2" class='table1'>Actividad</th>
            <th colspan="2">Tiempo</th>
            <th rowspan="2" class='table1'>Responsable(s)</th>
            <th rowspan="2" class='table1'>Resultados esperados</th>
        </tr>
        <tr>
            <td class='table1'>Inicio</td>
            <td class='table1'>Final</td>
        </tr>
        <?php
        foreach ($fields as $field) {
            // Obtener el valor correspondiente desde la base de datos
            $valor = $ficha[$field];

            // Verificar si el valor es "Regular", "Mal" o "N/A"
            if ($valor == "Regular" || $valor == "Mal" || $valor == "N/A") {
                // Mostrar en una fila diferente según la categoría
                echo "<tr>";
                echo "<td class='table1'>$field:$valor</td>";
                // Puedes mostrar otros datos según tus necesidades
                echo '<td class="table1"><textarea name="act' . $field . '" cols="30" rows="2"></textarea></td>';
                echo '<td class="table1"><input type="date" name="inicio' . $field . '"></td>';
                echo '<td class="table1"><input type="date" name="fin' . $field . '"></td>';
                echo '<td class="table1"><input type="text" name="Responsable' . $field . '"></td>';
                echo '<td class="table1"><textarea name="Resultados' . $field . '" cols="30" rows="2"></textarea></td>';
                echo '</tr>';
            }
        }
        ?>
    </table>
    <br>
    <table class='table1' style="width:100%" border="3">
        <?php
        $n = $ficha['n'];
        $consulta = generar_sql($fields);
        $stmt = $conexionBD->prepare($consulta);
        $stmt->bindParam(':n', $n);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        $malcount = $resultado['MalCount'];?>
        <tr>
            <td class='table1'>Observaciones:</td>
            <td class='table1'>Numero de fallas:<?php echo $malcount ?></td>
        </tr>
        <?php
        for ($i = 1; $i <= 8; $i++) {
            $observacionVar = "observacion{$i}";
        
            // Verifica si se debe mostrar la fila
            if (!empty($ficha[$observacionVar])) {
                echo '<tr>';
                echo '<td class="table1" colspan="2"><textarea name="Obs' . $i . '" cols="150" rows="1">' . ($ficha[$observacionVar]) . '</textarea></td>';
                echo '</tr>';
            }
        }?>
    </table>
    <div class='buttons'>
        <form action="" method="post">
            <div class="btn-group" role="group" aria-label="" style="float: right">
                <button type="submit" name="accion" value="Imprimir" class="btn btn-secundary">Imprimir</button>
            </div>
        </form>
    </div>
</form>
<div class='buttons'>
    <form action="" method="post">
        <div class="btn-group" role="group" aria-label="" style="float: right">
            <button type="submit" name="accion" value="volver" class="btn btn-secondary">Volver</button>
        </div>
    </form>
</div>

<?php include("../../../templates/pie.php"); ?>