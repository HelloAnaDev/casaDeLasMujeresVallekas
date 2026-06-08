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