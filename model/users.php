<?php
    require('base.php');
    class Users extends Base{
        public function create($data){
            $data = $this->sanitize($data);
            if(
                !empty($data['fullname']) &&
                !empty($data['phone']) &&
                !empty($data['pwd']) &&
                filter_var($data['email'], FILTER_VALIDATE_EMAIL) &&
                !mb_strlen($data['fullname']) <= 6 &&
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
             } else {
                 return false;
             }
        }
        public function register($data){
            if($data['pwd'] === $data['rep_pwd']){
                return $this->create($data);
            }
            return false;
        }
        public function login($data){
            $data = $this->sanitize($data);
            $query = $this->db->prepare(
                "SELECT u.id, u.fullname, u.pwd, u.api_key
                FROM users u
                WHERE u.email = ?"
            );
            $query->execute([
                $data['email']
            ]);
            $user = $query->fetch(PDO::FETCH_ASSOC);
            if(!empty($user) && password_verify($data['pwd'], $user['pwd'])){
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['api_key'] = $user['api_key'];
                $_SESSION['fullname'] = $user['fullname'];
                return $user;
            } else { return false; }
        }
        public function logout(){
            unset($_SESSION['user_id']);
            unset($_SESSION['api_key']);
            unset($_SESSION['fullname']);
            session_destroy();
            return true;
        }
        public function getUserData($id){
            $query = $this->db->prepare(
                "SELECT user_avatar, fullname, phone, email
                FROM users
                WHERE id = ?"
            );
            $query->execute([$id]);
            $data = $query->fetchAll(PDO::FETCH_ASSOC);
            return $data[0];
        }
    }
?>