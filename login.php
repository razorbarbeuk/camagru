<?php 
    require_once "./public/function.php";
    reconnect_from_cookie();
    if (isset($_SESSION['auth'])) {
        header('Location: account.php');
        exit();
    }
    if (!empty($_POST) && !empty($_POST['username']) && !empty($_POST['password'])) {    
        require_once "./config/connect_db.php";
        $req = $connect->prepare("SELECT * FROM users WHERE (username = :username OR email = :username) AND confirmed_at IS NOT NULL");
        $req->execute(['username' => $_POST['username']]);
        $user = $req->fetch();
        if (password_verify($_POST['password'], $user->password)) {
            session_start();
            $_SESSION['auth'] = $user;
            $_SESSION['flash']['success'] = 'Vous êtes maintenant connecté';
            if ($_POST['remember']) {
                $remember_token = str_random(250);
                $connect->prepare("UPDATE users SET remember_token = ? WHERE id = ?")->execute([$remember_token, $user->id]);
                setcookie('remember', $user->id . "==" . $remember_token . sha1($user->id . 'tutu'), time() + 60 * 60 * 24 * 7);
            }
            header('Location: account.php');
            exit();
        } else {
            $_SESSION['flash']['danger'] = 'Identifiant ou mot de passe incorrecte';
        }
    }
?>

<?php require "./public/header.php"; ?>

<h1>Se connecter</h1>

<div class="register_container">
    <form method="POST" class="">
        <label for="username">username ou email</label>
        <input type="text" name="username"/>
        <label for="password">mot de passe<a href="forget.php" class="forget">J'ai oublié mon mot de passe</a></label>
        <input type="password" name="password"/>
        <label>
            <input type="checkbox" class="checkbox" name="remember" value="1"/> 
            <span class="label-body">Se souvenir de moi</span>
        </label>
        <button class="button-primary" type="submit" value="Submit">Submit</button>
        <a class="margin-15-left" href="register.php">Je n'ai pas de compte</a>
    </form>
</div>

<?php require "./public/footer.php" ?>