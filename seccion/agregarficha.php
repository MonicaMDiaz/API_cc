<!DOCTYPE html>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<head>
    <title>Agregar ficha</title>
    <link rel="stylesheet" type="text/css" href="estilos.css">
    </link>
</head>

</html>
<?php include("../templates/cabecera.php"); ?>
<style>
body {
    background-color: orange;
}

.buttons {
    display: flex;
    justify-content: space-between;
    margin: 4px 2px;
}

.btn-black {
    background-color: black;
    color: white;
    border-color: black;
    active-color: black;
    active-border-color: black;
    active-bg: black;
    hover-border-color: black;
    hover-color: black;
    hover-bg: black;
}

.btn-outline-black {
    border-color: black;
    color: black;
    active-color: black;
    active-border-color: black;
    active-bg: black;
    hover-border-color: black;
    hover-color: black;
    hover-bg: black;
}

h4 {
    color: white;
    text-align: left;
    font-family: Arial Rounded MT;
    font-weight: bold;
    font-size: 15px;
    text-shadow: -1px 0 black, 0 1px black, 1px 0 black, 0 -1px black;
}
</style>
<?php
include_once '../databases/BD.php';
$conexionBD=BD::crearInstancia();
$id=isset($_POST['id'])?$_POST['id']:'';
$placa=isset($_POST['placa'])?$_POST['placa']:'';
$Empresa=isset($_POST['Empresa'])?$_POST['Empresa']:'';
$Nombre=isset($_POST['Nombre'])?$_POST['Nombre']:'';
$nid=isset($_POST['nid'])?$_POST['nid']:'';
$accion=isset($_POST['accion'])?$_POST['accion']:'';


if($accion!=''){
    switch ($accion) {
        case 'Guardar':
            $sql="INSERT INTO datos(id, placa,Empresa,Nombre,nid,fecha) VALUES ('$id', '$placa','$Empresa', '$Nombre','$nid',  current_timestamp());
            INSERT INTO inventario(id) VALUES ($id);
            INSERT INTO datos_inventario (id, iddato, idinventario) VALUES ($id, '$id', '$id');";
            $consulta=$conexionBD->prepare($sql);
            $consulta->execute(); 
            
            break;
        case 'Aceptar':
            header('Location: fichas.php');
            break;
        default:
            break;
    }
}
?>


<html>
<div class="container" style="margin-top: 50px; width: 1000px; ">
    <div class="row">
        <div class="col-md-3">

        </div>
        <div class="col-md-6">
            <form action="" method="post">
                <div class="card">
                    <div class="card-header">
                        Agregar ficha
                    </div>
                    <div class="card-body">

                        <div class="mb-3">
                            <label for="" class="form-label">ID</label>
                            <input type="number" class="form-control" name="id" id="id" aria-describedby="helpId"
                                placeholder="Ej: 10">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Placa</label>
                            <input type="text" class="form-control" name="placa" id="placa" aria-describedby="helpId"
                                placeholder="Ej: MDM123">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Empresa</label>
                            <input type="text" class="form-control" name="Empresa" id="Empresa"
                                aria-describedby="helpId" placeholder="Ej: Autobuses">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Nombre Conductor</label>
                            <input type="text" class="form-control" name="Nombre" id="Nombre" aria-describedby="helpId"
                                placeholder="Ej: Pepito Pablo Paz Lozano">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Identificación</label>
                            <input type="number" class="form-control" name="nid" id="nid" aria-describedby="helpId"
                                placeholder="Ej: 0123456789">
                        </div>
                        <div class="btn-group" role="group" aria-label="">
                            <button type="submit" name="accion" value="Guardar" class="btn btn-black"
                                onclick="alert('Nuevo registro guardado');">Guardar</button>
                            <button type="submit" name="accion" value="Aceptar"
                                class="btn btn-outline-black">Aceptar</button>
                        </div>
                    </div>
                </div>

            </form>

        </div>
    </div>

</html>

<?php include("../templates/pie.php"); ?>