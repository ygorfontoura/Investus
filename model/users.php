<?php
    require('base.php');
    require('accounts.php');
    class User{
        use Base;
        
        public $user_id;
        public $first_name;
        public $last_name;
        public $phone;
        public $email;
        public $suite;
        public $address;
        public $postal_code;
        public $user_avatar;


        public function create($data){

            $data = $this->sanitize($data);
            if(
                !empty($data['first_name']) &&
                !empty($data['last_name']) &&
                !empty($data['phone']) &&
                !empty($data['pwd']) &&
                filter_var($data['email'], FILTER_VALIDATE_EMAIL) &&
                mb_strlen($data['first_name']) >= 2 &&
                mb_strlen($data['last_name']) >= 2 &&
                mb_strlen($data['pwd']) >= 8 &&
                mb_strlen($data['pwd']) <= 10000
                ){

                    $query = $this->db->prepare(
                    "INSERT INTO users
                     (first_name, last_name, email, phone, pwd, active, api_key)
                     VALUES
                     (?, ?, ?, ?, ?, ?, ?)"
                 );
                 $result = $query->execute([
                     $data['first_name'],
                     $data['last_name'],
                     $data['email'],
                     $data['phone'],
                     password_hash($data['pwd'], PASSWORD_DEFAULT),
                     1,
                     bin2hex(random_bytes(32))
                 ]);
                 $user_id = $this->db->lastInsertId();
                 (new Account())->createAccount($user_id);
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
                "SELECT u.id, u.first_name, u.last_name, u.pwd, u.api_key
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
                $_SESSION['first_name'] = $user['first_name'];
                $_SESSION['last_name'] = $user['last_name'];
                return $user;
            } else { return false; }
        }

        public function logout(){
            unset($_SESSION['user_id']);
            unset($_SESSION['api_key']);
            unset($_SESSION['first_name']);
            unset($_SESSION['last_name']);
            session_destroy();
            return true;
        }

        public function getUserData($id){
            $query = $this->db->prepare(
                "SELECT user_avatar, first_name, last_name, phone, email, address, suite, postal_code
                FROM users
                WHERE id = ?"
            );
            $query->execute([$id]);
            $data = $query->fetch(PDO::FETCH_ASSOC);
            $this->user_avatar = $data['user_avatar'];
            $this->first_name = $data['first_name'];
            $this->last_name = $data['last_name'];
            $this->phone = $data['phone'];
            $this->email = $data['email'];
            $this->address = $data['address'];
            $this->suite = $data['suite'];
            $this->postal_code = $data['postal_code'];
            return $this;
        }

        public function update($data){
            $data = $this->sanitize($data);
            if(!$_SESSION['user_id']) return false;
            $user_avatar = $this->getFileAvatar($_FILES['userAvatar']);
            if(
                !empty($data['first_name']) &&
                !empty($data['last_name']) &&
                !empty($data['phone']) &&
                filter_var($data['email'], FILTER_VALIDATE_EMAIL) &&
                mb_strlen($data['first_name']) >= 2 &&
                mb_strlen($data['last_name']) >= 2
                ){
                    $query = $this->db->prepare(
                    "UPDATE users
                    SET first_name = ?, 
                        last_name = ?,
                        email  = ?,
                        phone = ?,
                        address = ?,
                        suite = ?,
                        postal_code = ?,
                        user_avatar = ?
                    WHERE id = ?"
                );
                $result = $query->execute([
                    $data['first_name'],
                    $data['last_name'],
                    $data['email'],
                    $data['phone'],
                    $data['address'],
                    $data['suite'],
                    $data['postal_code'],
                    $user_avatar,
                    $_SESSION['user_id']
                ]);
                return $result;
            }
            return false;
        }
        
        public function getFileAvatar($data){
            if(!empty($data['name'])){
                $origin = $data['tmp_name'];
                $explode = explode(".", $data['name']);
                $ext = $explode[count($explode)-1];
                $name = uniqid().".".$ext;
                $path = "..".ROOT."public/users_avatar/";
                $final = $path.$name;
                move_uploaded_file($origin, $final);
                return $this->user_avatar = $name;
            }
            return $this->getUserData($_SESSION['user_id'])->user_avatar;
        }
    }
?>
