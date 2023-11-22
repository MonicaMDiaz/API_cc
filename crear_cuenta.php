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
        background-color: rgba(255, 136, 0, 0.856);
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
        background-color: gray;
        border-radius: 50px;
        border: 2px solid black;
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
    </style>
    <br>
    <div class="container" style="margin-top: 50px; width: 1000px; ">
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <form action="iniciosesion.html" method="post">

                    <div class="card">
                        <div class="card-header">
                            Creación de cuenta
                        </div>
                        <div class="card-body">

                            <div class="mb-3">
                                <label for="" class="form-label">Usuario</label>
                                <input type="text" class="form-control" name="Usuario_nuevo" id="Usuario_nuevo"
                                    aria-describedby="helpId" placeholder="@avante.gov.co">
                                <small id="helpId" class="form-text text-muted"></small>
                            </div>

                            <div class="mb-3">
                                <label for="" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" name="psw_nueva" id="psw_nueva"
                                    aria-describedby="helpId" placeholder="Contraseña">
                                <small id="helpId" class="form-text text-muted"></small>
                            </div>
                        </div>
                    </div>
                    <br>
                    <button>Registrarse</button>
                </form>
            </div>
        </div>
    </div>


    <header>
        <!-- place navbar here -->
    </header>
    <main></main>
    <footer>
        <!-- place footer here -->
    </footer>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
        integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
    </script>
</body>

</html>