document.addEventListener('DOMContentLoaded', () => {
    
    // --- LÓGICA DEL BOTÓN ME GUSTA Y STICKYS ---
    const btnLike = document.getElementById('btnLikeLectura');
    const contadorLikes = document.getElementById('contadorLikesLectura');
    const btnStickyLike = document.getElementById('btnStickyLike');
    const iconoStickyCorazon = document.getElementById('iconoStickyCorazon');
    const textoStickyLike = document.getElementById('textoStickyLike');

    // Función para actualizar ambos botones visualmente
    function actualizarVistaLike(esLike) {
        if (esLike) {
            btnLike.classList.add('like-activo');
            textoStickyLike.textContent = "Quitar me gusta";
            iconoStickyCorazon.style.fill = 'currentColor'; // Relleno
        } else {
            btnLike.classList.remove('like-activo');
            textoStickyLike.textContent = 'Dar "me gusta"';
            iconoStickyCorazon.style.fill = 'none'; // Vacío
        }
    }

    function alternarLike() {
        const idMemoria = btnLike.getAttribute('data-id');
        let likesActuales = parseInt(contadorLikes.textContent);
        let accion = '';
        
        if (btnLike.classList.contains('like-activo')) {
            // QUITAR LIKE
            contadorLikes.textContent = Math.max(0, likesActuales - 1);
            actualizarVistaLike(false);
            accion = 'unlike';
        } else {
            // DAR LIKE
            contadorLikes.textContent = likesActuales + 1;
            actualizarVistaLike(true);
            accion = 'like';
        }
        
        // Llamada silenciosa al servidor
        fetch('sumar_like.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id: idMemoria, accion: accion })
        })
        .then(res => res.json())
        .then(data => {
            if(data.status === 'success') {
                contadorLikes.textContent = data.likes;
            }
        })
        .catch(err => console.error('Error procesando like:', err));
    }

    // Asignar el evento a ambos botones de like
    if (btnLike) {
        btnLike.addEventListener('click', alternarLike);
    }
    if (btnStickyLike) {
        btnStickyLike.addEventListener('click', alternarLike);
    }

    // Lógica para deslizar hasta los comentarios (Solo móvil)
    const btnStickyComentarios = document.getElementById('btnStickyComentarios');
    if (btnStickyComentarios) {
        btnStickyComentarios.addEventListener('click', () => {
            const zonaComentarios = document.getElementById('formComentarioLectura');
            if(zonaComentarios) {
                zonaComentarios.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    }

    // --- LÓGICA DEL CARRUSEL MODERNO (IMAGEN ÚNICA) ---
    // La variable listaFotos viene del PHP (json_encode)
    if (typeof listaFotos !== 'undefined' && listaFotos.length > 0) {
        let indiceActual = 0;
        const totalFotos = listaFotos.length;
        
        const fotoCentro = document.getElementById('fotoCentroLectura');
        const contadorTexto = document.getElementById('contadorCarruselLectura');
        const btnAnt = document.getElementById('btnAnteriorLectura');
        const btnSig = document.getElementById('btnSiguienteLectura');

        function actualizarCarrusel() {
            // Actualizar foto central
            fotoCentro.src = "images/memorias/" + listaFotos[indiceActual];
            
            if (contadorTexto) {
                contadorTexto.textContent = `${indiceActual + 1} / ${totalFotos}`;
            }
            
            // Si solo hay 1 foto, ocultamos las flechas por completo
            if (totalFotos <= 1) {
                if(btnAnt) btnAnt.style.display = "none";
                if(btnSig) btnSig.style.display = "none";
            }
        }

        if(btnAnt) {
            btnAnt.addEventListener('click', () => {
                indiceActual = (indiceActual === 0) ? totalFotos - 1 : indiceActual - 1;
                actualizarCarrusel();
            });
        }

        if(btnSig) {
            btnSig.addEventListener('click', () => {
                indiceActual = (indiceActual === totalFotos - 1) ? 0 : indiceActual + 1;
                actualizarCarrusel();
            });
        }

        // Inicializar la primera foto al cargar
        actualizarCarrusel();
    }
});