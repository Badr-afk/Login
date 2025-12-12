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
    <link rel="stylesheet" href="estilo.css">
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
                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                        <div class="form-group">
                            <input type="text" name="usuario" class="form-control" id="userInput" placeholder="Usuario" value="<?php echo isset($_COOKIE['usuario_guardado']) ? htmlspecialchars($_COOKIE['usuario_guardado']) : ''; ?>">
                            <div class="error-text" id="userError">El nombre de usuario es obligatorio</div>
                        </div>

                        <div class="form-group">
                            <input type="password" name="password" class="form-control" id="passInput" placeholder="Contraseña">
                            <div class="error-text" id="passError">La contraseña debe tener al menos 6 caracteres</div>
                        </div>

                        <div class="row align-items-center mb-4">
                            <div class="col-md-6 col-12">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1" name="recordarme">
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