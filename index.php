<?php
    //Atributos para PDO
    $hostdbname = 'mysql:host=localhost;dbname=universidad';
    $username = 'root';
    $password = '';

    //Variables introducidas por el usuario. Lo heredamos del método POST
    $filtros = $_POST;

    //Hacemos un try-catch para capturar errores en caso de que la conexión falle de alguna manera.
    try{
        //Creando conexión a Base de datos
        $con = new PDO($hostdbname,$username,$password,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); 
        $con -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //Array que recoge parámetros sólo si el usuario ha utilizado un determinado filtro.
        $parametros = array();

        //Creamos una variable para realizar la query. Esta variable es un String va cambiando según si el usuario usa un filtro o no
        $sql = 'SELECT dni, nombre, apellido_1, apellido_2, localidad, fecha_nacimiento FROM alumno WHERE true';

        //Condiciones de filtros. Se añaden si el usuario indica un valor en un filtro y son acumulativos. Definen $sql y $parametros
        if (isset($filtros["dni"]) && !empty($filtros["dni"])){
            $sql .= " AND dni LIKE :dni";
            $parametros[":dni"] = "%".$filtros["dni"]."%"; //No hago que sea resultado exacto porque un usuario puede querer ver todos los dnis que tienen por ejemplo 111.
        }
        if (isset($filtros["nombre"]) && !empty($filtros["nombre"])){
            $sql .= " AND nombre LIKE :nombre";
            $parametros[":nombre"] = "%".$filtros["nombre"]."%";
        }
        if (isset($filtros["localidad"]) && !empty($filtros["localidad"])){
            $sql .= " AND localidad LIKE :localidad";
            $parametros[":localidad"] = "%".$filtros["localidad"]."%";
        }
        if (isset($filtros["fecha_nacimiento"]) && !empty($filtros["fecha_nacimiento"])){
            $sql .= " AND fecha_nacimiento > :fecha_nacimiento";
            $parametros[":fecha_nacimiento"] = $filtros["fecha_nacimiento"];
        }

        echo $sql.'<br/>';
        echo empty($filtros);

        //Definimos el stmt con prepare. El orden de los valores que devolverá el SELECT lo definimos aquí.
        $stmt = $con -> prepare($sql);
        
        // Con execute parametrizamos la query y asignamos los valores a las variables de usuario
        $stmt->execute($parametros);

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
            <legend>Filtros de búsqueda</legend>
            <label for="dni">DNI:</label><input type="text" name="dni" id="dni" placeholder="01234567A" title="Escribe un DNI">
            <label for="nombre">Nombre:</label><input type="text" name="nombre" id="nombre" placeholder="Pep" title="Escribe un nombre">
            <label for="localidad">Localidad:</label><input type="text" name="localidad" id="licalidad" placeholder="Elche" title="Escribe una localidad">
            <label for="fecha_nacimiento">F. Nacimiento:</label><input type="date" name="fecha_nacimiento" id="fecha_nacimiento" placeholder="20/05/1991" title="Escribe una fecha en formato DD/MM/AAAA">
            <input type="submit" value="Enviar" name="enviar" id="enviar"> <!-- Una vez presionado enviar, el formulario se resetea y no guarda valores, pero muestra la tabla con los últimos resultados -->
            <input type="reset" value="Limpiar" name="limpiar" id="limpiar"> <!-- Borra solo los valores introducidos antes de presionar enviar -->
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
            // Estructura de la tabla (solo cuerpo)
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