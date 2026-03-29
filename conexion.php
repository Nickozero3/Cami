<?php

$host = "mysql.railway.internal";
$user = "root";
$pass = "gTvItLKIUbRLeAmDplhwSZHDWFpMYbdC";
$db   = "railway";
$port = 3306;

$conn = new mysqli($host, $user, $pass, $db, $port);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

/* ===========================
   CREAR TABLAS AUTOMATICO
=========================== */

$conn->query("
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50),
    password VARCHAR(50),
    rol VARCHAR(20)
)
");

$res = $conn->query("SELECT COUNT(*) as total FROM usuarios");
$row = $res->fetch_assoc();

if($row["total"] == 0){
    $conn->query("
    INSERT INTO usuarios (usuario,password,rol) VALUES
    ('admin','1234','admin'),
    ('puerta','1234','puerta'),
    ('nicko','1234','user')
    ");
}

$conn->query("
CREATE TABLE IF NOT EXISTS anotados (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50),
    apellido VARCHAR(50),
    dni VARCHAR(20),
    usuario VARCHAR(50),
    grupo VARCHAR(20),
    entro INT DEFAULT 0
)
");
?>