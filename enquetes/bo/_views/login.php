<?php
include($_SERVER['DOCUMENT_ROOT'] . '/host.php');
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion au Back Office</title>
    <link rel="stylesheet" href="<?php $_SERVER['DOCUMENT_ROOT'] ?>/styles/style.css">
    <link rel="stylesheet" href="<?php $_SERVER['DOCUMENT_ROOT'] ?>/styles/generic.css">
</head>

<body>

    <?php
    if (isset($_GET['token'])) {

        $id_user = $_GET['id_user'];
        $token = $_GET['token'];

        $selectUser = $db->prepare('SELECT * FROM users WHERE id_user = ? ');
        $selectUser->execute([$id_user]);
        $user = $selectUser->fetch(PDO::FETCH_OBJ);

        if ($user->user_token == $token) {
            if (isset($_POST['modifPwd'])) {
                if (!empty($_POST['user_pwd']) && $_POST['user_pwd'] == $_POST['conf_pwd']) {
                    $password = $_POST['user_pwd'];

                    $insert_mdp = $db->prepare('UPDATE users SET user_pwd = ?, user_token = NULL WHERE id_user = ?');
                    $pwd_hash = password_hash($password, PASSWORD_ARGON2I);
                    $insert_mdp->execute([$pwd_hash, $id_user]);

                    $findUser = $db->prepare('SELECT * FROM users NATURAL JOIN roles WHERE id_user = ? ');
                    $findUser->execute([$id_user]);
                    $find = $findUser->fetch();

                    $_SESSION['admin'] = $find;
                    $_SESSION['flash']['success'] = "Mot de passe modifié avec succès.";

                    echo "<script language='javascript'>
                            document.location.replace('../index.php?zone=dashboard')
                        </script>";
                }
            }
        }
    ?>
        <div class="login flexRow alignCenter justifyCenter">
            <form method="POST" class="flexCol">
                <label for="">Nouveau mot de passe</label>
                <input type="password" name="user_pwd">
                <label for="">Confirmer le mot de passe</label>
                <input type="password" name="conf_pwd">
                <input type="submit" value="Modifier" name="modifPwd">
            </form>
        </div>
    <?php

    } else {

        if (isset($_POST['login'])) {
            if (!empty($_POST['user_mail']) && !empty($_POST['user_pwd'])) {
                $mail = htmlspecialchars($_POST['user_mail']);
                $pwd = $_POST['user_pwd'];

                $selectUser = $db->prepare('SELECT * FROM users NATURAL JOIN roles WHERE user_mail = ? ');
                $selectUser->execute([$mail]);
                $user = $selectUser->fetch();

                $id_user = $user['id_user'];
                $token = $user['user_token'];

                if (empty($user['user_token'])) {

                    if (password_verify($pwd, $user['user_pwd'])) {

                        $_SESSION['admin'] = $user;

                        echo "<script language='javascript'>
                                document.location.replace('../index.php?zone=dashboard')
                            </script>";
                    }
                } else {

                    echo "<script language='javascript'>
                            document.location.replace('../login.php?id_user=$id_user&token=$token')
                        </script>";
                }
            }
        }
    ?>
        <div class="login flexRow alignCenter justifyCenter textCenter">
            <form method="POST" class="flexCol">
                <label for="">Votre Email</label>
                <input type="email" name="user_mail">
                <label for="">Votre mot de passe</label>
                <input type="password" name="user_pwd">
                <input type="submit" value="Se connecter" name="login">
            </form>
        </div>
    <?php
    }
    ?>

</body>

</html>