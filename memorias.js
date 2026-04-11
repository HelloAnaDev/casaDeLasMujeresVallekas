document.addEventListener('DOMContentLoaded', () => {
    let todasLasMemorias = []; 
    let listaMemorias = [];    
    let indiceMemoria = 0;
    let indiceFoto = 0;

    const tituloMes = document.getElementById('tituloMes');
    const fotoPrincipal = document.getElementById('fotoPrincipal');
    const contadorFotos = document.getElementById('contadorFotos');
    const textoMemoria = document.getElementById('textoMemoria'); 
    const btnMesAnterior = document.getElementById('btnMesAnterior');
    const btnMesSiguiente = document.getElementById('btnMesSiguiente');
    const btnFotoAnterior = document.getElementById('btnFotoAnterior');
    const btnFotoSiguiente = document.getElementById('btnFotoSiguiente');
    const buscador = document.getElementById('buscadorMemorias');
    const contenedorResultados = document.getElementById('contenedorResultados');
    const vistaDetalle = document.getElementById('vistaDetalle');
    const columnaDerecha = document.getElementById('columnaDerecha');

    fetch('backend/api/getMemorias.php')
        .then(respuesta => respuesta.json())
        .then(datos => {
            if (datos.length === 0) {
                tituloMes.textContent = "No hay actividades publicadas.";
                return;
            }
            todasLasMemorias = datos; 
            listaMemorias = [...todasLasMemorias]; 
            
            indiceMemoria = listaMemorias.length - 1;
            pintarMemoria();
        });

    function pintarMemoria() {
        const memoria = listaMemorias[indiceMemoria];
            
        tituloMes.textContent = memoria.titulo;
            
        if (textoMemoria) {
            textoMemoria.textContent = memoria.descripcion; 
        }

        const inputIdMemoria = document.getElementById('idMemoriaActual');
        if (inputIdMemoria && memoria.idMemoria) {
            inputIdMemoria.value = memoria.idMemoria; 
        }

        indiceFoto = 0;
        pintarFoto();
        pintarComentarios();
    }

    function pintarFoto() {
        const memoria = listaMemorias[indiceMemoria];
        const galeria = memoria.galeria_fotos;
        const total = galeria.length;

        if (total > 0) {
            fotoPrincipal.src = `images/memorias/${galeria[indiceFoto]}`;
            contadorFotos.textContent = `${indiceFoto + 1} / ${total}`;

            let idxAnt = (indiceFoto === 0) ? total - 1 : indiceFoto - 1;
            document.getElementById('fotoAnterior').src = `images/memorias/${galeria[idxAnt]}`;

            let idxSig = (indiceFoto === total - 1) ? 0 : indiceFoto + 1;
            document.getElementById('fotoSiguiente').src = `images/memorias/${galeria[idxSig]}`;
        }
    }

    function pintarComentarios() {
        const memoria = listaMemorias[indiceMemoria];
        const muro = document.getElementById('muroComentarios');
        
        muro.innerHTML = '';

        if (memoria.comentarios && memoria.comentarios.length > 0) {
            memoria.comentarios.forEach(comentario => {
                const [soloFecha] = comentario.fecha.split(' '); 
                const [anio, mes, dia] = soloFecha.split('-');   
                const fechaEspana = `${dia}/${mes}/${anio}`;
                
                const divComentario = document.createElement('div');
                divComentario.classList.add('tarjetaComentario');
                
                divComentario.innerHTML = `
                    <p><strong>${comentario.nombre}</strong> <span class="fechaMini">${fechaEspana}</span></p>
                    <p>${comentario.texto}</p>
                `;
                muro.appendChild(divComentario);
            });
        } else {
            muro.innerHTML = `
                <div class="comentarioVacio">
                    <p>Aún no hay comentarios, ¡Anímate a compartir tus impresiones!</p>
                </div>
            `;
        }
    }

    btnMesSiguiente.addEventListener('click', () => {
        if (indiceMemoria < listaMemorias.length - 1) {
            indiceMemoria++;
            pintarMemoria();
        }
    });

    btnMesAnterior.addEventListener('click', () => {
        if (indiceMemoria > 0) {
            indiceMemoria--;
            pintarMemoria();
        }
    });

    btnFotoSiguiente.addEventListener('click', () => {
        const galeria = listaMemorias[indiceMemoria].galeria_fotos;
        if (indiceFoto < galeria.length - 1) {
            indiceFoto++;
        } else {
            indiceFoto = 0;
        }
        pintarFoto();
    });

    btnFotoAnterior.addEventListener('click', () => {
        const galeria = listaMemorias[indiceMemoria].galeria_fotos;
        if (indiceFoto > 0) {
            indiceFoto--;
        } else {
            indiceFoto = galeria.length - 1; 
        }
        pintarFoto();
    });

    if (buscador) {
        buscador.addEventListener('input', (evento) => {
            const textoBuscado = evento.target.value.toLowerCase().trim();
            
            if (textoBuscado === '') {
                contenedorResultados.classList.add('oculto');
                vistaDetalle.classList.remove('oculto');
                columnaDerecha.classList.remove('oculto');
                
                listaMemorias = [...todasLasMemorias];
                indiceMemoria = listaMemorias.length - 1;
                pintarMemoria();
                return;
            }

            const resultados = todasLasMemorias.filter(memoria => {
                const coincideTitulo = memoria.titulo.toLowerCase().includes(textoBuscado);
                const coincideDescripcion = memoria.descripcion.toLowerCase().includes(textoBuscado);
                return coincideTitulo || coincideDescripcion;
            });

            vistaDetalle.classList.add('oculto');
            columnaDerecha.classList.add('oculto');
            contenedorResultados.classList.remove('oculto');
            contenedorResultados.innerHTML = '';

            if (resultados.length > 0) {
                resultados.forEach(memoria => {
                    const divTarjeta = document.createElement('div');
                    divTarjeta.classList.add('tarjetaResultado');

                    const foto = memoria.galeria_fotos.length > 0 ? `images/memorias/${memoria.galeria_fotos[0]}` : 'images/logoVector.webp';

                    divTarjeta.innerHTML = `
                        <img src="${foto}" class="miniaturaResultado" alt="Miniatura de ${memoria.titulo}">
                        <div class="infoResultado">
                            <h4>${memoria.titulo}</h4>
                            <p>${memoria.descripcion}</p>
                        </div>
                    `;

                    divTarjeta.addEventListener('click', () => {
                        buscador.value = ''; 
                        contenedorResultados.classList.add('oculto');
                        vistaDetalle.classList.remove('oculto');
                        columnaDerecha.classList.remove('oculto');

                        listaMemorias = [...todasLasMemorias]; 
                        indiceMemoria = listaMemorias.findIndex(m => m.idMemoria === memoria.idMemoria);
                        pintarMemoria();
                    });

                    contenedorResultados.appendChild(divTarjeta);
                });
            } else {
                contenedorResultados.innerHTML = `
                    <div class="mensajeSinResultados">
                        <p>No se encontraron actividades con esa palabra.</p>
                    </div>
                `;
            }
        });
    }
});