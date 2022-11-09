<?php
    //Atributos para PDO
    $hostdbname = 'mysql:host=localhost;dbname=universidad';
    $username = 'root';
    $password = '';

    //Hacemos un try-catch para capturar errores en caso de que la conexión falle de alguna manera.
    try{
        //Creando conexión a Base de datos
        $con = new PDO($hostdbname,$username,$password,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); 
        $con -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //Definimos el stmt con prepare. El orden de los valores que devolverá el SELECT lo definimos aquí.
        $stmt = $con -> prepare('SELECT dni,nombre,apellido_1,apellido_2,localidad,fecha_nacimiento FROM alumno');
        $stmt->execute();
    //No cierro la llave del try aquí, va más abajo con el catch para darle continuidad y que no de error de catch sin try.
?>
<!-- Cabecera del documento HTML -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="author" content="Martín Antonio Córdoba Getar">
    <meta name="description" content="Práctica de Desarrollo de Interfaces 2ºDAM EFA El Campico">
    <meta name="keywords" content="HTML, PHP, DAM, Ejercicios Desarrollo de Interfaces">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Práctica 1 Desarrollo de Interfaces</title>
    <!-- Estilos para la tabla, esto es mejor crearlo en archivos CSS aparte y lo hago solo por este paquete de prácticas -->
    <style>
        table, tr, th, td
        {
            border: 1px solid black;
            text-align: center;
        }
    </style>
</head>
<!-- Cuerpo HTML -->
<body>
    <!-- Títulos -->
    <h1>Práctica 1 Desarrollo de Interfaces</h1>
    <h2>Alumno: Martín Antonio Córdoba Getar</h2>
    <h3>Práctica 1.4 DI</h3>

    <form action="index.php" method="post">
        <fieldset>
            
        </fieldset>
    </form>

    <p>Listado de alumnos</p>
    <!-- Estructura de la tabla (solo cabecera) -->
    <table>
        <thead>
            <tr>
                <th>DNI</th>
                <th>Nombre</th>
                <th>Apellido 1</th>
                <th>Apellido 2</th>
                <th>Localidad</th>
                <th>F. Nacimiento</th>
            </tr>
        </thead>

    <?php
            // Abrimos cuerpo de la tabla
            echo '<tbody>';
            while($datos = $stmt -> fetch(PDO::FETCH_ASSOC)){
                echo '<tr>'; // Abrimos fila
                foreach ($datos as $key => $value) {
                    echo '<td>' . $value . '</td>'; // En cada iteración pintamos un valor del array, el orden lo da el SELECT del $stmt
                }
                echo '</tr>'; //Cerramos fila
            }
            // Cerramos cuerpo de la tabla
            echo '</tbody>';

        //Si try falla, se lanza excepción PDO
        }catch(PDOException $e){
            echo 'Error en la conexión a la BD: ' . $e -> getMessage();
        }
    ?>
    </table>

</body>
</html>