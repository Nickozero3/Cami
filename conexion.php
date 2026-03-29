<?php
// $conn = new mysqli("localhost","root","","boliche");


// if ($conn->connect_error) {
//     die("Error de conexión");
// }

$host = getenv("mysql.railway.internal");
$user = getenv("root");
$pass = getenv("MgTvItLKIUbRLeAmDplhwSZHDWFpMYbdC");
$db   = getenv("railway");
$port = getenv("3306");

$conn = new mysqli($host, $user, $pass, $db, $port);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>