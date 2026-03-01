//js

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