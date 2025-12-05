<?php
include "establecer-sesion.php";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <style>
        /* Estilos Generales */
        body {
            background-color: #19123B;
            font-family: 'Poppins', sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
        }

        .card {
            border: none;
            border-top: 5px solid rgb(176, 106, 252);
            background: #212042;
            color: #57557A;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            border-radius: 10px;
        }

        p {
            font-weight: 600;
            font-size: 15px;
            color: #8D8BBD;
            letter-spacing: 1px;
        }

        .social-btn {
            display: flex;
            justify-content: center;
            align-items: center;
            background: #2A284D;
            height: 50px;
            width: 100%;
            border-radius: 5px;
            transition: 0.3s;
            text-decoration: none;
            font-size: 20px;
        }

        .social-btn:hover {
            background: #363463;
            transform: translateY(-2px);
            cursor: pointer;
        }

        .fa-twitter {
            color: #56ABEC;
        }

        .fa-facebook {
            color: #1775F1;
        }

        .fa-google {
            color: #CB5048;
        }

        .division {
            display: flex;
            align-items: center;
            text-align: center;
            color: #57557A;
            margin: 30px 0 20px 0;
        }

        .division::before,
        .division::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #57557A;
        }

        .division span {
            padding: 0 10px;
            font-weight: 600;
            font-size: 12px;
            white-space: nowrap;
        }

        .myform {
            padding: 0 10px;
        }

        .form-control {
            background: #2A284D;
            border: 1px solid #3e3c6e;
            color: #fff;
            height: 50px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .form-control::placeholder {
            color: #8D8BBD;
            opacity: 1;
        }

        .form-control:focus {
            background: #2A284D;
            border-color: rgb(176, 106, 252);
            box-shadow: none;
            color: #fff;
        }

        .form-control.is-invalid {
            border-color: #ff4d4d;
            background-image: none;
            margin-bottom: 5px;
        }

        .error-text {
            color: #ff4d4d;
            font-size: 12px;
            margin-bottom: 15px;
            display: none;
            text-align: left;
            padding-left: 2px;
        }

        .bn {
            text-decoration: none;
            color: #8D8BBD;
            font-size: 14px;
            transition: 0.3s;
        }

        .bn:hover {
            color: #fff;
        }

        .form-check-input {
            background-color: #2A284D;
            border-color: #57557A;
        }

        .form-check-label {
            font-size: 14px;
            color: #8D8BBD;
        }

        .btn-primary {
            background: linear-gradient(135deg, rgba(176, 106, 252, 1) 39%, rgba(116, 17, 255, 1) 101%);
            border: none;
            border-radius: 50px;
            height: 50px;
            width: 100%;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-primary small {
            font-size: 16px;
        }

        @media(max-width: 767px) {
            .forgot-pass-container {
                text-align: center;
                margin-top: 10px;
            }
        }

        @media(min-width: 767px) {
            .forgot-pass-container {
                text-align: right;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card py-4 px-3">

                    <p class="text-center mb-4">Login</p>
                    <?php
                    if (isset($_SESSION['error'])) {
                        echo '<div class="alert alert-danger" role="alert">';
                        echo $_SESSION['error'];
                        echo '</div>';
                        unset($_SESSION['error']);
                    }
                    ?>
                    <div class="row mx-auto w-100">
                        <div class="col-4 px-1"><a href="#" class="social-btn"><i class="fab fa-twitter"></i></a></div>
                        <div class="col-4 px-1"><a href="#" class="social-btn"><i class="fab fa-facebook-f"></i></a></div>
                        <div class="col-4 px-1"><a href="#" class="social-btn"><i class="fab fa-google"></i></a></div>
                    </div>

                    <div class="division">
                        <span>Iniciar Sesión</span>
                    </div>

                    <form class="myform" id="loginForm" method="POST" action="autentificacion.php">
                        <div class="form-group">
                            <input type="text" name="usuario" class="form-control" id="userInput" placeholder="Usuario">
                            <div class="error-text" id="userError">El nombre de usuario es obligatorio</div>
                        </div>

                        <div class="form-group">
                            <input type="password" name="password" class="form-control" id="passInput" placeholder="Contraseña">
                            <div class="error-text" id="passError">La contraseña debe tener al menos 6 caracteres</div>
                        </div>

                        <div class="row align-items-center mb-4">
                            <div class="col-md-6 col-12">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                    <label class="form-check-label" for="exampleCheck1">Recordarme</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-12 forgot-pass-container">
                                <a href="#" class="bn">¿Olvidaste tu contraseña?</a>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <small><i class="far fa-user pe-2"></i> Iniciar Sesión</small>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="validacion.js"></script>
</body>

</html>