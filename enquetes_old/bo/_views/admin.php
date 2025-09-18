<?php 
include($_SERVER['DOCUMENT_ROOT'].'/host.php');

if(isset($_SESSION['admin'])){ 
    include($_SERVER['DOCUMENT_ROOT'].'/bo/_blocks/header.php');
    include($_SERVER['DOCUMENT_ROOT'].'/bo/_blocks/sidebar.php');

    $domaine = "Admin";
    $sousDomaine = "Personnaliser les enquêtes";

    include($_SERVER['DOCUMENT_ROOT'].'/bo/_blocks/ariane.php');

    if(isset($_GET['action']) && $_GET['action'] == 'addSujet') {
        if(isset($_POST['add_sujet'])){
            $sujet_name = $_POST['sujet_nom'];
            $addSujet = $db->prepare("INSERT INTO sujets SET sujet_nom = ?");
            $addSujet->execute([$sujet_name]);

            echo
            "<script language='javascript'>
                document.location.replace('admin.php?zone=admin')
            </script>";

            }
        ?>
            <h1>Inserer un nouveau sujet</h1>
            <form method="POST" class="flexCol formSujet">
                <div>
                    <input type="text" name="sujet_nom">
                    <input type="submit" value="Ajouter" name="add_sujet">
                </div>
            </form>
        <?php

    }else if(isset($_GET['action']) && $_GET['action'] == 'addUser') {

        $selectCivilities = $db->prepare('SELECT * FROM civilities');
        $selectCivilities->execute();

        $selectRoles = $db->prepare('SELECT * FROM roles');
        $selectRoles->execute();

        $selectAllUsers = $db->prepare('SELECT * FROM users 
        NATURAL JOIN civilities
        NATURAL JOIN roles');
        $selectAllUsers->execute();

        if(isset($_POST['add_user'])){
            $errors = [];

            if(empty($_POST['id_civility'])) {
                $errors['civility'] = "Veuillez sélectionner une civilité";
            }

            if(empty($_POST['user_last_name']) || !preg_match('/^[a-zA-Z -]+$/', $_POST['user_last_name'])) {
                $errors['user_last_name'] = 'Le champs "Nom" n\'est pas correcte';
            }

            if(empty($_POST['user_first_name']) || !preg_match('/^[a-zA-Z -]+$/', $_POST['user_first_name'])) {
                $errors['user_first_name'] = 'Le champs "Prénom" n\'est pas correcte';
            }

            if(empty($_POST['user_mail']) || !filter_var($_POST['user_mail'], FILTER_VALIDATE_EMAIL)) {
                $errors['user_mail'] = "Votre email n'est pas valide";
            }else{
                $searchEmail = $db->prepare('SELECT id_user FROM users WHERE user_mail = ?');
                $searchEmail->execute([$_POST['user_mail']]);
                $email = $searchEmail->fetch();

                if($email){
                    $errors['user_mail'] = "Cet email est déjà utilisé";
                }
            }

            if(empty($_POST['id_role'])) {
                $errors['id_role'] = "Veuillez sélectionner un rôle";
            }

            if(empty($_POST['user_pwd']) || $_POST['user_pwd'] != $_POST['conf_pwd']) {
                $errors['user_pwd'] = "Vos mots de passe ne sont pas identiques";
            }

            if(empty($errors)) {
                $id_civility = htmlspecialchars($_POST['id_civility']);
                $last_name = htmlspecialchars($_POST['user_last_name']);
                $first_name = htmlspecialchars($_POST['user_first_name']);
                $mail = htmlspecialchars($_POST['user_mail']);
                $pwd = $_POST['user_pwd'];
                $id_role = htmlspecialchars($_POST['id_role']);

                $insert_User = $db->prepare('INSERT INTO users SET 
                    id_civility = ?,
                    user_last_name = ?,
                    user_first_name = ?,
                    user_mail = ?,
                    user_pwd = ?,
                    id_role = ?');
                $password = password_hash($pwd, PASSWORD_ARGON2I);
                $insert_User->execute([$id_civility, $last_name, $first_name, $mail, $password, $id_role]);

                echo
                "<script language='javascript'>
                    document.location.replace('admin.php?action=addUser&zone=admin')
                </script>";
            }
        }

        if(!empty($errors)){
            foreach($errors as $error){
                ?>
                    <p><?php echo $error;?></p>
                <?php
            }
        }

        ?>
            <div class="flexRow jcCenter formUser">
                <form method="POST" class="flexCol">
                        <select name="id_civility" id="">
                            <?php
                                while($sC = $selectCivilities->fetch(PDO::FETCH_OBJ)){
                                    ?>
                                        <option value="<?php echo $sC->id_civility;?>"><?php echo $sC->civility_name;?></option>
                                    <?php
                                }
                            ?>
                        </select>

                        <label for="">Votre nom</label>
                        <input type="text" name="user_last_name" required>

                        <label for="">Votre prénom</label>
                        <input type="text" name="user_first_name" required>

                        <label for="">Votre email</label>
                        <input type="mail" name="user_mail" required>   

                        <select name="id_role" id="">
                            <?php
                                while($sC = $selectRoles->fetch(PDO::FETCH_OBJ)){
                                    ?>
                                        <option value="<?php echo $sC->id_role;?>"><?php echo $sC->role_name;?></option>
                                    <?php
                                }
                            ?>

                        </select>

                        <label for="">Votre mot de passe</label>
                        <input type="text" name="user_pwd" required>

                        <label for="">Confirmez votre mot de passe</label>
                        <input type="password" name="conf_pwd" required>

                        <input type="submit" value="Ajouter l'utilisateur" name="add_user">
                </form>
            </div>

            <div class="records table-responsive">
                <div class="record-header">
                    <?php
                        include($_SERVER['DOCUMENT_ROOT'].'/bo/_blocks/nav_admin.php');
                    ?>
                    <div class="browse">
                        <input type="search" placeholder="Search" class="record-search" />
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
                                <th class="uppercase"><span class="las la-sort"></span> rôle</th>
                                <th><span class="las la-sort"></span> ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                while($sAU = $selectAllUsers->fetch(PDO::FETCH_OBJ)){	
                            ?>
                                <tr>
                                <td><?php echo $sAU->id_user; ?></td>
                                <td>
                                <div class="client">
                                    <div class="client-img bg-img" style="background-image: url(<?php $_SERVER['DOCUMENT_ROOT']?>/bo//img/3.jpeg)"></div>
                                    <div class="client-info">
                                        <h4><?php echo $sAU->user_first_name;?> <?php echo $sAU->user_last_name;?></h4>
                                        <small><?php echo $sAU->user_mail; ?></small>
                                    </div>
                                </div>
                                </td>
                                <td><?php echo $sAU->civility_name; ?></td>
                                <td><?php echo $sAU->role_name; ?></td>
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
            }else{
                $selectAllSujets = $db->prepare('SELECT * FROM sujets');
                $selectAllSujets->execute();
        ?>

        <div class="records table-responsive">
            <div class="record-header">
                <?php
                    include($_SERVER['DOCUMENT_ROOT'].'/bo/_blocks/nav_admin.php');
                ?>

                <div class="browse">
                    <input type="search" placeholder="Search" class="record-search" />
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
                            <th><span class="las la-sort"></span> SUJETS</th>
                            <th><span class="las la-sort"></span> REPONSES</th>
                            <th><span class="las la-sort"></span> DATE CREATION</th>
                            <th><span class="las la-sort"></span> ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            while($sAS = $selectAllSujets->fetch(PDO::FETCH_OBJ)){	
                        ?>
                        <tr>
                        <td><?php echo $sAS->id_sujet; ?></td>
                        <td>
                            <div class="client">
                                <div class="client-info">
                                    <h4><?php echo $sAS->sujet_nom; ?></h4>
                                </div>
                            </div>
                        </td>
                        <td>$3171</td>
                        <td><?php echo $sAS->sujet_date; ?></td>
                        <td>
                            <div class="actions">
                                <a href="<?php $_SERVER['DOCUMENT_ROOT']?>/bo/_views/sujet.php?id=<?php echo $sAS->id_sujet;?>&zone=sujet"><span class="lab la-telegram-plane"></span></a>
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
            include($_SERVER['DOCUMENT_ROOT'].'/bo/_blocks/footer.php');
}else{
    echo
    "<script language='javascript'>
        document.location.replace(".$_SERVER['DOCUMENT_ROOT']."'/login.php')
    </script>";
}