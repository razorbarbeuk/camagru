<?php 
    if (isset($_GET['id']) && isset($_GET['token'])) {
        $auth = App::getAuth();
        $db = App::getDatabase();
        $user = $auth->checkResetToken($db, $_GET['id'], $_GET['token']);
        if ($user) {
            if (!empty($_POST)) {
                if (!empty($_POST['password']) && $_POST['password'] == $_POST['confirm_password']) {
                    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
                    $connect->prepare("UPDATE users SET password = ?, reset_token = NULL, reset_at = NULL")->execute([$password]);
                    session_start();
                    $_SESSION['flash']['danger'] = "Votre mot de passe a bien ete change";
                    $_SESSION['auth'] = $user;
                    header('Location: account.php');
                    exit(); 
                }
            } else {
                session_start();
                $_SESSION['flash']['danger'] = "Ce token n'est plus valide";
                header('Location: login.php');
                exit();
            }
        } else {
            header('Location: login.php');
            exit();
        }
?>

<?php require "./public/header.php"; ?>

<h1>Se connecter</h1>

<div class="register_container">
    <form method="POST" class="">
        <label for="password">mot de passe</label>
        <input type="password" name="password"/>
        <label for="confirm_password">Confirmez votre mot de passe</label>
        <input type="password" name="confirm_password"/>
        <button class="button-primary" type="submit" value="Submit">Submit</button>
    </form>
</div>

<?php require "./public/footer.php" ?>