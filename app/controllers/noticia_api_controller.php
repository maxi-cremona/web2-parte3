<?php

require_once './app/models/noticia_model.php';
require_once './app/views/api_view.php';

class NoticiaApiController{
    private $noticiaModel;
    private $apiView;

    function __construct(){
        $this->noticiaModel = new NoticiaModel();
        $this->apiView = new ApiView();
    }

    public function updateNoticia($req, $res) {
        //obtengo el id de la noticia a modificar desde la URL
        $id = $req->params->id;

        //verifico si la noticia existe
        $noticia = $this->noticiaModel->getNoticiaByID($id);
        if (!$noticia) {
            return $res->json("La noticia con el id $id no existe", 404);
        }

        //valido datos
        if (empty($req->body->titulo) || empty($req->body->cuerpo) || empty($req->body->fecha) || empty($req->body->id_seccion_fk)){
            return $res->json('Error! Faltan campos obligatorios', 400);
        }

        //agarro los datos del body del $req
        $titulo = $req->body->titulo;
        $cuerpo = $req->body->cuerpo;
        $fecha = $req->body->fecha;
        $idSeccion = $req->body->id_seccion_fk;

        // le pido al modelo que la actualice (devolvera verdadero o falso en caso de exito o no)
        $exito = $this->noticiaModel->update($id, $titulo, $cuerpo, $fecha, $idSeccion);

        if (!$exito) {
            return $res->json('Error! No se pudo actualizar la noticia en el servidor', 500);
        }

        return $res->json("La noticia con el id = $id fue actualizada con exito.", 200);
    }

    public function getNoticias($req, $res) {
        //Si el usuario no ingreso un orden pongo ASC por defecto
        $order = isset($_GET['order']) ? $_GET['order'] : 'ASC'; 
        
        //Si el usuario no ingreso un campo pongo ID por defecto
        $field = isset($_GET['field']) ? $_GET['field'] : 'id_noticia';

        // Valido para que no haya inyeccion de codigo
        if ($order != 'ASC' && $order != 'DESC') {
            $order = 'ASC';
        }

        // Llamo al model pasandole el orden
        $noticias = $this->noticiaModel->getAll($field, $order);

        // devuelvo la respuesta y el código 200
        return $res->json($noticias, 200);
    }

    public function getNoticiaByID($req, $res){

        //obtengo el ID desde la ruta
        $id = $req->params->id;

        //obtengo la serie de la db
        $serie = $this->noticiaModel->getNoticiaByID($id);

        if (!$serie){
            return $res->json("Ups! La serie que buscas no existe ):", 400);
        }
        return $res->json($serie,200); 
    }

    public function addNoticia($req, $res){
        if (empty($req->body->titulo) || empty($req->body->cuerpo) || empty($req->body->fecha) || empty($req->body->id_seccion_fk)){
            return $res->json('Error! Faltan campos obligatorios', 400);
        }

        //obtengo los datos del body del $req
        $titulo = $req->body->titulo;
        $cuerpo = $req->body->cuerpo;
        $fecha = $req->body->fecha;
        $idSeccion = $req->body->id_seccion_fk;
        

        //pido al model que la inserte
        $serie = $this->noticiaModel->insert($titulo, $cuerpo, $fecha, $idSeccion);

        if (!$serie){
            return $res->json('Error! No se pudo insertar la tarea', 500);
        }

        //la devuelvo junto con un mensaje que confirme el exito del post
        return $res->json("La serie con el id= $serie fue agregada con exito.", 201);
    }

    public function deleteNoticia($req, $res) {
        $id = $req->params->id;
        $noticia = $this->noticiaModel->getNoticiaByID($id);
        
        if(!$noticia) {
            return $res->json("La noticia con el id=$id no exite", 404);
        }

        $this->noticiaModel->delete($id);
    }
}