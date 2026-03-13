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