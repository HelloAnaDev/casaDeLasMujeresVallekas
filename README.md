# La Casa de las Mujeres de Vallekas

Plataforma web dinámica y autogestionable desarrollada para la asociación "La Casa de las Mujeres de Vallekas". El proyecto está diseñado para dar visibilidad a las acciones del colectivo y facilitar la participación ciudadana, priorizando la accesibilidad y minimizando la carga digital para las voluntarias que administran el sitio.

## Características principales

El sistema está dividido en dos grandes áreas con separación de responsabilidades:

### 1. Área de acceso libre
* **Interfaz corporativa:** Secciones informativas (Inicio, Quiénes somos, Colabora, Contacto) con diseño responsive y teniendo presente una buena experiencia de UX/UI.
* **Memorias mensuales "La casa en marcha":** Repositorio cronológico estilo blog donde se exponen los eventos, talleres y acciones de activismo.
* **Participación ciudadana sin registro:** Sistema de comentarios mediante tokens UUID generados en el navegador para comentar en "La casa en marcha". Permite a las usuarias interactuar sin la fricción de crear una cuenta, fomentando la accesibilidad.
* **Contador de visibilización:** Display simbólico en tiempo real de los días sin feminicidios en España.

### 2. Área privada (Backoffice de administración)
* **Autenticación segura:** Sistema de Login/Registro exclusivo para administradoras con contraseñas hasheadas y control estricto de sesiones en PHP.
* **Gestor de contenidos (CRUD):** Interfaz para crear, leer, actualizar y borrar las memorias mensuales y sus imágenes asociadas.
* **Moderación de comentarios:** Panel para *aprobar* o *rechazar* comentarios; o en caso de comentarios malintencionados, *rechazar y bloquear*, función que rechaza el comentario y bloquea el token UUID del dispositivo para imposibilitarle la opción de volver a comentar en La casa en Marcha, garantizando un espacio seguro al público y liberando tiempo de gestionar comentarios inútiles a las administradoras en el futuro.
* **Gestión del contador:** Herramienta para actualizar el contador de visibilización de forma manual. Además funciona como activador del *modo luto* en la página web durante el día que transcurre y el siguiente, estableciendo un filtro de escala de grises a la web pública, con el fin de visibilizar la situación que se denuncia.

## Tecnologías y arquitectura

El proyecto ha sido desarrollado aplicando principios de clean code y sin depender de frameworks pesados, garantizando un rendimiento óptimo y control total sobre el código.

* **Frontend:** HTML5, CSS3, JavaScript. Interfaz separada de la lógica estructural.
* **Backend:** PHP 8.
* **Base de Datos:** MySQL (Gestión relacional con integridad referencial).
* **Conexión:** PDO (PHP Data Objects) para interactuar de forma segura y eficiente con la base de datos.
* **Seguridad:** * Prevención de inyección SQL mediante consultas preparadas (PDO).
  * Validación de datos tanto en cliente (JS) como en servidor (PHP).
  * Redireccionamiento web y certificado SSL (HTTPS) en el entorno de producción.

## Instalación y despliegue Local

Para desplegar este proyecto en un entorno local (como XAMPP, MAMP o Laragon), sigue estos pasos:

* **Clonar el repositorio:** git clone https://github.com/HelloAnaDev/casaDeLasMujeresVallekas.git 

