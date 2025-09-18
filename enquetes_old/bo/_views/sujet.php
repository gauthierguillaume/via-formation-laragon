<?php



include($_SERVER['DOCUMENT_ROOT'] . '/host.php');

if (isset($_SESSION['admin'])) {

    include($_SERVER['DOCUMENT_ROOT'] . '/bo/_blocks/sidebar.php'); //$_server et document root permet de revenir à la racine du site, évite les ../..
    include($_SERVER['DOCUMENT_ROOT'] . '/bo/_blocks/header.php');
    $domaine = "sujets";
    $sousDomaine = "liste des sujets";
    include($_SERVER['DOCUMENT_ROOT'] . '/bo/_blocks/ariane.php');







    if (isset($_GET["id"])) { //si il y a un ID dans le GET alors
        $id = $_GET['id'];

        //Sélection du sujet avec l'id récupéré dans le GET
        $selectSujet = $db->prepare('SELECT * FROM sujets 
            WHERE id_sujet = ?
        ');
        $selectSujet->execute([$id]);

        $sujet = $selectSujet->fetch(PDO::FETCH_OBJ);

        //Sélection des questions en lien avec le sujet
        $selectAllQuestions = $db->prepare('SELECT * FROM questions
            WHERE id_sujet = ?
        ');
        $selectAllQuestions->execute([$id]);

        //**Partie analytics

        /**On compte les utilisateurs ayant répondu au sujet */
        $countUtilisateurs = $db->prepare('SELECT * FROM utilisateurs
            WHERE utilisateur_mail LIKE "%@%"
            AND id_sujet = ?
        ');
        $countUtilisateurs->execute([$id]);
        $countMails = count($countUtilisateurs->fetchAll());

        //On compte les utilisateurs ayant répondu à au moins un sujet, avec une adresse mail valide
        $selectAllUtilisateurs = $db->prepare('SELECT * FROM utilisateurs
            WHERE utilisateur_mail LIKE "%@%"
        ');
        $selectAllUtilisateurs->execute();
        $mails = count($selectAllUtilisateurs->fetchAll());

        //Pourcentage de participiation à ce sujet
        $qty_pourcent = $countMails / $mails * 100;

        $countSujetQuestion = $db->prepare('SELECT * FROM sujets
            NATURAL JOIN questions
            WHERE sujets.id_sujet = ?
        ');
        $countSujetQuestion->execute([$id]);
        $count = count($countSujetQuestion->fetchAll());

        //Récupération de la variable $countMails
        $qty = $countMails;


        //Partie analytics**


        include($_SERVER['DOCUMENT_ROOT'] . '/bo/_blocks/analytics.php');

        if (isset($_POST["add_question"])) {
            $question = $_POST["questions_question"];

            $addQuestion = $db->prepare('INSERT INTO questions SET
                questions_question = ?,
                id_sujet = ?
            ');

            $addQuestion->execute([$question, $id]); //exécution de la variable, qui vont nourrir les marqueurs ou ?, dans l'ordre.

            //Rechargement de la page à l'issue
            echo "<script language='javascript'>
            document.location.replace('_views/sujet.php?id=" . $id . "&zone=sujets')
            </script>";
        }

        if (isset($_POST["modify_activ"])) { //si on clique sur le bouton modify_activ alors :
            if (!empty($_POST["sujet_activ"])) { //si l'input sujet_activ n'est pas vide alors on met à jour la BdD en mettant 1 au champ sujet_activ
                $sujetOn = $db->prepare('UPDATE sujets SET 
                    sujet_activ = ?
                    WHERE id_sujet = ?
                ');

                $sujetOn->execute([1, $id]);
            } else {  //sinon on met 0 
                $sujetOff = $db->prepare('UPDATE sujets SET 
                    sujet_activ = ?
                    WHERE id_sujet = ?
                ');

                $sujetOff->execute([0, $id]);
            }
            echo "<script language='javascript'>
                document.location.replace('sujet.php?zone=sujet')
                </script>";
        }




?>
        <!-- Bouton Active / Inactive -->
        <form method="POST" class="formSujet">
            <label class="switch-button" for="switch">
                <div class="switch-outer">
                    <input id="switch" type="checkbox" name="sujet_activ" <?php if ($sujet->sujet_activ == 1) {
                                                                                echo "checked";
                                                                            } ?>>
                    <div class="button">
                        <span class="button-toggle"></span>
                        <span class="button-indicator"></span>
                    </div>
                </div>
            </label>

            <input type="submit" value="Enregistrer" name="modify-activ">
        </form>

        <hr class="separator">
        <hr class="separator">

        <!-- Affichage du nom du sujet-->
        <h1><?php echo $sujet->sujet_nom; ?></h1>


        <form method="POST" class="flexCol formSujet">

            <p>Ajouter une question</p>

            <input type="text" name="questions_question">


            <div>
                <input type="submit" value="Ajouter" name="add_question">
            </div>

            <!-- Affichage du nombre de questions du sujet -->
            <p>Ce sujet comporte <?php echo $count; ?> questions</p>
        </form>

        <hr class="separator">


        <?php


        while ($sAQ = $selectAllQuestions->fetch(PDO::FETCH_OBJ)) { //récupération des questions et affichage
            $selectAllTypes = $db->prepare('SELECT * FROM question_types');
            $selectAllTypes->execute();

            $id_question = $sAQ->id_question;

            $selectReponse = $db->prepare('SELECT * FROM questions_rep_poss
                NATURAL JOIN questions
                NATURAL JOIN rep_poss
                NATURAL JOIN question_types
                WHERE id_question = ?
            ');
            $selectReponse->execute([$id_question]);


            if (isset($_POST['add_reponse_' . $sAQ->id_question])) {
                $reponse = $_POST['rep_poss_reponse_' . $sAQ->id_question];
                $type = $_POST["id_question_type_" . $sAQ->id_question];

                $addReponse = $db->prepare('INSERT INTO rep_poss SET
                    rep_poss_reponse = ?,
                    id_question_type = ?
                ');

                $addReponse->execute([$reponse, $type]); //exécution de la variable, qui vont nourrir les marqueurs ou ?, dans l'ordre.

                $last_id = $db->lastInsertId(); //php récupère le numero d'id entrer en dernier

                $question_reponse = $db->prepare('INSERT INTO questions_rep_poss SET
                    id_question = ?,
                    id_rep_poss = ?

                ');
                $question_reponse->execute([$id_question, $last_id]);


                //Recharger la page automatiquement en javascript
                echo "<script language='javascript'> 
                        document.location.replace('sujet.php?id=" . $id . "&zone=sujets')
                    </script>";
            }

        ?>
            <p><?php echo $sAQ->question_question; ?></p>

            <form method="POST" class="flexCol formSujet">
                <input type="text" name="rep_poss_reponse_<?php echo $sAQ->id_question; ?>">
                <div>
                    <select name="id_question_type_<?php echo $sAQ->id_question; ?>">
                        <?php
                        while ($sAT = $selectAllTypes->fetch(PDO::FETCH_OBJ)) { //$sAT  pour récupérer les valeurs de $selectAllTypes, fetch récupère une ligne des résultats,  et la transforme en objet
                        ?>
                            <option value="<?php echo $sAT->id_question_type; ?>"><?php echo $sAT->question_type_nom; ?></option> <!-- affichage en html via le php de la colonne question_type_nom -->
                        <?php
                        }
                        ?>

                    </select>
                </div>
                <div>
                    <input type="submit" value="Enr." name="add_reponse_<?php echo $sAQ->id_question; ?>">
                </div>
            </form>

            <p>liste des réponses à cette question :</p>

            <?php

            while ($sR = $selectReponse->fetch(PDO::FETCH_OBJ)) { //$sAT  pour récupérer les valeurs de $selectAllTypes, fetch récupère une ligne des résultats,  et la transforme en objet

                $countReponsesQuestion = $db->prepare('SELECT * FROM reponses_questions
                    WHERE id_question = ?  
            ');
                $countReponsesQuestion->execute([$id_question]);
                $countReponses = count($countReponsesQuestion->fetchAll());

                // je compte le nombre de personnes ayant répondu à cette question
                $countReponsesUtilisateurs = $db->prepare('SELECT * FROM reponses_questions
                    NATURAL JOIN reponses
                    WHERE id_reponse = ?
            ');
                $countReponsesUtilisateurs->execute([$id_reponse]);
                $cRU = count($countReponsesUtilisateurs->fetchAll());

                $cRU_pourcent = $cRU / $qty * 100;
            ?>
                <p><?php echo $sR->rep_poss_reponse; ?> - <?php echo $sR->question_type_nom; ?> - <?php echo $cRU_pourcent; ?>%</p> <!-- affichage en html via le php de la colonne question_type_nom -->
            <?php
            }
            ?>
            <hr class="separator"><?php
                                }
                            } else { // si pas d'id dans le GET affichage du message d'erreur
                                $selectAllSujets = $db->prepare('SELECT * FROM sujets');
                                $selectAllSujets->execute();
                                    ?>
        <div class="records tableResponsive">
            <div class="recordHeader">
                <div class="add">
                    <span>Entries</span>
                    <select name="" id="">
                        <option value="">ID</option>
                    </select>
                    <button>Add Record</button>
                </div>
                <div class="browse">
                    <input type="search" placeholder="Search" class="recordSearch">
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
                            <th><span class="las la-sort"></span>SUJET</th>
                            <th><span class="las la-sort"></span>REPONSES</th>
                            <th><span class="las la-sort"></span>DATE CREATION</th>
                            <th><span class="las la-sort"></span>ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                                while ($sAS = $selectAllSujets->fetch(PDO::FETCH_OBJ)) {
                        ?>


                            <tr>
                                <td class="flexRow">
                                    <div class="flexRow alignCenter">
                                        <?php echo $sAS->id_sujet; ?>
                                    </div>
                                    <?php if ($sAS->sujet_activ == 0) {
                                    ?>
                                        <img class="imgActiv" src="../img/red-light.png" alt="formulaire inactif">
                                    <?php
                                    } else {
                                    ?><img class="imgActiv" src="../img/green-light.png" alt="formulaire actif"> <?php
                                                                                                                } ?>
                                </td>
                                <td>
                                    <div class="client">

                                        <div class="clientInfo">
                                            <h4><?php echo $sAS->sujet_nom; ?></h4>

                                        </div>
                                    </div>
                                </td>
                                <td>$3171</td>
                                <td><?php echo $sAS->sujet_date; ?></td>

                                <td>
                                    <div class="actions">
                                        <a href="<?php $_SERVER['DOCUMENT_ROOT'] ?>/BO/_views/sujet.php?id=<?php echo $sAS->id_sujet; ?>&zone=sujets"><span class="lab la-telegram-plane"></span></a>
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
                            };

                            include($_SERVER['DOCUMENT_ROOT'] . '/BO/_blocks/footer.php');
                        } else {

                            echo "<script language='javascript'>
            document.location.replace('_views/login.php')
        </script>";
                        }

?>