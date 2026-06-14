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

 // --- LÓGICA DEL CARRUSEL DUAL (APILADO / DESLIZABLE) ---
    const toggleVista = document.getElementById('toggleVistaFotos');
    const galeria = document.getElementById('galeriaDinamica');
    const ayudaSwipe = document.getElementById('ayudaSwipeFotos');
    const indicadores = document.getElementById('indicadoresSwipe');
    
    if (toggleVista && galeria) {
        toggleVista.addEventListener('change', (e) => {
            if (e.target.checked) {
                // Modo Apilado
                galeria.classList.remove('modo-carrusel');
                galeria.classList.add('modo-apilado');
                ayudaSwipe.style.display = 'none';
                if(indicadores) indicadores.style.display = 'none';
            } else {
                // Modo Individual (Deslizable)
                galeria.classList.remove('modo-apilado');
                galeria.classList.add('modo-carrusel');
                ayudaSwipe.style.display = 'block';
                if(indicadores) indicadores.style.display = 'block';
            }
        });

        // Actualizar puntos al deslizar
        galeria.addEventListener('scroll', () => {
            if(galeria.classList.contains('modo-carrusel') && indicadores) {
                const scrollLeft = galeria.scrollLeft;
                const width = galeria.offsetWidth;
                const index = Math.round(scrollLeft / width);
                const dots = indicadores.querySelectorAll('.punto-swipe');
                dots.forEach((dot, i) => {
                    dot.classList.toggle('activo', i === index);
                });
            }
        });
    }