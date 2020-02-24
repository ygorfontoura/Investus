<?php 
    trait Base{
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
    }
?>