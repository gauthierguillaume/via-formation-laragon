<?php
include($_SERVER['DOCUMENT_ROOT'] . '/host.php');

if (isset($_SESSION['auth']) && $_SESSION['auth']['role_level'] > 99) {

    include($_SERVER['DOCUMENT_ROOT'] . '/bo/_blocks/sidebar.php');

    include($_SERVER['DOCUMENT_ROOT'] . '/bo/_blocks/header.php');

    $domaine = "Dashboard";
    $sousDomaine = "Admin / Liste des utilisateurs";

    include($_SERVER['DOCUMENT_ROOT'] . '/bo/_blocks/ariane.php');

    if (isset($_GET['action']) && $_GET['action'] == "addUser") {

        $selectCivilites = $db->prepare('SELECT * FROM civilites');
        $selectCivilites->execute();

        $selectRoles = $db->prepare('SELECT * FROM roles');
        $selectRoles->execute();

        if (isset($_POST['addUser'])) {

            $errors = array(); //ou $errors= [];

            if (empty($_POST['id_civilite'])) {
                $errors['civilite'] = "Vous devez sélectionner une civilité.";
            }

            if (empty($_POST['user_name']) || !preg_match('/^[a-zA-Z -]+$/', $_POST['user_name'])) {
                $errors['user_name'] = 'Le champs "Nom" n\'est pas valide.';
            }

            if (empty($_POST['user_firstname']) || !preg_match('/^[a-zA-Z -]+$/', $_POST['user_firstname'])) {
                $errors['user_firstname'] = 'Le champs "Prénom" n\'est pas valide.';
            }

            if (empty($_POST['user_mail']) || !filter_var($_POST['user_mail'], FILTER_VALIDATE_EMAIL)) {
                $errors['user_mail'] = "Votre mail n'est pas valide.";
            } else {
                $req = $db->prepare('SELECT * FROM users WHERE user_mail = ?');
                $req->execute([$_POST['user_mail']]);
                $email = $req->fetch();
                if ($email) {
                    $errors['user_mail'] = "L'email est déjà présent dans la base de données.";
                }
            }

            if (empty($_POST['id_role'])) {
                $errors['role'] = "Vous devez sélectionner un rôle.";
            }

            if (empty($_POST['user_pwd']) || $_POST['user_pwd'] != $_POST['conf_pwd']) {
                $errors['user_pwd'] = "Les mots de passe ne sont identiques.";
            }

            if (empty($errors)) {
                $id_civilite = $_POST['id_civilite'];
                $name = $_POST['user_name'];
                $firstname = $_POST['user_firstname'];
                $mail = $_POST['user_mail'];
                $id_role = $_POST['id_role'];
                $pwd = $_POST['user_pwd'];
                $insert_user = $db->prepare('INSERT INTO users SET
                    id_civilite = ?,
                    user_name = ?,
                    user_firstname = ?,
                    user_mail = ?,
                    id_role = ?,
                    user_pwd = ?
                ');
                $password = password_hash($pwd, PASSWORD_ARGON2I);
                $insert_user->execute([$id_civilite, $name, $firstname, $mail, $id_role, $password]);
            }
        }

?>

        <div class="flexRow justifyCenter">
            <?php
            if (!empty($errors)) {
                foreach ($errors as $error) {
            ?>
                    <li><?php echo $error; ?></li>
            <?php
                }
            }
            ?>

            <div class="container">
                <div class="form-box register">
                    <form method="POST">
                        <h1>Ajouter un utilisateur</h1>

                        <div class="input-box">
                            <select name="id_civilite">
                                <?php
                                while ($sC = $selectCivilites->fetch(PDO::FETCH_OBJ)) {
                                ?>
                                    <option value="<?php echo $sC->id_civilite; ?>"><?php echo $sC->civilite_titre; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>

                        <div class="input-box">
                            <input type="text" placeholder="Nom" name="user_name" required />
                            <i class="bx bxs-user"></i>
                        </div>

                        <div class="input-box">
                            <input type="text" placeholder="Prénom" name="user_firstname" required />
                            <i class="bx bxs-user"></i>
                        </div>

                        <div class="input-box">
                            <input type="email" placeholder="Email" name="user_mail" required />
                            <i class="bx bxs-envelope"></i>
                        </div>

                        <div class="input-box">
                            <select name="id_role">
                                <?php
                                while ($sR = $selectRoles->fetch(PDO::FETCH_OBJ)) {
                                ?>
                                    <option value="<?php echo $sR->id_role; ?>"><?php echo $sR->role_name; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>

                        <div class="input-box">
                            <input type="password" placeholder="Mot de passe" name="user_pwd" id="pswrd" onkeyup="checkPassword(this.value)" required />
                            <i class="bx bxs-lock-alt"></i>
                        </div>

                        <div class="input-box">
                            <input type="password" placeholder="Confirmer" name="conf_pwd" required />
                            <i class="bx bxs-lock-alt"></i>
                        </div>

                        <div class="validation">
                            <ul>
                                <li id="lower">Au moins une minuscule</li>
                                <li id="upper">Au moins une majuscule</li>
                                <li id="number">Au moins un chiffre</li>
                                <li id="special">Au moins un caractère spécial</li>
                                <li id="length">Au moins 8 caractères</li>
                            </ul>
                        </div>

                        <input type="submit" class="btn" name="addUser" value="Enregistrer">

                        <p>or register with social platforms</p>
                        <div class="social-icons">
                            <a href="#"><i class="bx bxl-google"></i></a>
                            <a href="#"><i class="bx bxl-facebook"></i></a>
                            <a href="#"><i class="bx bxl-github"></i></a>
                            <a href="#"><i class="bx bxl-linkedin"></i></a>
                        </div>
                    </form>
                </div>
            </div>

        </div>

    <?php
    } else if (isset($_GET['action']) && $_GET['action'] == "user") {

        $id = $_GET['id'];

        if (isset($_POST['add'])) {
            $img = noAccent($_FILES['image']['name']);
            $tmp_img = $_FILES['image']['tmp_name'];
            $error = $_FILES['image']['error'];
            $size = $_FILES['image']['size'];
            $type = $_FILES['image']['type'];

            $ext = explode('/', $type);
            $img_ext = end($ext);

            if ($error == 0) {
                if ($size < 5000000) {
                    if ($img_ext === 'jpeg' || $img_ext === 'jpg' || $img_ext === 'png') {
                        $insertImg = $db->prepare(
                            'UPDATE users 
                            SET user_img = ?
                            WHERE id_user = ?
                        '
                        );

                        $insertImg->execute([$img, $id]);

                        move_uploaded_file($tmp_img, $_SERVER['DOCUMENT_ROOT'] . '/bo/_imgs/admin/' . $img);

                        $_SESSION['flash']['success'] = "L'image a bien été ajoutée.";

                        echo "<script language='javascript'>
                            document.location.replace('admin.php?zone=admin')
                            </script>";
                    } else {
                        $_SESSION['flash']['danger'] = "Le format de l'image n'est pas valide.";

                        echo "<script language='javascript'>
                            document.location.replace('admin.php?zone=admin&action=user&id=".$id."')
                            </script>";
                    }
                } else {
                    $_SESSION['flash']['danger'] = "L'image n'a pas pu être ajoutée.";

                    echo "<script language='javascript'>
                            document.location.replace('admin.php?zone=admin&action=user')
                            </script>";
                }
            }
        }
    ?>
        <form method="POST" enctype="multipart/form-data">
            <input type="file" name="image" accept=".jpg, .jpeg, .png">
            <input type="submit" value="Ajouter" name="add">
        </form>
    <?php

    } else {
        $selecAllUsers = $db->prepare('SELECT * FROM users NATURAL JOIN roles NATURAL JOIN civilites');
        $selecAllUsers->execute();

    ?>

        <div class="records table-responsive">

            <div class="record-header">
                <div class="add">
                    <span>Entries</span>
                    <select name="" id="">
                        <option value="">ID</option>
                    </select>
                    <a href="admin.php?zone=admin&action=addUser">Ajouter un utilisateur</a>
                </div>

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
                            <th><span class="las la-sort"></span> UTILISATEURS</th>
                            <th><span class="las la-sort"></span> ROLE</th>
                            <th><span class="las la-sort"></span> CIVILITE</th>
                            <th><span class="las la-sort"></span> ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($sAU = $selecAllUsers->fetch(PDO::FETCH_OBJ)) {
                        ?>
                            <tr>
                                <td>#<?php echo $sAU->id_user ?></td>
                                <td>
                                    <div class="client">
                                        <div class="client-img bg-img" style="background-image: url(<?php $_SERVER['DOCUMENT_ROOT'] ?>/bo/_imgs/admin/<?php echo $sAU->user_img ?>)"></div>
                                        <div class="client-info">
                                            <h4><?php echo ucwords($sAU->user_firstname) ?> <?php echo ucwords($sAU->user_name) ?></h4>
                                            <small><?php echo $sAU->user_mail ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td class="uppercase">
                                    <?php echo ($sAU->role_name) ?>
                                </td>
                                <td class="capitalize">
                                    <?php echo ($sAU->civilite_nom) ?>
                                </td>
                                <td>
                                    <div class="actions">
                                        <a href="admin.php?zone=admin&action=user&id=<?php echo $sAU->id_user; ?>"><span class="lab la-telegram-plane"></span></a>
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

    include($_SERVER['DOCUMENT_ROOT'] . '/bo/_blocks/footer.php');
} else {
    echo "<script language='javascript'>
        document.location.replace('login.php')
        </script>";
}

?> 