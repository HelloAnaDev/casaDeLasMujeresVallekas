document.addEventListener('DOMContentLoaded', () => {
    const contenedorMuro = document.getElementById('contenedorMuro');
    const buscador = document.getElementById('buscadorMemorias');
    const filtro = document.getElementById('filtroCategoria');
    let todasLasMemorias = [];

    // 1. Pedir los datos a la base de datos
    fetch('backend/api/getMemorias.php')
        .then(res => {
            if (!res.ok) throw new Error("Fallo al conectar con el servidor");
            return res.json();
        })
        .then(data => {
            if (data.error) throw new Error(data.error);
            todasLasMemorias = data;
            pintarMuro(todasLasMemorias);
        })
        .catch(error => {
            contenedorMuro.innerHTML = `<p style="color:#d32f2f; text-align:center; padding: 40px; font-weight:bold;">⚠️ Error: ${error.message}</p>`;
        });

    // 2. Función que dibuja el muro con SVG Nativos y Cuadrícula
    function pintarMuro(datos) {
        contenedorMuro.innerHTML = '<div class="grid-tarjetas"></div>';
        const grid = contenedorMuro.querySelector('.grid-tarjetas');
        
        if (datos.length === 0) {
            contenedorMuro.innerHTML = '<p style="text-align:center; padding: 40px; font-size: 1.2rem; color: #555;">No hay publicaciones.</p>';
            return;
        }

        datos.forEach(mem => {
            const fechaValida = mem.fecha ? mem.fecha : '2026-01-01';
            const fechaDate = new Date(fechaValida);
            const mes = fechaDate.toLocaleString('es-ES', { month: 'long' }).toUpperCase();
            const anio = fechaDate.getFullYear();
            const mesAnioNormal = `${mes} ${anio}`; 

            const numComentarios = mem.comentarios ? mem.comentarios.length : 0;
            const numLikes = mem.likes || 0;
            const cat = mem.categoria || 'LA CASA';
            
            // Si hay foto, la usamos de fondo. Si no, usamos color transparente corporativo.
            const fotoReal = mem.galeria_fotos.length > 0 ? `images/memorias/${mem.galeria_fotos[0]}` : '';
            const bgStyle = fotoReal ? `background-image: url('${fotoReal}');` : `background-color: rgba(196, 177, 202, 0.8);`;
            
            // Códigos SVG Nativos
            const iconoCorazonSVG = `<svg class="icono-svg corazon" viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" style="transition: all 0.2s ease;"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>`;
            const iconoBocadilloSVG = `<svg class="icono-svg" viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>`;

            const wrapper = document.createElement('div');
            wrapper.className = 'item-muro';
            
            wrapper.innerHTML = `
                <div class="titulo-mes-tarjeta-lineas"><span>${mesAnioNormal}</span></div>
                <a href="lectura.php?id=${mem.idMemoria}" class="tarjeta-muro-overlay" style="${bgStyle}">
                    <div class="tarjeta-overlay-blanco">
                        <h3>${mem.titulo}</h3>
                        <p>${mem.descripcion}</p>
                        <div class="interacciones-tarjeta-bottom">
                            <button class="btn-like-muro" data-id="${mem.idMemoria}" data-liked="false">
                                ${iconoCorazonSVG} <span><span class="contador-likes">${numLikes}</span> me gusta</span>
                            </button>
                            <span class="separador-muro"></span>
                            <span class="comentarios-muro">
                                ${iconoBocadilloSVG} <span>${numComentarios} comentarios</span>
                            </span>
                            <span class="separador-muro"></span>
                            <span class="etiqueta-categoria-muro">${cat}</span>
                        </div>
                    </div>
                </a>
            `;

            const btnLike = wrapper.querySelector('.btn-like-muro');
            
            // Comprobar estado previo guardado en el dispositivo
            let likesLocales = JSON.parse(localStorage.getItem('likes_dispositivo')) || [];
            if (likesLocales.includes(mem.idMemoria.toString())) {
                btnLike.setAttribute('data-liked', 'true');
                const icono = btnLike.querySelector('.corazon');
                if(icono) {
                    icono.style.fill = '#d12c5b'; 
                    icono.style.stroke = '#d12c5b';
                }
            }

            btnLike.addEventListener('click', (evento) => {
                evento.preventDefault(); 
                darLike(mem.idMemoria, btnLike);
            });

            grid.appendChild(wrapper);
        });
    }

    // 3. Filtros y Buscador
    function aplicarFiltros() {
        const textoBusqueda = buscador.value.toLowerCase().trim();
        const categoriaFiltro = filtro.value;

        const resultados = todasLasMemorias.filter(mem => {
            const coincideTexto = mem.titulo.toLowerCase().includes(textoBusqueda) || 
                                  mem.descripcion.toLowerCase().includes(textoBusqueda);
            const coincideCategoria = (categoriaFiltro === 'TODO') || (mem.categoria === categoriaFiltro);
            
            return coincideTexto && coincideCategoria;
        });

        pintarMuro(resultados);
    }

    buscador.addEventListener('input', aplicarFiltros);
    filtro.addEventListener('change', aplicarFiltros);

    // 4. Función de Like (Visual + Real a Base de Datos)
    function darLike(idMemoria, btnElement) {
        const contadorSpan = btnElement.querySelector('.contador-likes');
        const iconoCorazon = btnElement.querySelector('.corazon');
        let likesActuales = parseInt(contadorSpan.textContent);
        let accion = 'like';

        if (btnElement.getAttribute('data-liked') === 'true') {
            // QUITAR LIKE
            contadorSpan.textContent = Math.max(0, likesActuales - 1);
            btnElement.setAttribute('data-liked', 'false');
            if(iconoCorazon) {
                iconoCorazon.style.fill = 'none';
                iconoCorazon.style.stroke = 'currentColor';
            }
            accion = 'unlike';
        } else {
            // DAR LIKE
            contadorSpan.textContent = likesActuales + 1;
            btnElement.setAttribute('data-liked', 'true');
            if(iconoCorazon) {
                iconoCorazon.style.fill = '#d12c5b'; 
                iconoCorazon.style.stroke = '#d12c5b';
                iconoCorazon.style.transform = 'scale(1.15)'; 
                setTimeout(() => iconoCorazon.style.transform = 'scale(1)', 200);
            }
        }

        // Llamada al servidor
        fetch('sumar_like.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id: idMemoria, accion: accion })
        })
        .then(res => res.json())
        .then(data => {
            if(data.status === 'success') {
                contadorSpan.textContent = data.likes;
                
                // Actualizar registro del dispositivo
                let likesGuardados = JSON.parse(localStorage.getItem('likes_dispositivo')) || [];
                if (accion === 'like') {
                    likesGuardados.push(idMemoria.toString());
                } else {
                    likesGuardados = likesGuardados.filter(id => id !== idMemoria.toString());
                }
                localStorage.setItem('likes_dispositivo', JSON.stringify(likesGuardados));
            }
        })
        .catch(err => console.error('Error con el like:', err));
    }
});