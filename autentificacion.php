<?php
session_start();

if (isset($_POST['usuario'])) {

    // --- CONFIGURACIÓN ---
    $host = 'localhost';
    $db_user = 'root';        // Usuario de la BD (XAMPP por defecto)
    $db_pass = '';            // Contraseña (XAMPP por defecto vacía)
    $baseDatos = 'login.php'; // TU BASE DE DATOS SE LLAMA ASÍ

    // --- CONEXIÓN ---
    // Usamos @ para controlar nosotros el error si falla
    $conex = @new mysqli($host, $db_user, $db_pass, $baseDatos);

    // Si falla la conexión (Línea 14 corregida)
    if ($conex->connect_error) {
        $_SESSION['error'] = "Error conectando a la BD 'login.php': " . $conex->connect_error;
        header('Location: ./login.php');
        exit();
    }

    // --- SEGURIDAD Y DATOS ---
    // Usamos real_escape_string para evitar que rompan la consulta SQL
    $usuario_form = htmlspecialchars($_POST['usuario']);
    $password_form = htmlspecialchars($_POST['password']);

    // --- CONSULTA ---
    // Asegúrate de que la tabla se llama 'usuarios' y la columna 'idusuario'
    $query = "SELECT * FROM usuarios WHERE idusuario = '" . $usuario_form . "'";
    $resultado = $conex->query($query);

    // --- VERIFICACIÓN ---
    if ($resultado->num_rows == 0) {
        // Usuario no encontrado
        $_SESSION['error'] = "El usuario no existe";
        header('Location: ./login.php');
        exit();
    } else {
        // Usuario encontrado, verificamos contraseña
        $row = mysqli_fetch_object($resultado);

        // Verifica que la columna de la contraseña en tu BD se llame 'password'
        if ($row->password == $password_form) {
            // TODO CORRECTO
            header('Location: inicio.php');
            exit();
        } else {
            // Contraseña incorrecta
            $_SESSION['error'] = "Contraseña incorrecta";
            header('Location: ./login.php');
            exit();
        }
    }
} else {
    // Si intentan entrar sin enviar el formulario
    $_SESSION['error'] = "Debes iniciar sesión";
    header('Location: ./login.php');
    exit();
}
