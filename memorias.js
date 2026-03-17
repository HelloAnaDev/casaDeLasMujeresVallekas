document.addEventListener('DOMContentLoaded', () => {
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

    fetch('backend/api/getMemorias.php')
        .then(respuesta => respuesta.json())
        .then(datos => {
            if (datos.length === 0) {
                tituloMes.textContent = "No hay actividades publicadas.";
                return;
            }
            listaMemorias = datos;
            pintarMemoria();
        });

    function pintarMemoria() {
        const memoria = listaMemorias[indiceMemoria];
        
        tituloMes.textContent = memoria.titulo;
        
        if (textoMemoria) {
            textoMemoria.textContent = memoria.descripcion; 
        }

        indiceFoto = 0;
        pintarFoto();
    }

 function pintarFoto() {
    const memoria = listaMemorias[indiceMemoria];
    const galeria = memoria.galeria_fotos;
    const total = galeria.length;

    if (total > 0) {
        fotoPrincipal.src = `images/${galeria[indiceFoto]}`;
        contadorFotos.textContent = `${indiceFoto + 1} / ${total}`;

        let idxAnt = (indiceFoto === 0) ? total - 1 : indiceFoto - 1;
        document.getElementById('fotoAnterior').src = `images/${galeria[idxAnt]}`;

        let idxSig = (indiceFoto === total - 1) ? 0 : indiceFoto + 1;
        document.getElementById('fotoSiguiente').src = `images/${galeria[idxSig]}`;
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
});