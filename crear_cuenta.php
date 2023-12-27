<!DOCTYPE html>
<html lang="en">

<head>

    <title>Crear cuenta</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body>

    <style>
    body {
        background-color: white;
    }

    h1 {
        color: white;
        text-align: center;
    }

    h2 {
        color: black;
        text-align: center;
    }

    p {
        font-family: verdana;
        font-size: 15px;
    }

    button {
        background-color: #4DCB45;
        border-radius: 50px;
        border: 2px solid;
        color: white;
        padding: 7px;
        width: 100%;
    }

    button:hover,
    button:active {
        background-color: #fff;
        color: #000;
        transition: background-color 0.3s ease-in, color 0.3s ease-in;
    }

    .card-header {
        background-color: #ea5d2d;
        text-align: center;
        color: white;
    }
    </style>

    <?php
include_once 'databases/BD.php';
$conexionBD=BD::crearInstancia();
$id=isset($_POST['id'])?$_POST['id']:'';
$Nombre=isset($_POST['Nombre'])?$_POST['Nombre']:'';
$celular=isset($_POST['celular'])?$_POST['celular']:'';
$usuario = isset($_POST['usuario'])?$_POST['usuario']:'';
$contraseña = isset($_POST['contraseña'])?$_POST['contraseña']:'';

$accion=isset($_POST['accion'])?$_POST['accion']:'';
if($accion!=''){
    switch ($accion) {
        case 'Guardar':
            $sql="INSERT INTO usuarios(id,Nombre,celular,usuario,contraseña) VALUES ('$id', '$Nombre','$celular','$usuario','$contraseña');";
            $consulta=$conexionBD->prepare($sql);
            $consulta->execute(); 
            header('Location: iniciosesion.html');
            break;
    }
}
?>
    <br>
    <div class="container" style="margin-top: 50px; width: 1000px; ">
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <form action="" method="post">
                    <div class="card">
                        <div class="card-header">
                            Creación de cuenta
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="" class="form-label">Nombre</label>
                                <input type="text" class="form-control" name="Nombre" aria-describedby="helpId">
                                <small id="helpId" class="form-text text-muted"></small>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Celular</label>
                                <input type="number" class="form-control" name="celular" aria-describedby="helpId">
                                <small id="helpId" class="form-text text-muted"></small>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Usuario</label>
                                <input type="text" class="form-control" name="usuario" aria-describedby="helpId">
                                <small id="helpId" class="form-text text-muted"></small>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Contraseña</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password" name="contraseña">
                                    <input class="btn btn-outline-secondary" type="checkbox" id="togglePassword">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                    </input>
                                </div>
                            </div>

                            <script>
                            document.getElementById('togglePassword').addEventListener('click', function() {
                                var passwordInput = document.getElementById('password');
                                var icon = this.querySelector('i');
                                if (passwordInput.type === 'password') {
                                    passwordInput.type = 'text';
                                    icon.classList.remove('fa-eye');
                                    icon.classList.add('fa-eye-slash');
                                } else {
                                    passwordInput.type = 'password';
                                    icon.classList.remove('fa-eye-slash');
                                    icon.classList.add('fa-eye');
                                }
                            });
                            </script>
                        </div>
                    </div>
                    <br>
                    <button type="submit" name="accion" value="Guardar"
                        onclick="alert('Nuevo registro guardado');">Registrarse</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
        integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
    </script>
</body>

</html>