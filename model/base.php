<?php 
    class Base{
        public $db;
        public function __construct() {
            $this->db = new PDO('mysql:host='.DBHOST.';dbname='.DBNAME.';charset=utf8mb4', DBUSER, DBPWD);
        }
        public function sanitize($data) {
            foreach($data as $key=>$val) {
                $data[$key] = strip_tags(trim($val));
            }
            return $data;
        }
        
        public function validateUserAcess($data) {
            if(isset($_SESSION['user_id'])) {
                return $_SESSION['user_id'];
            }
            elseif(isset($data['api_key'])) {
                $query = $this->db->prepare("
                    SELECT user_id
                    FROM users
                    WHERE api_key = ?
                ");
                $query->execute([
                    $data['api_key']
                ]);
                $user = $query->fetch(PDO::FETCH_ASSOC);
                if(!empty($user)) {
                    return $user['user_id'];
                }
            }
            return false;
        }
        
    }
?>