<?php
require_once "./public/bootstrap.php";

if (!empty($_POST)) {
    $errors = array();
    $db = App::getDatabase();

    $valide = new Validation($_POST);
    $valide->isString('firstname', "Vous n'avez pas ou mal renseigné votre prénom");
    $valide->isString('lastname', "Vous n'avez pas ou mal renseigné votre nom");
    $valide->isAlpha('username', "Votre pseudo n'est pas valide (alphanumerique)");
    if ($valide->isValid()) {
        $valide->isUniq('username', $db, 'users', "Ce pseudo est déja utilisé");
    }
    $valide->isEmail('email', "Votre email n'est pas valide");
    if ($valide->isValid()) {
        $valide->isUniq('email', $db, 'users', "Cet email est déja utilisé");
    }
    $valide->isConfirmed('password', "Vous devez rentrer un password valide");
    if ($valide->isValid()) {
        App::getAuth()->register($db, $_POST['firstname'], $_POST['lastname'], $_POST['username'], $_POST['email'], $_POST['password']);
        Session::getInstance()->setFlash('success', "Un email de confirmation vous a été envoyé pour valider votre compte");
        App::redirect('login.php');
    } else {
        $errors = $valide->getErrors();
    }
}
?>

<?php require "./public/header.php" ?>

<?php if(!empty($errors)): ?>
    <div class="alert alert-danger">
        <p>Vous n'avez remplis le formulaire correctement</p>
        <ul>
            <?php foreach($errors as $error): ?>
                <li><?=$error; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<h1>S'incrire</h1>

<div class="register_container">
    <form method="POST" class="">
        <label for="firstname">firstname</label>
        <input type="text" name="firstname"/>
        <label for="lastname">lastname</label>
        <input type="text" name="lastname"/>
        <label for="username">username</label>
        <input type="text" name="username"/>
        <label for="email">email</label>
        <input type="email" name="email"/>
        <label for="password">mot de passe</label>
        <input type="password" name="password"/>
        <label for="confirm_password">confirmez votre mot de passe</label>
        <input type="password" name="confirm_password"/>
        <button class="button-primary" type="submit" value="Submit">Submit</button>
    </form>
</div>

<?php require "./public/footer.php" ?>