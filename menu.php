<?php
if(!isset($_SESSION)){
    session_start();
}
?>

<div class="menu">

<span>👤 <?php echo $_SESSION["usuario"]; ?></span>

<?php if($_SESSION["rol"] == "user"){ ?>
<a href="panel.php">Panel</a>
<?php } ?>

<?php if($_SESSION["rol"] == "puerta" || $_SESSION["rol"] == "admin"){ ?> 
<a href="puerta.php">Puerta</a>
<?php } ?>

<?php if($_SESSION["rol"] == "admin"){ ?>
<a href="panel.php">Lista</a>
<?php } ?>

<a href="logout.php">Salir</a>

</div>

<style>
.menu{
    background:#000;
    padding:10px;
    display:flex;
    gap:10px;
    align-items:center;
    flex-wrap:wrap;
}

.menu a{
    background:#333;
    padding:6px 10px;
    color:white;
    text-decoration:none;
    border-radius:6px;
}
</style>