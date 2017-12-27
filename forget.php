<?php 
    if (!empty($_POST) && !empty($_POST['email'])) {
        require_once "./public/function.php";
        require_once "./config/connect_db.php";
        $req = $connect->prepare("SELECT * FROM users WHERE email = ? AND confirmed_at IS NOT NULL");
        $req->execute([$_POST['email']]);
        $user = $req->fetch();
        if ($user) {
            session_start();
            $reset_token = str_random(60);
            $req = $connect->prepare("UPDATE users SET reset_token = ?, reset_at = NOW() WHERE id = ?")->execute([$reset_token, $user->id]);
            $_SESSION['flash']['success'] = 'Un email vous a ete envoyé';
            mail($_POST['email'], 'Réinitialisation de votre mot de passe', "Afin de valider votre compte, merci de cliquer sur le lien suivant\n\nhttp://localhost:8000/reset.php?id={$user->id}&token=$reset_token");
            header('Location: login.php');
            exit();
        } else {
            $_SESSION['flash']['danger'] = "l'email n'a pas ete trouvé" ;
        }
    }
?>

<?php require "./public/header.php"; ?>

<h1>Mot de passe oublié</h1>

<div class="register_container">
    <form method="POST" class="">
        <label for="email">Entrez votre email</label>
        <input type="text" name="email"/>
        <button class="button-primary" type="submit" value="Submit">Submit</button>
    </form>
</div>

<?php require "./public/footer.php" ?>