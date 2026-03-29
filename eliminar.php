<?php
session_start();
include "conexion.php";

$id = $_GET["id"];
$usuario = $_SESSION["usuario"];
$rol = $_SESSION["rol"];

// verificar que puede borrar
if($rol == "user"){

    $sql = "DELETE FROM anotados 
            WHERE id=$id 
            AND usuario='$usuario'";

}else{

    $sql = "DELETE FROM anotados 
            WHERE id=$id";

}

$conn->query($sql);

// volver a donde estaba
if($rol == "user"){
    header("Location: panel.php");
}else{
    header("Location: puerta.php");
}
?>