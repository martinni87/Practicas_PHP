<!-- Añadimos a la cabeza del documento este fragmento de código php que procesará los datos del formulario -->
<?php
    /*echo "<pre>";
    print_r($_POST);
    echo "</pre>";*/

    $rows = 2; //En la primera carga forzamos tabla 2x2
    $columns = 2; //En la primera carga forzamos tabla 2x2

    if (isset($_POST["rows"])){ //Comprobamos que existe
        if ($_POST["rows"] < 1){ //Caso valor menor a 1, asignamos valor = 2
            $rows = 2;
        }
        else{
            $rows = $_POST["rows"]; //Caso valor >= 1, asignamos valor desde array $_POST
        }
    }
    if (isset($_POST["columns"])){//Comprobamos que existe
        if ($_POST["columns"] < 1){ //Caso valor menor a 1, asignamos valor = 2
            $columns = 2;
        }
        else{
            $columns = $_POST["columns"]; //Caso valor >= 1, asignamos valor desde array $_POST
        }
    }
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
</head>
<body>
    <h1>Práctica 1 Desarrollo de Interfaces</h1>
    <h2>Alumno: Martín Antonio Córdoba Getar</h2>
    <!-- Para que un usuario introduzca la cantidad de columnas y filas manualmente, debemos crear un formulario -->
    <form method = "post" action = "index.php"> <!-- method get o post, ver www.w3schools.com/tags/att_form_method.asp. Action es el documento a donde mandamos la info para procesarla, en este caso este mismo documento php-->
                                                <!-- añadimos a la cabecera al principio de este documento lo que va a procesar el formulario -->
        <fieldset>
            <legend>Datos para la tabla</legend>
            <label for="rows">Filas</label><input type="number" name="rows" id="rows" value="<?php echo $rows ?>">
            <label for="columns">Columnas</label><input type="number" name="columns" id="columns" value="<?php echo $columns ?>">
            <input type="submit" value="Enviar" name="enviar" id="enviar">
        </fieldset>
    </form>
    <br> <!-- No es buena práctica usar saltos de línea en html, mejor hacerlo mediante CSS. Se deja así porque esta práctica se enfoca solo en php -->
    <!-- Creamos una matriz (tabla) indicando el número de columnas y filas -->
    
    <table border="1"> <!-- Tampoco es buena práctica poner border aquí, es mejor en CSS -->
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