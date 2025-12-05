<?php
include "establecer-sesion.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Inicio de la Aplicación</title>
</head>

<body>
    <h2>GRUD a tu Aplicación</h2>
    <h2>Bienvenido, <?php echo $_SESSION['nombre'] . " " . $_SESSION['apellidos']; ?></h2>
    <a class="btn btn-secondary" href="./logout.php">Logout</a>
</body>

</html>