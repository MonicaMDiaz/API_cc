<?php
$n= $_POST['n'];
$n_ficha=$_POST['n_ficha'];

$fields = ['Trek', 'GPS','3G','Sim','HDC','Cable_poder','IOCOVER','Tapa_IOCOVER','Cabezal_Bipode','Bipode',          //10
            'Display','Extencion_poder','Extencion_datos','Soportes_L',                                              //4
            'APC','Soporte_caja','poder_datos','DC_convertidor',                                                     //4
            'Sensor_pta1','Extencion_cable1','Soportes_angulo1','Sensor_pta2','Extencion_cable2','Soportes_angulo2', //6
            'panico','Extencion_panico',                                                                             //2
            'radio','poder_radio','PI','mic','mic_L','mic_ambiente', 'TRS','euro','altavoz','PTT','inversor',        //11
            'habitaculo','power_on','cable_2x1','amplificador','parlantes','rejillas','pcb','arnes',
            'observacion','observacion2','observacion3','observacion4', 'observacion5','observacion6','observacion7','observacion8',];     //8
// Actualizar el campo Estado en la tabla inventario
$sql = "UPDATE inventario SET n_ficha ='$n_ficha' WHERE n = $n";
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
$sql .= " WHERE n = $n";
$consulta = $conexionBD->prepare($sql);           
foreach ($fields as $field) {
    $consulta->bindParam(":$field", $_POST[$field]);
}          
$consulta->execute();  