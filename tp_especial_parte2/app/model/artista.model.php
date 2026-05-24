<?php
require_once __DIR__ . '/config.php';
class ArtistaModel {
    private $db;

     public function __construct() {
        $this->db = new PDO(
            "mysql:host=".MYSQL_HOST .
            ";dbname=".MYSQL_DB.
            ";charset=utf8", 
            MYSQL_USER, MYSQL_PASS)
            ;$this->_deploy();
    }
    private function _deploy() {
        $query = $this->db->query('SHOW TABLES');
        $tables = $query->fetchAll();
        if(count($tables) == 0) {
            $sql =<<<END
        END;
$this->db->query($sql);
  }
}

    public function getAll() {
        $query = $this->db->prepare('SELECT * FROM artista');
        $query->execute();

        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function get($id) {
        $query = $this->db->prepare('SELECT * FROM artista WHERE id_artista = ?');
        $query->execute([$id]);

        return $query->fetch(PDO::FETCH_OBJ);
    }

    public function insert($nombre_artistico, $nombre_completo, $fecha_nacimiento, $genero, $imagen) {
        $query = $this->db->prepare('
            INSERT INTO artista(nombre_artistico, nombre_completo, fecha_nacimiento, genero, imagen)
            VALUES (?, ?, ?, ?, ?)
        ');

        $query->execute([
            $nombre_artistico,
            $nombre_completo,
            $fecha_nacimiento,
            $genero,
            $imagen
        ]);

        return $this->db->lastInsertId();
    }

    public function delete($id) {
        $query = $this->db->prepare('DELETE FROM artista WHERE id_artista = ?');
        $query->execute([$id]);
    }

    public function update($id, $nombre_artistico, $nombre_completo, $fecha_nacimiento, $genero, $imagen) {
        $query = $this->db->prepare('
            UPDATE artista
            SET nombre_artistico = ?, nombre_completo = ?, fecha_nacimiento = ?, genero = ?, imagen = ?
            WHERE id_artista = ?
        ');

        $query->execute([
            $nombre_artistico,
            $nombre_completo,
            $fecha_nacimiento,
            $genero,
            $imagen,
            $id
        ]);
    }
}