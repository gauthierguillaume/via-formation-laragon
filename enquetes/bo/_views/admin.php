<?php

include($_SERVER['DOCUMENT_ROOT'] . '/host.php');

if (isset($_SESSION['admin'])) {
    // var_dump($_SESSION['admin']);

    include($_SERVER['DOCUMENT_ROOT'] . '/bo/_blocks/sidebar.php');

    include($_SERVER['DOCUMENT_ROOT'] . '/bo/_blocks/header.php');

    $domaine = "Home";
    $sousDomaine = "Admin";

    include($_SERVER['DOCUMENT_ROOT'] . '/bo/_blocks/ariane.php');

    if (isset($_GET['action']) && $_GET['action'] == "addSujet") {

        if (isset($_POST['add_sujet'])) {
            $sujet_name = $_POST['sujet_nom'];

            $addSujet = $db->prepare('INSERT INTO sujets SET
                    sujet_nom = ?
                ');
            $addSujet->execute([$sujet_name]);

            echo "<script language='javascript'>
                        document.location.replace('admin.php?zone=admin')
                    </script>";
        }

?>

        <h1>Insérer un nouveau sujet</h1>
        <form method="POST" class="formSujet flexCol">
            <input type="text" name="sujet_nom">

            <div>
                <input type="submit" value="Enregistrer" name="add_sujet">
            </div>
        </form>
        <?php

    } else if (isset($_GET['action']) && $_GET['action'] == "addUser") {

        $selectCivilities = $db->prepare('SELECT * FROM civilities');
        $selectCivilities->execute();

        $selectRoles = $db->prepare('SELECT * FROM roles');
        $selectRoles->execute();

        $selectAllUser = $db->prepare('SELECT * FROM users
                NATURAL JOIN civilities
                NATURAL JOIN roles
            ');
        $selectAllUser->execute();

        if (isset($_POST['addUser'])) {
            $errors = array();

            if (empty($_POST['id_civility'])) {
                $errors['civility'] = "Vous n'avez pas sélectionné de civilité.";
            }

            if (empty($_POST['user_last_name']) || !preg_match('/^[a-zA-Z -]+$/', $_POST['user_last_name'])) {
                $errors['user_last_name'] = 'Le champs "Nom" n\'est pas correcte.';
            }

            if (empty($_POST['user_first_name']) || !preg_match('/^[a-zA-Z -]+$/', $_POST['user_first_name'])) {
                $errors['user_first_name'] = 'Le champs "Prénom" n\'est pas correcte.';
            }

            if (empty($_POST['user_mail']) || !filter_var($_POST['user_mail'], FILTER_VALIDATE_EMAIL)) {
                $errors['user_mail'] = "Votre Email n'est pas valide.";
            } else {
                $searchEmail = $db->prepare('SELECT id_user FROM users WHERE user_mail = ?');
                $searchEmail->execute([$_POST['user_mail']]);
                $email = $searchEmail->fetch();
                if ($email) {
                    $errors['user_mail'] = "Cet email est déjà utilisé.";
                }
            }

            if (empty($_POST['id_role'])) {
                $errors['role'] = "Vous n'avez pas sélectionné de rôle à cet utilisateur.";
            }

            if (empty($_POST['user_pwd']) || $_POST['user_pwd'] != $_POST['conf_pwd']) {
                $errors['user_pwd'] = "Vos mots de passe ne sont pas identiques.";
            }

            if (empty($errors)) {
                $id_civility = htmlspecialchars($_POST['id_civility']);
                $last_name = htmlspecialchars($_POST['user_last_name']);
                $first_name = htmlspecialchars($_POST['user_first_name']);
                $mail = htmlspecialchars($_POST['user_mail']);
                $pwd = $_POST['user_pwd'];
                $token = str_random(60);
                $id_role = htmlspecialchars($_POST['id_role']);
                $insert_user = $db->prepare('INSERT INTO users SET
                        id_civility = ?,
                        user_last_name = ?,
                        user_first_name = ?,
                        user_mail = ?,
                        user_pwd = ?,
                        user_token = ?,
                        id_role = ?
                    ');
                $password = password_hash($pwd, PASSWORD_ARGON2I);
                $insert_user->execute([$id_civility, $last_name, $first_name, $mail, $password, $token, $id_role]);

                $id_user = $db->lastInsertId();

                $entete = 'MIME-Version: 1.0' . "\r\n";
                $entete .= 'Content-Type: text/html; charset="UTF-8"' . "\r\n";
                $entete .= 'from: gauthier.guigz@gmail.com' . "\r\n";

                $message = '
                        <h1 style="text-align:center">Bienvenue sur le back-office</h1>
                        <p>Voici le lien qui vous emmenera sur le systeme de gestion BO</p>
                        <a href="http://enquetes.test/bo/_views/login.php?id_user=' . $id_user . '&token=' . $token . '">Cliquez ici</a>
                        <p>N\'oubliez pas de modifier votre mot de passe une fois connecté : http://enquetes.test/bo/_views/login.php?id_user=' . $id_user . '&token=' . $token . '</p>
                        <p>Si le lien ne fonctionne pas, copier ce lien dans votre navigateur.</p>
                        <h2>L\'équipe du BO</h2>
                    ';

                mail($mail, 'Lien de connexion au back-office', $message, $entete);

                $_SESSION['flash']['success'] = "L'utilisateur a bien été ajouté.";

                echo "<script language='javascript'>
                            document.location.replace('admin.php?action=addUser&zone=admin')
                        </script>";
            }
        }

        if (!empty($errors)) {
            foreach ($errors as $error) {
        ?>
                <p><?php echo $error; ?></p>

        <?php
            }
        }

        ?>
        <div class="flexRow justifyCenter formUser">
            <form method="POST" class="flexCol">

                <label for="">Votre civilité</label>
                <select name="id_civility" id="">
                    <?php
                    while ($sC = $selectCivilities->fetch(PDO::FETCH_OBJ)) {
                    ?>
                        <option value="<?php echo $sC->id_civility; ?>"><?php echo $sC->civility_name; ?></option>
                    <?php

                    }
                    ?>

                </select>

                <label for="">Votre nom</label>
                <input type="text" name="user_last_name" required>

                <label for="">Votre prénom</label>
                <input type="text" name="user_first_name" required>

                <label for="">Votre Email</label>
                <input type="email" name="user_mail" required>

                <label for="">Votre rôle</label>
                <select name="id_role" id="">
                    <?php
                    while ($sR = $selectRoles->fetch(PDO::FETCH_OBJ)) {
                    ?>
                        <option value="<?php echo $sR->id_role; ?>"><?php echo $sR->role_name; ?></option>
                    <?php
                    }
                    ?>
                </select>

                <label for="">Votre mot de passe</label>
                <input type="password" name="user_pwd" required>

                <label for="">Confirmez votre mot de passe</label>
                <input type="password" name="conf_pwd" required>

                <input type="submit" value="Ajouter l'utilisateur" name="addUser">

            </form>
        </div>

        <div class="records table-responsive">

            <div class="record-header">
                <?php include($_SERVER['DOCUMENT_ROOT'] . '/bo/_blocks/navAdmin.php'); ?>

                <div class="browse">
                    <input type="search" placeholder="Search" class="record-search">
                    <select name="" id="">
                        <option value="">Status</option>
                    </select>
                </div>
            </div>

            <div>
                <table width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th><span class="las la-sort"></span> UTILISATEUR</th>
                            <th class="uppercase"><span class="las la-sort"></span> civilité</th>
                            <th><span class="las la-sort"></span> ROLE</th>
                            <th><span class="las la-sort"></span> ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($sAu = $selectAllUser->fetch(PDO::FETCH_OBJ)) {
                        ?>
                            <tr>
                                <td><?php echo $sAu->id_user; ?></td>
                                <td>
                                    <div class="client">
                                        <div class="client-img bg-img" style="background-image: url(<?php $_SERVER['DOCUMENT_ROOT'] ?>/bo/_imgs/Ous.jpeg)"></div>
                                        <div class="client-info">
                                            <h4><?php echo $sAu->user_first_name; ?> <?php echo $sAu->user_last_name; ?></h4>
                                            <small><?php echo $sAu->user_mail; ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <?php echo $sAu->civility_name; ?>
                                </td>
                                <td>
                                    <?php echo $sAu->role_name; ?>
                                </td>
                                <td>
                                    <div class="actions">
                                        <a href=""><span class="lab la-telegram-plane"></span></a>
                                        <span class="las la-eye"></span>
                                        <span class="las la-ellipsis-v"></span>
                                    </div>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>


                    </tbody>
                </table>
            </div>

        </div>

    <?php

    } else {

        $selectAllSujets = $db->prepare('SELECT * FROM sujets');
        $selectAllSujets->execute();

    ?>

        <div class="records table-responsive">

            <div class="record-header">

                <?php include($_SERVER['DOCUMENT_ROOT'] . '/bo/_blocks/navAdmin.php'); ?>

                <div class="browse">
                    <input type="search" placeholder="Search" class="record-search">
                    <select name="" id="">
                        <option value="">Status</option>
                    </select>
                </div>
            </div>

            <div>
                <table width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th><span class="las la-sort"></span> SUJET</th>
                            <th><span class="las la-sort"></span> REPONSES</th>
                            <th><span class="las la-sort"></span> DATE DE CREATION</th>
                            <th><span class="las la-sort"></span> ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($sAs = $selectAllSujets->fetch(PDO::FETCH_OBJ)) {
                        ?>
                            <tr>
                                <td><?php echo $sAs->id_sujet; ?></td>
                                <td>
                                    <div class="client">
                                        <div class="client-info">
                                            <h4><?php echo $sAs->sujet_nom; ?></h4>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    $3171
                                </td>
                                <td>
                                    <?php echo $sAs->sujet_date; ?>
                                </td>
                                <td>
                                    <div class="actions">
                                        <a href="<?php $_SERVER['DOCUMENT_ROOT'] ?>/bo/_views/sujet.php?id=<?php echo $sAs->id_sujet; ?>&zone=sujets>">
                                            <span class="lab la-telegram-plane"></span></a>
                                        <span class="las la-eye"></span>
                                        <span class="las la-ellipsis-v"></span>
                                    </div>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>


                    </tbody>
                </table>
            </div>

        </div>

    <?php

    }
    ?>

<?php

    include($_SERVER['DOCUMENT_ROOT'] . '/bo/_blocks/footer.php');
} else {
    echo "<script language='javascript'>
            document.location.replace(" . $_SERVER['DOCUMENT_ROOT'] . "'/login.php')
        </script>";
}

?>