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
    <!-- Creamos un fragmento de código php para asignar valores a cantidad de filas y columnas -->
    <?php
        $rows = 6;
        $columns = 4;
    ?>
    <!-- Creamos una matriz (tabla) indicando el número de columnas y filas -->
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