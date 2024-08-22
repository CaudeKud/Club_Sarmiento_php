# Club_Sarmiento_php
Proyecto de Gestion ABM de Socios, Disciplinas, Pagos y Reportes

- El Proyecto se encuentra alojado en la rama Maestro de GitHub.
- El Archivo de Creacion de la Base de Datos se encuentra alojado en un .txt en el Readme de la misma rama 

Club Sarmiento - Sistema de Gestión
Este proyecto es un sistema de gestión para un club deportivo, que permite administrar socios, disciplinas y pagos, así como generar reportes y gráficos basados en los datos almacenados. La aplicación está construida utilizando PHP, MySQL, Bootstrap, Animate.css, y otras tecnologías web.

Funcionalidades Principales
- Gestión de Socios: Registro, modificación y eliminación de socios.
- Gestión de Disciplinas: Registro, modificación y eliminación de disciplinas deportivas.
- Gestión de Pagos: Administración de pagos mensuales asociados a los socios, con tipos de cuotas definidos.
- Reportes y Gráficos: Generación de reportes de pagos con la opción de exportarlos a Excel y visualización de gráficos de distribución de ingresos por disciplinas.
- Seguridad: Sistema de autenticación de usuarios con manejo de sesiones para acceso controlado a las páginas del sistema.

Herramientas y Tecnologías Utilizadas
- Lenguajes: PHP, SQL, HTML, CSS, JavaScript
- Base de Datos: MySQL

Frameworks y Librerías:
- Bootstrap: Para el diseño responsivo y componentes de interfaz.
- Animate.css: Para animaciones en los mensajes de confirmación y otros elementos.
- PhpSpreadsheet: Para la generación y exportación de reportes en formato Excel.
- Composer: Para la gestión de dependencias PHP.
- Visualización de Gráficos: Uso de librerías para la creación de gráficos en el archivo graficos.php (considerar Chart.js o una similar).

Requisitos Previos
Antes de ejecutar este proyecto, es necesario tener instalados los siguientes componentes:
- Servidor Web: Apache (recomendado con XAMPP, WAMP, o similar).
- PHP: Versión 7.4 o superior.
- MySQL: Para la base de datos.
- Composer: Para gestionar dependencias PHP.(generacion de reportes y exportacion a excel)

Instalación
- Clona el repositorio:

Configura la base de datos:

- Crea una base de datos MySQL llamada club_sarmiento.
- Importa el archivo club_sarmiento.sql que contiene la estructura y datos iniciales de la base de datos.
- Instala dependencias con Composer:

Composer manejo de reportes y exportar reportes con excel

Navega a la carpeta del proyecto y ejecuta:

- Abrir un terminal bash)
composer install

Configura el entorno:
- Renombra el archivo .env.example a .env y configura las variables de entorno necesarias (credenciales de base de datos, etc.).
Inicia el servidor:

- Si estás utilizando XAMPP, arranca Apache y MySQL desde el panel de control.
- Asegúrate de que el servidor web esté apuntando a la carpeta del proyecto.

Accede al sistema:
-  Abre tu navegador y navega a http://localhost/Club_Sarmiento.
Estructura del Proyecto
login.php: Manejador del proceso de inicio de sesión.
index.php: Página de inicio del sistema.
socios.php: Gestión de socios, búsqueda y edición.
disciplinas.php: Gestión de disciplinas.
pagos.php: Gestión de pagos, incluyendo la búsqueda y toma de pagos.
reportes.php: Generación de reportes y exportación a Excel.
graficos.php: Visualización de gráficos de distribución de ingresos.

Agradecimientos
- Gracias vuelva prontos

  
![image](https://github.com/user-attachments/assets/b1327a39-84d4-4d6d-a098-3c6baf9be9fe)


