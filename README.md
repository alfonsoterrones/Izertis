# Izertis

Proyecto básico para poder probar el módulo 'Izertis' que nos descargará tanto los comics como los
personajes de Marvel.

## Módulo Izertis

El módulo Izertis se encuentra instalado y lo encontramos en la siguiente ruta "web/modules/izertis".

Su funcionalidad principal es la de descargar los contenidos desde la API de Marvel y poder cargarlas
como tipo de contenido "Marvel", El módulo es capaz de detectar si dicho contenido ya existe para no
duplicarlo basandose en el id que nos llega de Marvel.

Para su desarrollo hemos utilizado los servicios de Drupal, así como la API de Drupal para obtener por
ejemplo taxonomías o crear nodos dentro de un tipo de contenido.

En el menú principal tenemos un enlace ("Carga de datos") que nos llevará al formulario del módulo para
poder descargar el contenido, actualmente tenemos todo el contenido descargado, pero podemos eliminar
contenido y lanzar la descarga para ver que descarga correctamente.

También tenemos la posibilidad de cambiar tanto la key como el hash que lo encontraremos en el menú de
administración en la siguiente ruta (/admin/config/system/izertis), actualmente está configurado con mi
clave y mi hash.

## Vista

Tenemos una vista que nos muestra los contenidos descargados, la vista está dotada para poder realizar
filtros mediante AJAX así evitamos recargar la página, también tenemos la posibilidad de añadir a favoritos.
Para poder utilizar la vista la tenemos enlazada en el menú principal ("Listado de contenidos").

## Modulos

Como módulos contrib tenemos:

  1 dotev: lo utilizamos para poder sacar variables al archivo .env, en dicho archivo tendremos tanto
    la configuración de la base de datos como la url de la API de Marvel para así evitar tenelo en código
  2 flag: dicho módulo lo hemos utilizado para poder asignar a favoritos las nodos de la vista.