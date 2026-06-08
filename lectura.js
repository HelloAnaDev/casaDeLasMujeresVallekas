document.addEventListener('DOMContentLoaded', () => {
    
    // --- LÓGICA DEL BOTÓN ME GUSTA ---
    const btnLike = document.getElementById('btnLikeLectura');
    const contadorLikes = document.getElementById('contadorLikesLectura');

    if (btnLike) {
        btnLike.addEventListener('click', () => {
            const idMemoria = btnLike.getAttribute('data-id');
            let likesActuales = parseInt(contadorLikes.textContent);
            let accion = '';
            
            if (btnLike.classList.contains('like-activo')) {
                // QUITAR LIKE
                contadorLikes.textContent = Math.max(0, likesActuales - 1);
                btnLike.classList.remove('like-activo');
                accion = 'unlike';
            } else {
                // DAR LIKE
                contadorLikes.textContent = likesActuales + 1;
                btnLike.classList.add('like-activo');
                accion = 'like';
            }
            
            // Llamada silenciosa al servidor indicando la acción
            fetch('sumar_like.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id: idMemoria, accion: accion })
            })
            .then(res => res.json())
            .then(data => {
                if(data.status === 'success') {
                    contadorLikes.textContent = data.likes; // Sincroniza con la base de datos
                }
            })
            .catch(err => console.error('Error procesando like:', err));
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