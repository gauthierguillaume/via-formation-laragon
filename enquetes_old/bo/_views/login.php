<?php 
	include($_SERVER['DOCUMENT_ROOT'].'/host.php');

    if(isset($_POST['login'])){
        if(!empty($_POST['user_mail']) && !empty($_POST['user_pwd'])){
            $mail = htmlspecialchars($_POST['user_mail']);
            $pwd = $_POST['user_pwd'];

            $selectUser = $db->prepare('SELECT * 
                FROM users 
                NATURAL JOIN roles
                WHERE user_mail = ?');
            $selectUser->execute([$mail]);
            $user = $selectUser->fetch();

            if(password_verify($pwd, $user['user_pwd'])) {

                $_SESSION['admin'] = $user;

                echo
                    "<script language='javascript'>
                        document.location.replace('../index.php?zone=dashboard')
                    </script>";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion au Back Office</title>
    <link rel="stylesheet" href="<?php $_SERVER['DOCUMENT_ROOT']?>/styles/style.css" />
    <link rel="stylesheet" href="<?php $_SERVER['DOCUMENT_ROOT']?>/styles/generic.css" />
</head>
<body>
    <div class="login flexRow acCenter jcCenter">
        <form method="POST" class="flexCol">

            <label for="">Votre email</label>
            <input type="email" name="user_mail">

            <label for="">Votre mot de passe</label>
            <input type="password" name="user_pwd">

            <input type="submit" value="Se connecter" name="login">
        </form>
    </div>
</body>
</html>