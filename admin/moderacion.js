document.addEventListener('DOMContentLoaded', () => {
    const listaPendientes = document.getElementById('listaPendientes');

    cargarComentarios();

    function cargarComentarios() {
        fetch('getComentariosPendientes.php')
            .then(res => res.json())
            .then(datos => {
                renderizarComentarios(datos);
            })
            .catch(err => {
                console.error("Error al obtener comentarios:", err);
                if (listaPendientes) {
                    listaPendientes.innerHTML = '<p style="color: red;">Error al conectar con el servidor.</p>';
                }
            });
    }

    function renderizarComentarios(comentarios) {
        if (!listaPendientes) return;
        
        listaPendientes.innerHTML = '';

        if (comentarios.length === 0) {
            listaPendientes.innerHTML = '<p class="mensajeVacio">No hay comentarios pendientes de revisión. ¡Gracias por estar pendiente!</p>';
            return;
        }

        comentarios.forEach(comentario => {
            const card = document.createElement('div');
            card.classList.add('tarjetaModeracion');
            card.id = `tarjeta-${comentario.idComentario}`; 

            const [fechaPart] = comentario.fecha.split(' ');
            const [y, m, d] = fechaPart.split('-');
            const fechaEsp = `${d}/${m}/${y}`;

            card.innerHTML = `
                <div class="headerModeracion">
                <span class="actividadLink">${comentario.titulo_memoria}</span>
                <h3>${comentario.nombre} <small>(${fechaEsp})</small></h3>
                </div>
                <div class="cuerpoModeracion">
                    <p>"${comentario.texto}"</p>
                </div>
                <div class="accionesModeracion">
                    <button class="btnAdmin btnAprobar" onclick="gestionar(${comentario.idComentario}, 1)">APROBAR</button>
                    <button class="btnAdmin btnRechazar" onclick="gestionar(${comentario.idComentario}, 2)">RECHAZAR</button>
                </div>
            `;
            listaPendientes.appendChild(card);
        });
    }
});

function gestionar(idComentario, nuevoEstado) {
    const accion = nuevoEstado === 1 ? 'aprobar' : 'rechazar';
    
    if (confirm(`¿Estás segura de que quieres ${accion} este comentario?`)) {
        
        const datos = new FormData();
        datos.append('idComentario', idComentario);
        datos.append('nuevoEstado', nuevoEstado);

        fetch('gestionarComentario.php', {
            method: 'POST',
            body: datos
        })
        .then(res => res.json())
        .then(respuesta => {
            if (respuesta.status === 'success') {
                const tarjeta = document.getElementById(`tarjeta-${idComentario}`);
                if (tarjeta) tarjeta.remove();

                const lista = document.getElementById('listaPendientes');
                if (lista && lista.children.length === 0) {
                    lista.innerHTML = '<p class="mensajeVacio">No hay comentarios pendientes de revisión. ¡Buen trabajo!</p>';
                }
            } else {
                alert('Atención: ' + (respuesta.message || 'Error desconocido al actualizar.'));
            }
        })
        .catch(error => {
            console.error("Error en la gestión:", error);
            alert('Error de conexión. Revisa la consola para más detalles.');
        });
    }
}