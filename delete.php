<?php
$dni = $_GET["dni"];

//Atributos para PDO
$hostdbname = 'mysql:host=localhost;dbname=universidad';
$username = 'root';
$password = '';

//Hacemos un try-catch para capturar errores en caso de que la conexión falle de alguna manera.
try{
    //Creando conexión a Base de datos
    $con = new PDO($hostdbname,$username,$password,array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8')); 
    $con -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $parametro = array();
    $parametro[":dni"] = $dni;

    //Query
    $sql = 'DELETE FROM alumno WHERE dni=:dni';

    //Statement prepare & execute.
    $stmt = $con -> prepare($sql);
    $stmt->execute($parametro);

    header("Location: ./index.php"); //Después de ejecutar el statement recarga la página index.php

//Si try falla, se lanza excepción PDO
}
catch(PDOException $e){
    echo 'Error en la conexión a la BD: ' . $e -> getMessage();
}

?>

