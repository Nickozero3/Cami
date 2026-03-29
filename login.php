<?php
session_start();
include "conexion.php";

if($_POST){

    $u = $_POST["usuario"];
    $p = $_POST["password"];

    $sql = "SELECT * FROM usuarios
            WHERE usuario='$u'
            AND password='$p'";

    $res = $conn->query($sql);

    if($res->num_rows > 0){

        $row = $res->fetch_assoc();

        $_SESSION["usuario"] = $row["usuario"];
        $_SESSION["rol"] = $row["rol"];

        if($row["rol"] == "puerta"){
            header("Location: puerta.php");
        }else{
            header("Location: panel.php");
        }

    }else{
        echo "Error";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login</title>

<style>
body{background:#111;color:white;font-family:Arial;text-align:center;}
input,button{padding:10px;margin:5px;font-size:16px;}
</style>

</head>
<body>

<h2>Login</h2>

<form method="post">
<input name="usuario" placeholder="Usuario"><br>
<input name="password" placeholder="Password"><br>
<button>Entrar</button>
</form>

</body>
</html>