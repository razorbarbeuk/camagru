<?php 
    if (!empty($_POST) && !empty($_POST['username']) && !empty($_POST['password'])) {
        require_once "./public/function.php";
        require_once "./config/connect_db.php";
        $req = $connect->prepare("SELECT * FROM users WHERE (username = :username OR email = :username) AND confirmed_at IS NOT NULL");
        $req->execute(['username' => $_POST['username']]);
        $user = $req->fetch();
        if (password_verify($_POST['password'], $user->password)) {
            session_start();
            $_SESSION['auth'] = $user;
            $_SESSION['flash']['success'] = 'Vous êtes maintenant connecté';
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
        <label for="password">mot de passe</label>
        <input type="password" name="password"/>
        <button class="button-primary" type="submit" value="Submit">Submit</button>
    </form>
</div>

<?php require "./public/footer.php" ?>