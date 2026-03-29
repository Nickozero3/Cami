<?php
session_start();
include "conexion.php";
$usuarioFiltro = $_GET["usuario"] ?? "";

if($_SESSION["rol"] != "puerta" and $_SESSION["rol"] != "admin"){
    die("No permitido");
}

if(isset($_GET["estado"])){
    $id = $_GET["estado"];

    $conn->query("
        UPDATE anotados 
        SET entro = CASE
            WHEN entro = 0 THEN 1
            WHEN entro = 1 THEN 2
            ELSE 0
        END
        WHERE id = $id
    ");
}

$buscar = $_GET["buscar"] ?? "";
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
body{background:#111;color:white;font-family:Arial;}
.card{background:#222;margin:8px;padding:10px;border-radius:8px;}
.btn{background:green;color:white;padding:8px;border-radius:6px;text-decoration:none;}
.ok{color:lime;}
.resumen{background:#000;padding:10px;margin:10px;}
</style>

</head>

<body>
<?php include "menu.php"; ?>
<h2>CONTROL PUERTA</h2>

<h3>RESUMEN</h3>

<div class="resumen">

<?php

$sql = "SELECT usuario, COUNT(*) as total FROM anotados GROUP BY usuario";
$res = $conn->query($sql);

while($row = $res->fetch_assoc()){

    $user = $row["usuario"];
    $total = $row["total"];

    $r2 = $conn->query("SELECT COUNT(*) as e FROM anotados WHERE usuario='$user' AND entro=1");
    $entro = $r2->fetch_assoc()["e"];

    $dinero = $entro * 500;
?>

<div class="card" style="background:#000; border:1px solid #555;">

<a href="puerta.php?usuario=<?php echo $user; ?>" 
style="text-decoration:none; color:white; display:block;">

<b><?php echo $user; ?></b><br>

Invitados: <?php echo $total; ?><br>
Entraron: <?php echo $entro; ?><br>

<span style="color:lime; font-size:18px;">
$<?php echo $dinero; ?>
</span>

</a>

</div>

<?php
}
?>

</div>

<form>
<input name="buscar" value="<?php echo $buscar; ?>" placeholder="Buscar">
<button>Buscar</button>
<?php if($usuarioFiltro != ""){ ?>
<br><br>
<a href="puerta.php" style="color:orange;">🔙 Ver todos</a>
<?php } ?>
</form>

<hr>

<?php

if($usuarioFiltro != ""){

$sql = "SELECT * FROM anotados 
        WHERE usuario='$usuarioFiltro'";

}elseif($buscar!=""){

$sql="SELECT * FROM anotados WHERE 
nombre LIKE '%$buscar%' OR 
apellido LIKE '%$buscar%' OR 
dni LIKE '%$buscar%' OR 
usuario LIKE '%$buscar%'";

}else{

$sql="SELECT * FROM anotados ORDER BY grupo";

}

$res = $conn->query($sql);

while($row = $res->fetch_assoc()){
?>

<div class="card">

<?php echo $row["grupo"]; ?><br>
<?php echo $row["nombre"]." ".$row["apellido"]; ?><br>
DNI: <?php echo $row["dni"]; ?><br>
Invita: <?php echo $row["usuario"]; ?><br><br>

<?php
if($row["entro"]==0){
    echo "<span style='color:orange;'>NO LLEGÓ ⏳</span><br><br>";
}elseif($row["entro"]==1){
    echo "<span style='color:lime;'>ADENTRO 🟢</span><br><br>";
}else{
    echo "<span style='color:red;'>SE FUE 🚶</span><br><br>";
}
?>

<a class="btn"
style="
background:
<?php
if($row["entro"]==0) echo 'green';
elseif($row["entro"]==1) echo 'red';
else echo 'gray';
?>;
"
href="?estado=<?php echo $row["id"]; ?>">

<?php
if($row["entro"]==0) echo "ENTRO";
elseif($row["entro"]==1) echo "SE FUE";
else echo "RESET";
?>

</a>

</div>

<?php } ?>

</body>
</html>