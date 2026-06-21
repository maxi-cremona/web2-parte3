<?php

class NoticiaModel{
    private $db;

    public function __construct() {
        $this->db = new PDO("mysql:host=".MYSQL_HOST .";dbname=".MYSQL_DB.";charset=utf8", MYSQL_USER, MYSQL_PASS);
    }

    public function getAll($field, $order) {
        $query = $this->db->prepare("SELECT * FROM noticia ORDER BY $field $order");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function update($id, $titulo, $cuerpo, $fecha, $id_seccion) {
        $query = $this->db->prepare("UPDATE noticia SET titulo = ?, cuerpo = ?, fecha = ?, id_seccion_fk = ? WHERE id_noticia = ?");
        //como pongo el return aca devuelve verdadero o falso si fallo.
        return $query->execute([$titulo, $cuerpo, $fecha, $id_seccion, $id]);
    }

    public function getNoticiaByID($id) {
        $query = $this->db->prepare('SELECT * FROM noticia WHERE id_noticia = ?');
        $query->execute([$id]);
        return $query->fetch(PDO::FETCH_OBJ);
    }

    public function insert($titulo, $cuerpo, $fecha, $id_seccion) {
        $query = $this->db->prepare('INSERT INTO noticia(titulo, cuerpo, fecha, id_seccion_fk) VALUES(?,?,?,?)');
        $query->execute([$titulo, $cuerpo, $fecha, $id_seccion]);

        return $this->db->lastInsertId();
    }

    public function delete($id) {
        $query = $this->db->prepare('DELETE FROM noticia WHERE id_noticia = ?');
        $query->execute([$id]);
    }
}