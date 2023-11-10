<?php
$id=$_POST['id'];
$placa = $_POST['placa'];
$Empresa=$_POST['Empresa'];
$Nombre= $_POST['Nombre'];
$nit = $_POST['nit'];
$nid = $_POST['nid'];
$Estado = $_POST['Estado'];
$observacion = $_POST['observacion'];
$observacion2= $_POST['observacion2'];
$observacion3= $_POST['observacion3'];
$observacion4= $_POST['observacion4'];
$observacion5= $_POST['observacion5'];
$observacion6= $_POST['observacion6'];
$observacion7= $_POST['observacion7'];
$observacion8= $_POST['observacion8'];
$n_fotod = $_FILES['fotod']['filename'];
$fotod = $_FILES['fotod']['tmp_name'];
$n_fotof = $_FILES['fotof']['filename'];
$fotof = $_FILES['fotof']['tmp_name'];
$n_fotoi = $_FILES['fotoi']['filename'];
$fotoi = $_FILES['fotoi']['tmp_name'];

$fields = ['Trek', 'GPS','3G','Sim','HDC','Cable_poder','IOCOVER','Tapa_IOCOVER','Cabezal_Bipode','Bipode',
            'Display','Extencion_poder','Extencion_datos','Soportes_L',
            'APC','Soporte_caja','poder_datos','DC_convertidor',
            'Sensor_pta1','Extencion_cable1','Soportes_angulo1','Sensor_pta2','Extencion_cable2','Soportes_angulo2',
            'panico','Extencion_panico',
            'radio','poder_radio','PI','mic','mic_L','mic_ambiente', 'TRS','euro','altavoz','PTT','inversor',
            'habitaculo','power_on','cable_2x1','amplificador','parlantes','rejillas','pcb','arnes'];
// Actualizar solo el campo placa en la base de datos
$sql = "UPDATE datos SET placa ='$placa', Empresa='$Empresa', Nombre='$Nombre', nit='$nit', nid='$nid',
                        observacion='$observacion', 
                        observacion2='$observacion2', 
                        observacion3='$observacion3', 
                        observacion4='$observacion4', 
                        observacion5='$observacion5',
                        observacion6='$observacion6',
                        observacion7='$observacion7',
                        observacion8='$observacion8' WHERE id = $id";
$consulta = $conexionBD->prepare($sql);
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