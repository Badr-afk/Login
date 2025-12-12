<?php
include "establecer-sesion.php";

//Hay que comprobar el csrf token para dejar pasar a a la aplicación
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    $_SESSION['error'] = "Error de seguridad: Token CSRF inválido.";
    header('Location: ./login.php');
} else {
    if (isset($_POST['usuario'])) {

        // Verificación del CSRF Token
        // --- CONFIGURACIÓN ---
        $host = 'localhost';
        $db_user = 'login-php';        // Usuario de la BD (XAMPP por defecto)
        $db_pass = 'B@dado-034?';      // Contraseña (XAMPP por defecto vacía)
        $baseDatos = 'login.php';       // TU BASE DE DATOS SE LLAMA ASÍ

        // --- CONEXIÓN ---
        try {
            // DSN (Data Source Name) para MySQL con soporte de caracteres utf8mb4
            $dsn = "mysql:host=$host;dbname=$baseDatos;charset=utf8mb4";
            $conex = new PDO($dsn, $db_user, $db_pass);
            // Configurar PDO para que lance excepciones en caso de error
            $conex->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            $_SESSION['error'] = "Error conectando a la BD: " . $e->getMessage();
            header('Location: ./login.php');
        }

        // --- SEGURIDAD Y DATOS ---
        // Con PDO no necesitamos real_escape_string, la sentencia preparada lo maneja
        $usuario_form = htmlspecialchars($_POST['usuario']);
        $password_form = htmlspecialchars($_POST['password']);

        // --- CONSULTA ---
        // Usamos marcadores (:usuario) en lugar de concatenar variables
        $stmt = $conex->prepare("SELECT * FROM usuarios WHERE idusuario = :usuario");

        // Ejecutamos la consulta pasando los valores en un array
        $stmt->execute([':usuario' => $usuario_form]);

        // --- VERIFICACIÓN ---
        if ($stmt->rowCount() == 0) {
            // Usuario no encontrado
            $_SESSION['error'] = "El usuario no existe";
            header('Location: ./login.php');
        } else {
            // Usuario encontrado, verificamos contraseña
            // FETCH_OBJ devuelve un objeto anónimo con propiedades que corresponden a las columnas
            $row = $stmt->fetch(PDO::FETCH_OBJ);

            // 1. Verificar si el usuario está bloqueado
            $ahora = date("Y-m-d H:i:s");
            if ($row->bloqueado_hasta && $row->bloqueado_hasta > $ahora) {
                $_SESSION['error'] = "Cuenta bloqueada temporalmente. Inténtalo más tarde.";
                header('Location: ./login.php');
                exit();
            }

            // Verifica que la columna de la contraseña en tu BD se llame 'password'
            if ($row->password == $password_form) {
                // 2. Login exitoso: Resetear contador de intentos y bloqueo
                $stmt_reset = $conex->prepare("UPDATE usuarios SET intentos = 0, bloqueado_hasta = NULL WHERE idusuario = :usuario");
                $stmt_reset->execute([':usuario' => $usuario_form]);

                // TODO CORRECTO
                //Cojo todos los datos del usuario y los paso como variable de sesión
                $_SESSION['nombre'] = $row->nombre;
                $_SESSION['apellidos'] = $row->apellidos;

                // Si el usuario marcó "Recordarme", creamos una cookie que expire en 30 días
                if (isset($_POST['recordarme'])) {
                    // setcookie(nombre, valor, expiración (ahora + 30 días en segundos), ruta)
                    setcookie('usuario_guardado', $usuario_form, time() + (86400 * 30), "/");
                }

                header('Location: inicio.php');
            } else {
                // Contraseña incorrecta
                // 3. Login fallido: Incrementar intentos
                $intentos = $row->intentos + 1;

                if ($intentos >= 5) {
                    // Bloquear por 15 minutos
                    $bloqueo = date("Y-m-d H:i:s", strtotime("+15 minutes"));
                    $stmt_block = $conex->prepare("UPDATE usuarios SET intentos = :intentos, bloqueado_hasta = :bloqueo WHERE idusuario = :usuario");
                    $stmt_block->execute([':intentos' => $intentos, ':bloqueo' => $bloqueo, ':usuario' => $usuario_form]);
                    $_SESSION['error'] = "Has excedido el número de intentos. Cuenta bloqueada por 15 minutos.";
                } else {
                    $stmt_inc = $conex->prepare("UPDATE usuarios SET intentos = :intentos WHERE idusuario = :usuario");
                    $stmt_inc->execute([':intentos' => $intentos, ':usuario' => $usuario_form]);
                    $_SESSION['error'] = "Contraseña incorrecta. Intento $intentos de 5.";
                }
                header('Location: ./login.php');
            }
        }
    } else {
        // Si intentan entrar sin enviar el formulario
        $_SESSION['error'] = "Debes iniciar sesión";
        header('Location: ./login.php');
    }
}
