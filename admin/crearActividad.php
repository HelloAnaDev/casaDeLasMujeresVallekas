<?php 
include 'slidebar.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $accesible = $_POST['accesible'];
    $fecha = $_POST['fecha'];
    $precio = $_POST['precio'];
    $aforoMin = $_POST['aforoMin'];
    $aforoMax = $_POST['aforoMax'];
    $publico = $_POST['publico'];
    $activo = $_POST['activo'];
    $sql = "INSERT INTO eventos (titulo, descripcion, accesible,fecha, precio, aforoMin, aforoMax, publico, activo) VALUES (:titulo, :descripcion, :accesible, :fecha, :precio, :aforoMin, :aforoMax, :publico, :activo)";

    require '../config/db.php';

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':titulo'=> $titulo,
        ':descripcion' => $descripcion,
        ':accesible'=>$accesible,
        ':fecha'=>$fecha,
        ':precio'=>$precio,
        ':aforoMin'=>$aforoMin,
        ':aforoMax'=>$aforoMax,
        ':publico'=>$publico,
        ':activo'=>$activo,
        ]);
    header('Location: gestionAgenda.php?exito=1');
    exit;
}
?>

<form action="" method="POST">
<fieldset>
<legend>Crear actividad</legend>

    
<!-- titulo -->
    <label for="titulo">Título</label>
    <input type="text" id="titulo" name="titulo">
    
<!-- descripcion -->
    <label for="descripcion">¿De qué trata?</label>
    <textarea name="descripcion" id="descripcion"></textarea>

<!-- accesible -->
    <label for="accesible">¿Es totalmente accesible esta actividad? Escribe Sí , si no hay ningún matiz importante, en caso contrario, escribe los obstáculos que puedan encontrarse (terreno irregular, dificil acceso para carritos de bebé o sillas de ruedas...)</label>
    <input type="text" id="accesible" name="accesible">
    
<!-- fecha hora -->
    <label for="fecha">Fecha y hora</label>
    <input type="datetime-local" id="fecha" name="fecha" >
    
<!-- precio -->
    <label for="precio">Precio (En caso de ser gratuito, rellenar con "0")</label>
    <input type="number" id="precio" name="precio" >

<!-- aforo minimo -->
    <label for="aforoMin">Aforo mínimo</label>
    <input type="number" id="aforoMin" name="aforoMin">

<!-- aforo maximo -->
    <label for="aforoMax">Aforo máximo</label>
    <input type="number" id="aforoMax" name="aforoMax">

<!-- publico -->
    <p>Esta actividad es de carácter</p>
    
    <input type="radio" name="publico" value="1" id="publico"> 
    <label for="publico">Público</label>
    
    <input type="radio" name="publico" value="0" id="privado">
    <label for="privado">Privado (solo administradoras)</label>

    <!-- activo -->
    <p>¿Mostrar actividad para permitir ya apuntarse a las participantes, u ocultar esta actividad por ahora?</p>
    
    <input type="radio" name="activo" value="1" id="mostrar"> 
    <label for="mostrar">Mostrar</label>
    
    <input type="radio" name="activo" value="0" id="ocultar">
    <label for="ocultar">Ocultar</label>


    <button type="submit">Crear actividad</button>
</fieldset></form>
</main>

<?php include 'footer.php'; ?>

<script src="interaccion.js"></script>
</body>
</html>
