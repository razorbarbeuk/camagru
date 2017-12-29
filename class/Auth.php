<?php
class Auth{

    private $options = [
        'restriction_msg' => "Vous n'avez le droit d'accéder à cette page"
    ];

    public function __construct($options = []){
        $this->options = array_merge($this->options, $options);
    }

    public function register($db, $firstname, $lastname, $username, $email, $password){
        $password = password_hash($password, PASSWORD_BCRYPT);
        $token = Str::random(60);
        $req = $db->query("INSERT INTO users SET firstname = ?, lastname = ?, username = ?, password = ?, email = ?, confirmed_token = ?", [
            $firstname, 
            $lastname, 
            $username, 
            $password, 
            $email, 
            $token
        ]);
        $user_id = $db->lastInsertId();
        mail($_POST['email'], 'Confirmation de votre compte', "Afin de valider votre compte, merci de cliquer sur le lien suivant\n\nhttp://localhost:8000/confirm.php?id=$user_id&token=$token");
    }

    public function confirm($db, $user_id, $token, $session){
        $user = $db->query("SELECT * FROM users WHERE id = ?", [$user_id])->fetch();
        if ($user && $user->confirmed_token == $token) {
            $db->query("UPDATE users SET confirmed_token = NULL, confirmed_at = NOW() WHERE id = ?", [$user_id]);
            $session->write('auth', $user);
            return true;
        }
        return false;
    }

    public function restrict($session){
        if (!$session->read('auth')) {
            $session->setFlash('danger', $this->options['restriction_msg']);
            header('Location: login.php');
            exit();
        }
    }



}