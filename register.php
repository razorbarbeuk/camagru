<?php 
if (!empty($_POST)) {
    session_start();
    require_once "./public/function.php";
    require_once "./config/connect_db.php";
    $errors = array();
    
    if (empty($_POST['firstname']) || !preg_match('/^[a-zA-Z]+$/', $_POST['firstname'])) {
        $errors['firstname'] = "Vous n'avez renseigné votre prénom";
    }

    if (empty($_POST['lastname']) || !preg_match('/^[a-zA-Z]+$/', $_POST['lastname'])) {
        $errors['lastname'] = "Vous n'avez renseigné votre nom";
    }

    if (empty($_POST['username']) || !preg_match('/^[a-zA-Z0-9_]+$/', $_POST['username'])) {
        $errors['username'] = "Vous n'avez renseigné votre username";
    } else {
        $req = $connect->prepare("SELECT id FROM users WHERE username = ?");
        $req->execute([$_POST['username']]);
        $user = $req->fetch();
        if($user) {
            $errors['username'] = "Ce pseudo est déja utilisé";
        }
    }

    if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Votre email n'est pas valide";
    }else{
        $req = $connect->prepare("SELECT id FROM users WHERE email = ?");
        $req->execute([$_POST['email']]);
        $mail = $req->fetch();
        if($mail) {
            $errors['email'] = "Ce mail est déja utilisé";
        }
    }

    if (empty($_POST['password']) || $_POST['password'] != $_POST['confirm_password']) {
        $errors['password'] = "Vous devez rentrer un password valide";
    }

    if (empty($errors)) {
        $req = $connect->prepare("INSERT INTO users SET firstname = ?, lastname = ?, username = ?, password = ?, email = ?, confirmed_token = ?");
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $token = str_random(60);
        $req->execute([$_POST['firstname'], $_POST['lastname'], $_POST['username'], $password, $_POST['email'], $token]);
        $user_id = $connect->lastInsertId();
        mail($_POST['email'], 'Confirmation de votre compte', "Afin de valider votre compte, merci de cliquer sur le lien suivant\n\nhttp://localhost:8000/confirm.php?id=$user_id&token=$token");
        $_SESSION['flash']['success'] = 'Un email de confirmation vous a été envoyé pour valider votre compte';
        header('Location: login.php');
        exit();
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