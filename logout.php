<?php
include "establecer-sesion.php";
$_SESSION = [];
session_destroy();

//Destruir explicitivamente la cookie de sesion y otras cookies potencialmente peligrosas
header("Location:./login.php");
