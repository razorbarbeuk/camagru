<?php
    require "./public/function.php";
    logged();

    if (!empty($_POST)) {

        if (empty($_POST['password']) || ($_POST['password'] != $_POST['confirm_password'])) {
            $_SESSION['flash']['danger'] = "les mots de passe ne correspondent pas";
        } else {
            $user_id = $_SESSION['auth']->id;
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
            require_once "./config/connect_db.php";
            $connect->prepare("UPDATE users SET password = ? WHERE id = ?")->execute([$password, $user_id]);
            $_SESSION['flash']['success'] = "Votre mots de passe à bien été mis à jour";
        }
    }

    require "./public/header.php"
?>

<h1>Bonjour <?= $_SESSION['auth']->username; ?></h1>

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
        <label for="confirm_password">Confirmez votre mot de passe</label>
        <input type="password" name="confirm_password"/>
        <button class="button-primary" type="submit" value="Submit">Submit</button>
    </form>
</div>

<?php require "./public/footer.php" ?>