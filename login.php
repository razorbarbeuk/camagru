<?php 
    require_once "./public/bootstrap.php";
    $auth = App::getAuth();
    $db = App::getDatabase();
    $auth->connectFromCookie($db);
    if ($auth->isConnect()) {
        App::redirect('account.php');
    }
    if (!empty($_POST) && !empty($_POST['username']) && !empty($_POST['password'])){
        $user = $auth->login($db, $_POST['username'], $_POST['password'], isset($_POST['remember']));
        $session = Session::getInstance();
        if ($user) {
            $session->setFlash('success', 'Vous êtes maintenant connecté');
            App::redirect('account.php');
        } else {
            $session->setFlash('danger', 'Identifiant ou mot de passe incorrecte');
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