//Encabezado con menú público (escritorio y móvil)

const btnMenu = document.getElementById('btnMenu');
const menuLateral = document.getElementById('menuLateral');
const cabecera = document.querySelector('.cabecera');
const btnOcultar = document.getElementById('btnOcultar'); // Lo subo aquí arriba para agruparlo

if (btnMenu && menuLateral && cabecera && btnOcultar) {

    btnMenu.addEventListener('click', () =>{
        menuLateral.classList.toggle('activo');
    });

    let ubicacionPrincipal = window.scrollY || document.documentElement.scrollTop;
    window.addEventListener('scroll', () => {
        let desplazamientoActual = window.scrollY || document.documentElement.scrollTop;
        
        if (menuLateral && menuLateral.classList.contains('activo')){
            return;
        } 
        if (window.innerWidth >= 1327) {
            cabecera.classList.remove('oculta');
            return; 
        } 
        
        if (desplazamientoActual <= 10) {
            cabecera.classList.remove('oculta');
        } 
        else if (ubicacionPrincipal < desplazamientoActual) {
            cabecera.classList.add('oculta');
        } else {
            cabecera.classList.remove('oculta');
        }
        
        ubicacionPrincipal = desplazamientoActual;
    });
       
    btnOcultar.addEventListener('click',() =>{
        menuLateral.classList.remove('activo');
    });

} 

//Formulario contacto, enviar mensaje a mi email a través del formulario

const formContacto = document.querySelector('.formularioMensaje');

if (formContacto) { 
    const radiosMedio = document.querySelectorAll('input[name="medioPreferido"]');

    function actualizarObligatorios() {

        const inputEmail = document.getElementById('email');
        const inputTelefono = document.getElementById('telefono');
        const radioSeleccionado = document.querySelector('input[name="medioPreferido"]:checked');


        if (!inputEmail || !inputTelefono || !radioSeleccionado) return;

        if (radioSeleccionado.value === 'email') {
            inputEmail.required = true;
            inputTelefono.required = false;
        } else {
            inputTelefono.required = true;
            inputEmail.required = false;
        }
    }

    radiosMedio.forEach(radio => {
        radio.addEventListener('change', actualizarObligatorios);
    });

    actualizarObligatorios();
} 


const cajaNotificacion = document.getElementById('mensajeNotificacion');

if (cajaNotificacion) {
    const parametrosURL = new URLSearchParams(window.location.search);
    const estadoEnvio = parametrosURL.get('status');

    if (estadoEnvio === 'success') {
        cajaNotificacion.textContent = "¡Tu mensaje se ha enviado correctamente! Nos pondremos en contacto contigo pronto.";
        cajaNotificacion.classList.remove('oculto');
        cajaNotificacion.classList.add('exito');
    } else if (estadoEnvio === 'error') {
        cajaNotificacion.textContent = "Ha ocurrido un error al enviar el mensaje. Por favor, inténtalo de nuevo, y si sigue dando error, contáctanos por teléfono, email o redes sociales para hacernos llegar tu consulta. Disculpa las molestias";
        cajaNotificacion.classList.remove('oculto');
        cajaNotificacion.classList.add('error');
    }
}

// calendario
const filtroCategoria = document.getElementById("filtroCategoria");
const cuadriculaCalendario = document.getElementById("cuadriculaCalendario");
const fechaActualTitulo = document.getElementById("fechaActual");

if (cuadriculaCalendario && fechaActualTitulo) {
    let fecha = new Date();
    let mesActual = fecha.getMonth();
    let anyoActual = fecha.getFullYear();

    const nombresMeses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];

    function renderizarCalendario() {
        cuadriculaCalendario.innerHTML = "";
        fechaActualTitulo.textContent = `${nombresMeses[mesActual]} ${anyoActual}`;

        const categoriaSeleccionada = filtroCategoria.value;

        let primerDiaMes = new Date(anyoActual, mesActual, 1).getDay();
        let diaInicio = primerDiaMes === 0 ? 6 : primerDiaMes - 1;
        let diasDelMes = new Date(anyoActual, mesActual + 1, 0).getDate();

        for (let i = 0; i < diaInicio; i++) {
            const hueco = document.createElement("div");
            cuadriculaCalendario.appendChild(hueco);
        }

        for (let i = 1; i <= diasDelMes; i++) {
            const casillaDia = document.createElement("div");
            casillaDia.classList.add("diaCalendario");
            
            let contenidoHito = "";
            
            if (typeof hitosFeministas !== 'undefined') {
                const hitoEncontrado = hitosFeministas.find(h => h.dia === i && h.mes === (mesActual + 1));
                
                if (hitoEncontrado && (categoriaSeleccionada === "todas" || hitoEncontrado.categoria === categoriaSeleccionada)) {
                    
                    casillaDia.classList.add("conHito", hitoEncontrado.categoria);
                    contenidoHito = `<span class="tituloHitoMini">${hitoEncontrado.titulo || "Hito"}</span>`;
 
                        casillaDia.addEventListener("click", () => {
                        document.getElementById("tituloDetalle").textContent = hitoEncontrado.titulo;
                        document.getElementById("cuerpoDetalle").textContent = hitoEncontrado.descripcion;
                        document.getElementById("tituloDeCalendario").scrollIntoView({ behavior: 'smooth', block: 'start' });
                    });

                }
            }
            casillaDia.innerHTML = `<strong>${i}</strong> ${contenidoHito}`;
            cuadriculaCalendario.appendChild(casillaDia);
        } 
    }

    renderizarCalendario();

    const btnAnterior = document.getElementById("btnAnterior");
    const btnSiguiente = document.getElementById("btnSiguiente");

    if (btnAnterior && btnSiguiente) {
        btnAnterior.addEventListener("click", () => {
            mesActual--;
            if (mesActual < 0) { mesActual = 11; anyoActual--; }
            renderizarCalendario();
        });

        btnSiguiente.addEventListener("click", () => {
            mesActual++;
            if (mesActual > 11) { mesActual = 0; anyoActual++; }
            renderizarCalendario();
        });
    }


    if (filtroCategoria) {
        filtroCategoria.addEventListener("change", renderizarCalendario);
    }
}

// menú header sidebar (administración)

document.addEventListener('DOMContentLoaded', () => {
    const btnMenuAdmin = document.getElementById('btnMenuAdmin');
    const btnOcultarAdmin = document.getElementById('btnOcultarAdmin');
    const sidebarContenedor = document.getElementById('sidebarContenedor');

    if (btnMenuAdmin && btnOcultarAdmin && sidebarContenedor) {

        btnMenuAdmin.addEventListener('click', () => {
            sidebarContenedor.classList.add('activa');
        });

        btnOcultarAdmin.addEventListener('click', () => {
            sidebarContenedor.classList.remove('activa');
        });
    }
});


function obtenerUUID() {
    let uuid = localStorage.getItem('uuid_dispositivo');
    if (!uuid) {
        uuid = crypto.randomUUID(); 
        localStorage.setItem('uuid_dispositivo', uuid);
    }
    return uuid;
}

const formComentarios = document.getElementById('formularioComentarios');

if (formComentarios) {
    formComentarios.addEventListener('submit', function(evento) {
        evento.preventDefault();

        const idMemoria = document.getElementById('idMemoriaActual').value;
        const alias = document.getElementById('aliasComentario').value;
        const texto = document.getElementById('textoComentario').value;
        const tokenDispositivo = obtenerUUID();

        if (!idMemoria || idMemoria === "") {
            alert("Error: No se ha seleccionado ninguna memoria para comentar.");
            return;
        }

        const datosEnvio = new FormData();
        datosEnvio.append('idMemoria', idMemoria);
        datosEnvio.append('nombre', alias);
        datosEnvio.append('texto', texto);
        datosEnvio.append('token', tokenDispositivo);

        fetch('enviarComentario.php', {
            method: 'POST',
            body: datosEnvio
        })
        .then(respuesta => respuesta.json())
        .then(datos => {
            if (datos.status === 'success') {
                alert(datos.message); 
                formComentarios.reset(); 
            } else {
                alert("Atención: " + datos.message); 
            }
        })
        .catch(error => {
            alert("Hubo un problema de conexión con el servidor.");
        });
    });
}

document.addEventListener("DOMContentLoaded", () => {
    const btnAbrirModal = document.getElementById('btnContadorFlotante');
    const modalManifiesto = document.getElementById('modalManifiesto');
    const btnCerrarModal = document.getElementById('btnCerrarModal');

    if (btnAbrirModal && modalManifiesto && btnCerrarModal) {
        btnAbrirModal.addEventListener('click', () => {
            modalManifiesto.showModal();
        });

        btnCerrarModal.addEventListener('click', () => {
            modalManifiesto.close();
        });
    }
});

// tarjetasHacemos de inicio en carrusel 

document.addEventListener('DOMContentLoaded', () => {
    const carrusel = document.getElementById('carruselHacemos');
    const tarjetas = document.querySelectorAll('.tarjetasHacemos');
    const btnAtras = document.getElementById('btnAtras');
    const btnSig = document.getElementById('btnSig');

    if (!carrusel || tarjetas.length === 0) return;

    const mover = (direccion) => {
        const desplazamiento = tarjetas[0].offsetWidth;
        carrusel.scrollBy({
            left: direccion === 'next' ? desplazamiento : -desplazamiento,
            behavior: 'smooth'
        });
    };

    btnSig.addEventListener('click', () => mover('next'));
    btnAtras.addEventListener('click', () => mover('prev'));

    const observerOptions = {
        root: carrusel,
        threshold: 0.6 
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('activa');

                if (entry.target.id === 'tarjetaA') {
                    btnAtras.classList.add('oculta');
                } else {
                    btnAtras.classList.remove('oculta');
                }

                if (entry.target.id === 'tarjetaC') {
                    btnSig.classList.add('oculta');
                } else {
                    btnSig.classList.remove('oculta');
                }

            } else {
                entry.target.classList.remove('activa');
            }
        });
    }, observerOptions);

    tarjetas.forEach(t => observer.observe(t));

    setTimeout(() => {
        carrusel.scrollTo({ left: 0 });
    }, 50);
});