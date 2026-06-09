<?php 
$pagina = 'casaEnMarcha';
include 'header.php'; 
?>

<main>
    <div class="cabeceraMuro">
        <div class="contenedorBuscadorMuro">
            <input type="text" id="buscadorMemorias" class="inputBuscador" placeholder="Buscar actividad por título o contenido...">
        </div>
        
        <div class="contenedorFiltro">
            <label for="filtroCategoria">Filtrar por...</label>
            <select id="filtroCategoria">
                <option value="TODO">Todo</option>
                <option value="LA CASA">La Casa</option>
                <option value="VARIOS">Varios</option>
            </select>
        </div>
    </div>

    <div id="contenedorMuro">
        </div>
</main>

<?php include 'footer.php'; ?>

<script src="memorias.js?v=3"></script>

</body>
</html>