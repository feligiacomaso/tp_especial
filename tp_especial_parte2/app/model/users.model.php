<?php
require_once __DIR__ . '/config.php';
class UsersModel {
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
      // 2. prepara y ejecuta la consulta
      $query = $this->db->prepare('SELECT * FROM users');
      $query->execute();

      // 3. obtiene los resultados
      $users = $query->fetchAll(PDO::FETCH_OBJ);

      // var_dump($query->errorInfo());

      return $users;
   }

   public function get($id) {
      $query = $this->db->prepare('SELECT * FROM users WHERE id_user = ?');
      $query->execute([$id]);

      return $query->fetch(PDO::FETCH_OBJ);
   }

   public function getByEmail($email) {
      $query = $this->db->prepare('SELECT * FROM users WHERE email = ?');
      $query->execute([$email]);

      return $query->fetch(PDO::FETCH_OBJ);
   }

}
