<?php
    require_once "./public/bootstrap.php"; 
    if (!empty($_POST) && !empty($_POST['email'])) {
        $db = App::getDatabase();
        $auth = App::getAuth();
        $session = Session::getInstance();
        if ($auth->forget($db, $_POST['email'])){
            $session->setFlash('success', 'Un email vous a ete envoyé');
            App::redirect('login.php');
        } else {
            $session->setFlash('danger', "l'email n'a pas ete trouvé");
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