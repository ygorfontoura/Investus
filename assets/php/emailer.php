<?php
    INCLUDE('mailer/PHPMailerAutoLoad.php');
    include_once('config.php');
    class Mail{
        
        public function sendMail($data){
            $key = $data['request_key'];
            $email = $data['email'];
            $firstName = $data['first_name'];
            $lastName = $data['last_name'];
            $fullname = $firstName ." ". $lastName;
            $link = "localhost".ROOT."auth/forgot?forgot_key=" .$key;
            $browser = $data['browser'];
            $ip = $data['ip'];
            $time = date("r");
            $replace = array($fullname, $link, $browser, $ip, $time);
            
            $mail = new PHPMailer;
            $mail->isSMTP();
            $mail->Debugoutput = 'html';
            $mail->Host = MAIL_SERVER;
            $mail->Port = MAIL_PORT;
            $mail->SMTPDebug = 0;
            
            $mail->SMTPSecure = 'tls';
            $mail->SMTPAuth = true;
            
            $mail->Username = MAIL_USR;
            $mail->Password = MAIL_PWD;
            
            $mail->setFrom(MAIL_USR, 'InvestUs');
            $mail->addAddress($email, $fullname);
            $mail->Subject = MAIL_SUBJECT;
            
            $content = file_get_contents('recover_pwd.html', true);
            $mail->msgHTML($content);
            $newContent = str_replace(array('[NAME]', '[LINK]', '[BROWSER]', '[IP]', '[TIME]'), $replace, $content);
            
            $mail->msgHTML($newContent);
            if($mail->send()){
                return true;
            } else {
                return false;
            }
        }
    }
?>