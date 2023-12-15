<?php
$id=$_POST['id'];
$placa = $_POST['placa'];
$Empresa=$_POST['Empresa'];
$Nombre= $_POST['Nombre'];
$nit = $_POST['nit'];
$nid = $_POST['nid'];
$Estado = $_POST['Estado'];

function uploadImage($inputName, & $imageName, $currentImage, $uploadDirectory) {
    if (!empty($_FILES[$inputName]['name'])) {
        $imageName = $_FILES[$inputName]['name'];
        move_uploaded_file($_FILES[$inputName]['tmp_name'], $uploadDirectory . $imageName);
    } else {
        $imageName = $currentImage;
    }
}

$uploadDirectory = '../images/';
uploadImage('fotod', $fotod, $ficha['fotod'], $uploadDirectory);
uploadImage('fotof', $fotof, $ficha['fotof'], $uploadDirectory);
uploadImage('fotoi', $fotoi, $ficha['fotoi'], $uploadDirectory);

$sql = "UPDATE datos SET placa ='$placa', Empresa='$Empresa', Nombre='$Nombre', nit='$nit', nid='$nid', Estado ='$Estado',
                        fotod='$fotod', fotof='$fotof', fotoi='$fotoi', fecha=current_timestamp	  WHERE id = $id";
$consulta = $conexionBD->prepare($sql);
$consulta->execute();