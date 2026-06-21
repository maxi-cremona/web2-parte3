WEB2_TPE_3

API REST para gestionar noticias y sus secciones. Se puede obtener todas las noticias, obtener una noticia por ID, agregar una noticia, modificar una noticia y eliminar una noticia.

Obtener todas las noticias:

REQUEST
GET /api/noticias


Obtener una noticia por ID:

REQUEST
GET /api/noticias/1

Respuesta (ejemplo)
{
  "id_noticia": 1,
  "titulo": "Nueva API en PHP",
  "cuerpo": "Estamos probando el funcionamiento del TP3...",
  "fecha": "2026-06-12",
  "id_seccion_fk": 1
}


Agregar una noticia:

REQUEST
POST /api/noticias

Body (ejemplo)
{
  "titulo": "Título Noticia",
  "cuerpo": "Contenido del artículo...",
  "fecha": "2026-06-21",
  "id_seccion_fk": 1
}


Modificar una noticia:

REQUEST
PUT /api/noticias/1

Body (ejemplo)
{
  "titulo": "Título Modificado",
  "cuerpo": "Contenido actualizado...",
  "fecha": "2026-06-21",
  "id_seccion_fk": 1
}


Eliminar una noticia:

REQUEST
DELETE /api/noticias/1


Filtrado:

REQUEST
GET /api/noticias?seccion=1

Obtiene únicamente las noticias que pertenecen al ID de la sección indicada.
