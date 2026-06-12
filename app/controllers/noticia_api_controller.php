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