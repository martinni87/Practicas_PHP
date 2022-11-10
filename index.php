<?php
    //Atributos para PDO
    $hostdbname = 'mysql:host=localhost;dbname=universidad';
    $username = 'root';
    $password = '';

    //Hacemos un try-catch para capturar errores en caso de que la conexión falle de alguna manera.
    try{
        //Para debug
        // foreach ($_POST as $key => $value) {
        //     echo $key . ' = ' . $value . '<br/>';
        // }
        // echo $sql;

        // //Variables introducidas por el usuario. Lo heredamos del método POST
         $filtros = $_POST;   
        //Creando conexión a Base de datos
        $con = new PDO($hostdbname,$username,$password,array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8')); 
        $con -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Vaciado de filtro cuando se presiona uno de los botones del formulario y se trata del reset.
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(isset($_POST['reset'])){
                $_POST = [];
                //echo 'Reset button pressed<br/>'; // Para debug, con esto vemos un mensaje cuando se presiona el botón reset
            }
        }

        //Array que recoge parámetros sólo si el usuario ha utilizado un determinado filtro.
        $parametros = array();

        //Creamos una variable que recibirá la parte de filtros a aplicar en la query
        $sql_filtros = '';

        //Condiciones de filtros. Se añaden si el usuario indica un valor en un filtro y son acumulativos. Definen $sql y $parametros
        if (isset($_POST['dni']) && !empty($_POST['dni'])){
            $sql_filtros .= ' AND dni LIKE :dni';
            $parametros[':dni'] = '%'.$_POST['dni'].'%'; //No hago que sea resultado exacto porque un usuario puede querer ver todos los dnis que tienen por ejemplo 111.
        }
        if (isset($_POST['nombre']) && !empty($_POST['nombre'])){
            $sql_filtros .= ' AND nombre LIKE :nombre';
            $parametros[':nombre'] = '%'.$_POST['nombre'].'%';
        }
        if (isset($_POST['localidad']) && !empty($_POST['localidad'])){
            $sql_filtros .= ' AND localidad LIKE :localidad';
            $parametros[':localidad'] = '%'.$_POST['localidad'].'%';
        }
        if (isset($_POST['fecha_nacimiento']) && !empty($_POST['fecha_nacimiento'])){
            $sql_filtros .= ' AND fecha_nacimiento > :fecha_nacimiento';
            $parametros[':fecha_nacimiento'] = $_POST['fecha_nacimiento'];
        }

        //Terminamos de construir la query. Si se presiona submit mostramos datos, si no, no se muestra nada.
        if(isset($_POST['submit'])){
            $sql = 'SELECT dni, nombre, apellido_1, apellido_2, localidad, fecha_nacimiento FROM alumno WHERE true' . $sql_filtros;
            //Definimos el stmt con prepare y parametrizamos la query
            $stmt = $con -> prepare($sql);
            $stmt->execute($parametros);
        }
        //$sql .= $sql_filtros;
        // //Hacemos un segundo SELECT para saber la cantidad total de registros con los filtros aplicados
        // $sql = 'SELECT COUNT(*) FROM alumno WHERE true';
        // $sql .= $sql_filtros;
        // if ($_POST['registros'] != 'Todos'){
        //     $sql .= ' LIMIT ' . $regini . ',' . $regfin;
        // }
        // //Definimos un nuevo stmt con prepare y parametrizamos la query
        // $stmt = $con -> prepare($sql);
        // $stmt->execute($parametros);

    //No cierro la llave del try aquí, va más abajo con el catch para darle continuidad y que no de error de catch sin try.
?>
<!-- Cabecera del documento HTML -->
<!DOCTYPE html>
<html lang='es'>
<head>
    <meta charset='UTF-8'>
    <meta name='author' content='Martín Antonio Córdoba Getar'>
    <meta name='description' content='Práctica de Desarrollo de Interfaces 2ºDAM EFA El Campico'>
    <meta name='keywords' content='HTML, PHP, DAM, Ejercicios Desarrollo de Interfaces'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
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
    <h3>Práctica 1.5 DI</h3>

    <form action='index.php' method='post'>
        <fieldset>
            <legend>Filtros de búsqueda</legend>
            <label for='dni'>DNI:</label><input type='text' name='dni' id='dni' placeholder='01234567A' title='Escribe un DNI' value='<?php echo $_POST['dni'] ?>'>
            <label for='nombre'>Nombre:</label><input type='text' name='nombre' id='nombre' placeholder='Pep' title='Escribe un nombre' value='<?php echo $_POST['nombre'] ?>'>
            <label for='localidad'>Localidad:</label><input type='text' name='localidad' id='licalidad' placeholder='Elche' title='Escribe una localidad' value='<?php echo $_POST['localidad'] ?>'>
            <label for='fecha_nacimiento'>F. Nacimiento:</label><input type='date' name='fecha_nacimiento' id='fecha_nacimiento' placeholder='20/05/1991' title='Escribe una fecha en formato DD/MM/AAAA' value='<?php echo $_POST['fecha_nacimiento'] ?>'>
            <button type='submit' name='submit' id='submit'>Enviar</button>
            <button type='submit' name='reset' id='reset'>Limpiar</button> <!-- Si aplico type submit en lugar de reset puedo variar el valor según se presiona enviar o limpiar de forma que con isset($_POST['reset'] pueda aplicar $_POST = [] y vaciar los filtros -->
        </fieldset>
    <?php 
    if (isset($_POST['submit'])){
        echo "
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
        </table>
        <br/>
            <button type='submit' name='primera' id='primera'><<</button>
            <button type='submit' name='anterior' id='anterior'><</button>
            <input type='text' name='pagina' id='pagina' value='<?php echo $pagina ?>' disabled='false'>
            <button type='submit' name='siguiente' id='siguiente'>></button>
            <button type='submit' name='ultima' id='ultima'>>></button>
            <label for='registros'>Registros por página:<select name='registros' id='registros' value='<?php echo $registros ?>'>
                <option value='<?php echo $registros ?> ' selected hidden><?php echo $registros ?></option>
                <option value='10'>10</option>
                <option value='15'>15</option>
                <option value='20'>20</option>
                <option value='Todos'>Todos</option>
            </select>
            <button type='submit' name='mostrar' id='mostrar'>Mostrar</button>
            '<p>Núm. Registros: '. $numreg . '. Página ' . $paginaActual . '/' . $paginasTotales . '</p>'
        ";
    }
    ?>
    </form>
    <?php
        //Si try falla, se lanza excepción PDO
        }catch(PDOException $e){
            echo 'Error en la conexión a la BD: ' . $e -> getMessage();
        }
    ?>
</body>
</html>