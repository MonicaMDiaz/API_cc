<!DOCTYPE html>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<head>
    <title>Agregar ficha</title>
    <link rel="stylesheet" type="text/css" href="estilos.css">
    </link>
</head>

</html>
<?php include("../../../templates/cabecera_scu.php"); ?>
<style>
body {
    background-color: white;
}

.buttons {
    display: flex;
    justify-content: space-between;
    margin: 4px 2px;
}

.btn-black {
    background-color: #4DCB45;
    color: white;
    border-color: #4DCB45;
}

.btn-outline-black {
    border-color: #4DCB45;
    color: #50b849;
}

h4 {
    color: white;
    text-align: left;
    font-family: Arial Rounded MT;
    font-weight: bold;
    font-size: 15px;
    text-shadow: -1px 0 black, 0 1px black, 1px 0 black, 0 -1px black;
}

.card-header {
    background-color: #ea5d2d;
    text-align: center;
    color: white;
}
</style>
<?php
include_once '../../../databases/BD.php';
$conexionBD=BD::crearInstancia();
$id = $_GET['id'];
$sql = "SELECT * FROM datos  WHERE id = :id";
$consulta = $conexionBD->prepare($sql);
$consulta->bindParam(':id', $id);
$consulta->execute();
$ficha = $consulta->fetch(PDO::FETCH_ASSOC);

$accion=isset($_POST['accion'])?$_POST['accion']:'';

if($accion!=''){
    switch ($accion) {
        case 'Guardar':
            include 'datos.php';
            // Recargar los datos actualizados desde la base de datos
            $sql = "SELECT * FROM datos WHERE id = :id";
            $consulta = $conexionBD->prepare($sql);
            $consulta->bindParam(':id', $id);
            $consulta->execute();
            $ficha = $consulta->fetch(PDO::FETCH_ASSOC);
            break;
        case 'Aceptar':
            header('Location: ../fichas_bus.php?id=' . $id);
            break;
        default:
            break;
    }
}
?>

<html>
<div class="container" style="margin-top: 50px; width: 1000px; ">
    <div class="row">
        <div class="col-md-1">
        </div>
        <div class="col-md-10">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="card">
                    <div class="card-header">
                        Editar información de ID: <?php echo $ficha['id']?>
                    </div>

                    <div class="card-body">
                        <div class="mb-3">
                            <div style="display: flex; justify-content: space-between;">
                                <p>Foto de la cara derecha del bus</p>
                                <p>Foto del frente del bus</p>
                                <p>Foto de la Cara izquierda del bus</p>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <input type="file" name="fotod" accept="image/jpeg, image/png, image/webp">
                                <input type="file" name="fotof" accept="image/jpeg, image/png, image/webp">
                                <input type="file" name="fotoi" accept="image/jpeg, image/png, image/webp">
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="" class="form-label">Placa</label>
                                    <input type="text" class="form-control" name="placa"
                                        value="<?php echo $ficha['placa']?>">
                                </div>
                                <div class="col-md-4">
                                    <label for="" class="form-label">Empresa</label>
                                    <input type="text" class="form-control" name="Empresa"
                                        value="<?php echo $ficha['Empresa']?>">
                                </div>
                                <div class="col-md-4">
                                    <label for="" class="form-label">Estado</label>
                                    <?php $estados = array("Activo", "Inactivo", "En reparación");?>
                                    <select class="form-control" name="Estado">
                                        <?php foreach($estados as $estado): ?>
                                        <option value="<?php echo $estado; ?>"><?php echo $estado; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="" class="form-label">Nombre Conductor</label>
                                    <input type="text" class="form-control" name="Nombre"
                                        value="<?php echo $ficha['Nombre']?>" aria-describedby="helpId">
                                </div>
                                <div class="col-md-2">
                                    <label for="" class="form-label">Tipo</label>
                                    <input type="text" class="form-control" name="nit"
                                        value="<?php echo $ficha['nit']?>" aria-describedby="helpId">
                                </div>
                                <div class="col-md-4">
                                    <label for="" class="form-label">Identificación</label>
                                    <input type="number" class="form-control" name="nid"
                                        value="<?php echo $ficha['nid']?>" aria-describedby="helpId">
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $ficha['id'];?>">
                        <div class="btn-group" role="group" aria-label="">
                            <button type="submit" name="accion" value="Guardar" class="btn btn-black"
                                onclick="return confirm('¿Editar cambios?');">Guardar</button>
                            <button type="submit" name="accion" value="Aceptar"
                                class="btn btn-outline-black">Aceptar</button>
                        </div>
                    </div>
                </div>

            </form>

        </div>
    </div>

</html>
<?php include("../../../templates/pie.php"); ?>