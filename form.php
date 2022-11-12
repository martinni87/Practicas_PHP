<?php
    $button_pressed = $_GET["button_pressed"]; //Puede ser insertar o editar
    $dni = $_GET["dni"]; //Paso valor por URL

    //Atributos para PDO
    $hostdbname = 'mysql:host=localhost;dbname=universidad';
    $username = 'root';
    $password = '';

    //Hacemos un try-catch para capturar errores en caso de que la conexión falle de alguna manera.
    try{
        //Creando conexión a Base de datos
        $con = new PDO($hostdbname,$username,$password,array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8')); 
        $con -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Vaciado de filtro cuando se presiona reset. Todos los botones son tipo submit, pero su funcionamiento lo definimos según el name.
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(isset($_POST['cancel'])){
                $_POST = [];
                //echo 'Reset button pressed<br/>'; // Para debug, con esto vemos un mensaje cuando se presiona el botón reset
            }
        }

        //Creamos dos array que recibirán los datos que el usuario introduzca en las celdas.
        $sql_columns = array();
        $sql_values = array();
        //Creamos un array que parametrizará los datos introducidos para añadirlos a la query
        $parametros = array();

        //Si está seteado, lo añadimos a los values de la query y lo parametrizamos.
        if (isset($_POST['dni']) && !empty($_POST['dni'])){
            $sql_columns[] = 'dni';
            $sql_values[] = ':dni';
            $parametros[':dni'] = $_POST['dni'];
        }
        if (isset($_POST['nombre']) && !empty($_POST['nombre'])){
            $sql_columns[] = 'nombre';
            $sql_values[] = ':nombre';
            $parametros[':nombre'] = $_POST['nombre'];
        }
        if (isset($_POST['apellido_1']) && !empty($_POST['apellido_1'])){
            $sql_columns[] = 'apellido_1';
            $sql_values[] = ':apellido_1';
            $parametros[':apellido_1'] = $_POST['apellido_1'];
        }
        if (isset($_POST['apellido_2']) && !empty($_POST['apellido_2'])){
            $sql_columns[] = 'apellido_2';
            $sql_values[] = ':apellido_2';
            $parametros[':apellido_2'] = $_POST['apellido_2'];
        }
        if (isset($_POST['localidad']) && !empty($_POST['localidad'])){
            $sql_columns[] = 'localidad';
            $sql_values[] = ':localidad';
            $parametros[':localidad'] = $_POST['localidad'];
        }
        if (isset($_POST['fecha_nacimiento']) && !empty($_POST['fecha_nacimiento'])){
            $sql_columns[] = 'fecha_nacimiento';
            $sql_values[] = ':fecha_nacimiento';
            $parametros[':fecha_nacimiento'] = $_POST['fecha_nacimiento'];
        }

        //Query si se selecciona nuevo alumno
        if (isset($_POST["Insertar"])){
            $sql = 'INSERT INTO alumno (';
            $separator = ",";

            //Concatenamos para construir la query completa
            $sql .= implode($separator,$sql_columns);
            $sql .= ') VALUES (';
            $sql .= implode($separator, $sql_values);
            $sql .= ')';

            try{
                //Statement prepare & execute. Fallará en caso de que el dni (unique & primary key) ya exista.
                $stmt = $con -> prepare($sql);
                $stmt->execute($parametros);
            }
            catch(Exception $e){
                echo 'Error: El dni introducido ya existe.';
            }
            
        }
        //Carga de datos si se selecciona editar
        else if ($button_pressed == "Editar"){
            $sql = 'SELECT dni,nombre,apellido_1,apellido_2,localidad,fecha_nacimiento FROM alumno WHERE dni = '.$dni;
            $stmt = $con -> prepare($sql);
            $stmt->execute();
            $_POST = $stmt -> fetch(); //Sobreescribo $_POST para mostrar los valores en cada celda con el resultado de la query
        }

        if (isset($_POST["Editar"])){
            $dni = $_POST["dni"];
            $nombre = $_POST["nombre"];
            $apellido_1 = $_POST["apellido_1"];
            $apellido_2 = $_POST["apellido_2"];
            $localidad = $_POST["localidad"];
            $fecha_nacimiento = $_POST["fecha_nacimiento"];
            $sql = `UPDATE alumno
                    SET nombre = $nombre, apellido_1 = $apellido_1, apellido_2 = $apellido_2,
                    localidad = $localidad, fecha_nacimiento = $fecha_nacimiento
                    WHERE dni =  $dni`;

            
        }

    //Si try falla, se lanza excepción PDO
    }catch(PDOException $e){
        echo 'Error en la conexión a la BD: ' . $e -> getMessage();
    }
    echo $sql;
?>

<!-- Cabecera del documento HTML -->
<!DOCTYPE html>
<html lang='es'>
<head>
    <meta charset='UTF-8'>
    <meta name='author' content='Martín Antonio Córdoba Getar'>
    <meta name='description' content='Práctica de Desarrollo de Interfaces 2ºDAM EFA El Campico'>
    <meta name='keywords' content='HTML, PHP, DAM, Ejercicios Desarrollo de Interfaces, formulario, form'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Práctica 1 Desarrollo de Interfaces - FORM</title>
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
    <h3>Práctica 1.6 DI Form</h3>

    <p><a href="./index.php">Volver al listado</a></p>

    <!-- Formulario genérico -->
    <?php
    $valor_boton = ($button_pressed=="Insertar") ? "Insertar" : "Modificar";
    ?>

    <form action='./form.php' method='post'>
        <fieldset>
            <legend>Formulario Alumno</legend>
            <label for='dni'>DNI:</label><input type='text' name='dni' id='dni' placeholder='01234567A' title='Escribe un DNI' value='<?php echo $_POST['dni'] ?>'><br/>
            <label for='nombre'>Nombre:</label><input type='text' name='nombre' id='nombre' placeholder='Pep' title='Escribe un nombre' value='<?php echo $_POST['nombre'] ?>'><br/>
            <label for='apellido_1'>Primer apellido:</label><input type='text' name='apellido_1' id='apellido_1' placeholder='Martinez' title='Escribe el primer apellido' value='<?php echo $_POST['apellido_1'] ?>'><br/>
            <label for='apellido_2'>Segundo apellido:</label><input type='text' name='apellido_2' id='apellido_2' placeholder='Godoy' title='Escribe el segundo apellido' value='<?php echo $_POST['apellido_2'] ?>'><br/>
            <label for='localidad'>Localidad:</label><input type='text' name='localidad' id='licalidad' placeholder='Elche' title='Escribe una localidad' value='<?php echo $_POST['localidad'] ?>'><br/>
            <label for='fecha_nacimiento'>F. Nacimiento:</label><input type='date' name='fecha_nacimiento' id='fecha_nacimiento' placeholder='20/05/1991' title='Escribe una fecha en formato DD/MM/AAAA' value='<?php echo $_POST['fecha_nacimiento'] ?>'><br/>
            <?php echo $valor_boton; ?>
            <button type='submit' name='<?php echo $valor_boton ?>' id='<?php echo $valor_boton ?>'><?php echo $valor_boton ?></button> <!-- Botón insertar/modificar -->
            <button type='submit' name='cancel' id='cancel'>Cancelar</button> <!-- Si aplico type submit en lugar de reset puedo variar el valor según se presiona enviar o limpiar de forma que con isset($_POST['reset'] pueda aplicar $_POST = [] y vaciar los filtros -->
        </fieldset>
    </form>

</body>

</html>