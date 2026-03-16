//Encabezado con menú (escritorio y móvil)

const btnMenu = document.getElementById('btnMenu');
const menuLateral = document.getElementById('menuLateral');
const cabecera = document.querySelector('.cabecera');

btnMenu.addEventListener('click', () =>{
    menuLateral.classList.toggle('activo');
});

let ubicacionPrincipal = window.scrollY;
    window.addEventListener('scroll', () => {
        let desplazamientoActual = window.scrollY;
        if (menuLateral.classList.contains('activo')){
            return;
        } if (window.innerWidth >= 1327) {
        cabecera.classList.remove('oculta');
        return; 
        } if (ubicacionPrincipal>=desplazamientoActual){
            cabecera.classList.remove('oculta');
        } else {
            cabecera.classList.add('oculta');
        }
        ubicacionPrincipal=desplazamientoActual
    })
   
const bntOcultar = document.getElementById('btnOcultar');

bntOcultar.addEventListener('click',() =>{
    menuLateral.classList.remove('activo');
})

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