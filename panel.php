<?php
session_start();
include "conexion.php";

$usuario = $_SESSION["usuario"];

if($_POST){

    $texto = $_POST["lista"];
    $lineas = explode("\n", $texto);
    $grupo = "";

    foreach($lineas as $l){

        $l = trim($l);
        if($l == "") continue;

        if(strlen($l) <= 3){
            $grupo = $l;
            continue;
        }

        $partes = explode(" ", $l);

        $nombre = $partes[0] ?? "";
        $apellido = $partes[1] ?? "";
        $dni = $partes[2] ?? "";

        $sql = "INSERT INTO anotados
        (nombre,apellido,dni,usuario,grupo)
        VALUES
        ('$nombre','$apellido','$dni','$usuario','$grupo')";

        $conn->query($sql);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
body{background:#111;color:white;font-family:Arial;}
textarea{width:100%;height:200px;background:#222;color:white;}
.card{background:#222;margin:8px;padding:10px;border-radius:8px;}
.ok{color:lime;}
</style>

</head>

<body>
    
<?php include "menu.php"; ?>
<h3><?php echo $usuario; ?></h3>

<form method="post">
<textarea name="lista" placeholder="Pegar lista..."></textarea>
<br><br>
<button>Guardar</button>
</form>

<hr>

<?php

$sql = "SELECT * FROM anotados WHERE usuario='$usuario' ORDER BY grupo";
$res = $conn->query($sql);

while($row = $res->fetch_assoc()){
?>

<div class="card">
    
<?php echo $row["grupo"]; ?><br>
<?php echo $row["nombre"]." ".$row["apellido"]; ?><br>
DNI: <?php echo $row["dni"]; ?><br>
<a href="eliminar.php?id=<?php echo $row["id"]; ?>"
onclick="return confirm('Eliminar persona?')"
style="color:red;">❌ Eliminar</a>
<?php if($row["entro"]==1){ ?>
<span class="ok">YA ENTRO ✅</span>

<?php } ?>

</div>

<?php } ?>

</body>
</html>