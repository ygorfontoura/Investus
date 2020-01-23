<?php
    require("base.php");
    class Users extends Base{
        public function create($data){
            $data = $this->sanitize($data);
             if(
                 !empty($data['fullname']) &&
                 !empty($data['phone']) &&
                 !empty($data['pwd']) &&
                 filter_var($data['email'], FILTER_VALIDATE_EMAIL) &&
                 mb_strlen($data['fullname']) <= 6 &&
                 mb_strlen($data['pwd']) >= 8 &&
                 mb_strlen($data['pwd']) <= 10000
             ){
                 $query = $this->db->prepare(
                     "INSERT INTO users
                     (fullname, email, phone, pwd, active, api_key)
                     VALUES
                     (?, ?, ?, ?, ?, ?)"
                 );
                 $result = $query->execute([
                     $data['fullname'],
                     $data['email'],
                     $data['phone'],
                     password_hash($data['pwd'], PASSWORD_DEFAULT),
                     1,
                     bin2hex(random_bytes(32))
                 ]);
                 return $result;
             }
             return false;
        }
        
    }

?>