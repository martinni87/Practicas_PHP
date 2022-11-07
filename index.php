<?php
    /*echo "<pre>";
    print_r($_POST);
    echo "</pre>";*/

    $rows = 0;
    $columns = 0;

    if (isset($_POST["rows"])){ //Comprobamos que existe
        $rows = $_POST["rows"];
    }
    if (isset($_POST["columns"])){ //Comprobamos que existe
        $columns = $_POST["columns"];
    }

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="author" content="Martín Antonio Córdoba Getar">
    <meta name="description" content="Práctica de Desarrollo de Interfaces 2ºDAM EFA El Campico">
    <meta name="keywords" content="HTML, PHP, DAM, Ejercicios Desarrollo de Interfaces">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!--<link rel="icon" type="image/x-icon" href="./img/logo.png">
    <link rel="stylesheet" href="./css/estilos.css">-->

    <title>Práctica 1 Desarrollo de Interfaces</title>
</head>
<body>
    <h1>Práctica 1 Desarrollo de Interfaces</h1>
    <h2>Alumno: Martín Antonio Córdoba Getar</h2>
    <!-- Para que un usuario introduzca la cantidad de columnas y filas manualmente, debemos crear un formulario -->
    <form method = "post" action = "index.php"> <!-- method get o post, ver www.w3schools.com/tags/att_form_method.asp. Action es el documento a donde mandamos la info para procesarla-->
                                                <!-- añadimos la cabecera al principio de este documento que es el que va a procesar el formulario -->
        <label for="rows">Filas</label><input type="number" name="rows" id="rows" value="<?php echo $rows ?>">
        <label for="columns">Columnas</label><input type="number" name="columns" id="columns" value="<?php echo $columns ?>">
        <input type="submit" value="Enviar" name="enviar" id="enviar">
    </form>
    <br>
    <!--
    No forzar nunca saltos de linea en html, es mala práctica. Hacerlo luego con CSS
    Ver más abajo, el comentario sobre la estructura de tabla que queremos crear
    Creamos una matriz (tabla) indicando el número de columnas y filas
    Ejemplo de estructura de tabla que queremos -->
    
    <table border="1">
        <!-- Cabecera de la tabla, una única fila (1 tr). tantas th como columnas haya -->
        <thead>
            <tr>
                <?php
                    for ($i=0;$i<$columns;$i++){
                        echo '<th>Campo '.($i+1).'</th>';
                    }
                ?>
            </tr>
        </thead>

        <!-- Cuerpo de la tabla, tantas tr como filas haya, tantas td como columnas haya -->
        <tbody>
            <?php
                for ($i = 0; $i<$rows;$i++){
                    echo '<tr>';
                    for ($j = 0; $j < $columns; $j++){
                        echo '<td>Fila '.($i+1).' Columna '.($j+1).'</td>';
                    }
                    echo '</tr>';
                }    
            ?>
        </tbody>
    </table>
</body>
</html>