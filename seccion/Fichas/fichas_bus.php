<!DOCTYPE html>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<head>
    <title>Fichas</title>
    <link rel="stylesheet" type="text/css" href="estilos.css">
    </link>
</head>

</html>
<?php include("../../templates/cabecera.php"); ?>
<br>
<style>
body {
    background-color: white;
}

h1 {
    color: #5f6160;
    text-align: center;
    font-family: Arial Rounded MT;
    font-weight: bold;
    font-size: 30px;
}

h2 {
    color: black;
    text-align: center;
    font-family: Arial Rounded MT;
    font-weight: bold;
    font-size: 50px;
}

p {
    font-family: Arial Rounded MT;
    font-size: 15px;
}

.button {
    margin-left: 85%;
}

.button1 {
    background-color: gray;
    border-radius: 50px;
    border: 2px solid black;
    color: white;
    padding: 7px;
}

.button1:hover,
.button1:active {
    background-color: #28AC8A;
    color: #000;
    transition: background-color 0.3s ease-in, color 0.3s ease-in;
}

.button2 {
    background-color: #249475;
    border-radius: 5px;
    border: 1px;
    color: white;
    padding: 5px;
}

.button2:hover,
.button2:active {
    background-color: #228B6D;
    color: #000;
    transition: background-color 0.3s ease-in, color 0.3s ease-in;
}
</style>
<br>
<?php
function seeImage($currentImage, $defecto) {
    if (!empty($currentImage)):?>
<img src="images/<?php echo $currentImage; ?>" alt="Cara derecha del bus" width="400" height="300">
<?php else: ?>
<img src="<?php echo $defecto ?>" alt="Imagen" width="250" height="250">
<?php endif;
}
//INSERT INTO `datos` (`id`, `placa`, `fecha`) VALUES ('', NULL, current_timestamp())
include_once '../../databases/BD.php';
$conexionBD=BD::crearInstancia();

$id = $_GET['id'];
$sql = "SELECT * FROM datos WHERE id = :id";
$consulta = $conexionBD->prepare($sql);
$consulta->bindParam(':id', $id);
$consulta->execute();
$ficha = $consulta->fetch(PDO::FETCH_ASSOC);

$sqlInventario = "SELECT * FROM inventario WHERE id = :id";
$consultaInventario = $conexionBD->prepare($sqlInventario);
$consultaInventario->bindParam(':id', $id);
$consultaInventario->execute();
$fichasInventario = $consultaInventario->fetchAll(PDO::FETCH_ASSOC);

$n=isset($_POST['n'])?$_POST['n']:'';
$sumaf = isset($_POST['sumaf'])?$_POST['sumaf']:0;
$sumaob=isset($_POST['sumaob'])?$_POST['sumaob']:0;

$accion=isset($_POST['accion'])?$_POST['accion']:'';

if($accion!=''){
    switch ($accion) {
        case 'Ver':
            //header('Location: ficha_i.php');
            header('Location: ficha_i.php?n=' . $n);
            break;
        case 'Editar':
            header('Location: Editar/editarficha.php?n=' . $n);
            break;
        case 'Editar_info':
            header('Location: Editar/editar_info.php?id=' . $id);
            break;
        case 'crear':
            //INSERT INTO datos_inventario(id, iddato, ninventario) VALUES  ($id, '$id', null);
            $sql="INSERT INTO inventario(id) VALUES ($id);";
            $consulta=$conexionBD->prepare($sql);
            $consulta->execute(); 
            $sql = "UPDATE inventario SET n_ficha = ( SELECT x_id FROM ( SELECT n, id, ROW_NUMBER() OVER (PARTITION BY id ORDER BY n) AS x_id FROM inventario ) AS t WHERE inventario.n = t.n )";
                    $consulta=$conexionBD->prepare($sql);
                    $consulta->execute();
            header('Location: fichas_bus.php?id=' . $id);
            break;
        case 'Borrar':
            try {
                // Comienza la transacción
                $conexionBD->beginTransaction();
                
                // Borra el registro con el valor de n
                $sql = "DELETE FROM inventario WHERE n=:n";
                $consulta=$conexionBD->prepare($sql);
                $consulta->bindParam(':n',$n);
                $consulta->execute();
        
                // Actualiza el valor de n_ficha con el valor de x_id
                $sql = "UPDATE inventario SET n_ficha = ( SELECT x_id FROM ( SELECT n, id, ROW_NUMBER() OVER (PARTITION BY id ORDER BY n) AS x_id FROM inventario ) AS t WHERE inventario.n = t.n )";
                $consulta=$conexionBD->prepare($sql);
                $consulta->execute();
        
                // Finaliza la transacción y confirma los cambios
                $conexionBD->commit();
            } catch (Exception $e) {
        
                // Cancela la transacción y deshace los cambios
                $conexionBD->rollback();
                echo "Error: " . $e->getMessage();
            }
            header('Location: fichas_bus.php?id=' . $id);
            break;
        default:
            break;
    }
}
$defecto = "images/setp.png";

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

function sql_obs($obs){
    $sql = "SELECT n, ";
  foreach ($obs as $obser) {
    $sql .= "(CASE WHEN $obser = '' THEN 0 ELSE 1 END) + ";
  }
  // $sql .= "(CASE WHEN $col = 'mal' THEN 1 ELSE 0 END) + ";
  $sql = rtrim($sql, "+ ");
  $sql .= "AS obsCount ";
  $sql .= "FROM inventario ";
  $sql .= "WHERE n = :n";
  return $sql;
}
?>
<h3></h3>
<div style="display: flex; justify-content: space-between;">
    <?php 
    seeImage($ficha['fotod'],$defecto);
    seeImage($ficha['fotof'],$defecto);
    seeImage($ficha['fotoi'],$defecto);
    ?>
</div>
<br>
<div class='table'>
    <table width='100%' style="border: 3px solid #ea5d2d;"><br>
        <h1>Información del vehículo</h1>
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
            <th>Estado</th>
            <td> <?php echo $ficha["Estado"]?> </td>
        </tr>
    </table>
</div>
<form action="" method="post">
    <input type="hidden" name="id" value="<?php echo $ficha['id'];?>">
    <div class='button'>
        <button type="submit" name="accion" value="Editar_info" class='button2'>Editar información</button>
    </div>
</form>
<div class='table'>
    <table class='table' width='100' style="border: 2px solid #4DCB45;"><br>
        <h1>Fichas de mantenimiento</h1>
        <tr>
            <th class='table2'># de ficha</th>
            <th class='table2'>N° de fallas</th>
            <th class='table2'>N° de observaciones</th>
            <th scope='col'>Fecha de creación</th>
            <th scope='col' style="text-align: center;">Acción</th>
        </tr>
        <?php foreach ($fichasInventario as $fichaInventario) : 
            $n = $fichaInventario['n'];
            $consulta = generar_sql($columnas);
            $stmt = $conexionBD->prepare($consulta);
            $stmt->bindParam(':n', $n);
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            $malcount = $resultado['MalCount'];
            
            $consultao = sql_obs($obs); // Asegúrate de tener la función sql_obs definna
            $con = $conexionBD->prepare($consultao);
            $con->bindParam(':n', $n);
            $con->execute();
            $resultadoo = $con->fetch(PDO::FETCH_ASSOC);
            $obscount = $resultadoo['obsCount'];?>
        <tr>
            <td> <?php echo $fichaInventario['n_ficha'] ?> </td>
            <td> <?php echo $malcount ?> </td>
            <td> <?php echo $obscount ?> </td>
            <td> <?php echo $fichaInventario["fecha"] ?> </td>
            <td style="text-align: center;">
                <form action="" method="post">
                    <input type="hidden" name="n" value="<?php echo $fichaInventario['n']; ?>">
                    <div class="btn-group" role="group" aria-label="">
                        <button type="submit" name="accion" value="Ver" class="btn btn-dark">Ver</button>
                        <button type="submit" name="accion" value="Editar" class="btn btn-success">Editar</button>
                        <button type="submit" name="accion" value="Borrar" class="btn btn-danger"
                            onclick="return confirm('¿Estás seguro de que quieres borrar este registro?');">Borrar</button>
                    </div>
                </form>
            </td>
        </tr>
        <?php 
        $sumaf += $malcount;  
        $sumaob += $obscount;
        endforeach;
    $sql="UPDATE datos SET sumaf ='$sumaf', sumaob='$sumaob' WHERE id = $id";
    $consulta = $conexionBD->prepare($sql);
    $consulta->execute(); ?>
    </table>
</div>
<form action="" method="post">
    <input type="hidden" name="id" value="<?php echo $ficha['id'];?>">
    <div class='button'>
        <button type="submit" name="accion" value="crear" class='button1'>Crear ficha</button>
    </div>
</form>
<h1></h1>

<?php include("../../templates/pie.php"); ?>