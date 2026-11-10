<?php
// ============================================================
// conexion.php - Conexión común a la base de datos
// (la usan registro.php y consulta.php)
// ============================================================

$con = mysqli_connect("db", "usuario", "123456", "libreria");

if (mysqli_connect_errno()) {
    die("Error al conectar con la base de datos: " . mysqli_connect_error());
}
