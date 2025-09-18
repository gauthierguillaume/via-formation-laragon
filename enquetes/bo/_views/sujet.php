<?php

try {
    $db = new PDO('mysql:host=localhost; dbname=questionnaire', 'root', '');
    $db->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES 'utf8'");
} catch (Exception $e) {
    echo "Impossible de se connecter à la base de données";
    die;
}
include($_SERVER['DOCUMENT_ROOT'] . '/host.php');

if (isset($_SESSION['admin'])) {
    // var_dump($_SESSION['admin']);

    include($_SERVER['DOCUMENT_ROOT'] . '/bo/_blocks/sidebar.php');

    include($_SERVER['DOCUMENT_ROOT'] . '/bo/_blocks/header.php');

    $domaine = "Home";
    $sousDomaine = "Sujets";

    include($_SERVER['DOCUMENT_ROOT'] . '/bo/_blocks/ariane.php');


    if (isset($_GET['id']) && !isset($_GET['action'])) {
        $id = $_GET['id'];

        // Je séléctionne le sujet avec l'id récuprérer dans le GET
        $selectSujet = $db->prepare('SELECT * FROM sujets
                WHERE id_sujet = ?
            ');
        $selectSujet->execute([$id]);
        $sujet = $selectSujet->fetch(PDO::FETCH_OBJ);

        // Je séléctionne toute les question en lien avec le sujet
        $selectAllQuestions = $db->prepare('SELECT * FROM questions
                WHERE id_sujet = ?
            ');
        $selectAllQuestions->execute([$id]);

        // Je compte les utilisateurs ayant répondu au sujet
        $countUtilisateurs = $db->prepare('SELECT * FROM utilisateurs
                WHERE utilisateur_mail LIKE "%@%"
                AND id_sujet = ?
            ');
        $countUtilisateurs->execute([$id]);
        $countMails = count($countUtilisateurs->fetchAll());

        // Je compte tous les utilisateurs ayant répondu à tous les sujets
        $selectAllUtilisateurs = $db->prepare('SELECT * FROM utilisateurs
                WHERE utilisateur_mail LIKE "%@%"');
        $selectAllUtilisateurs->execute();
        $mails = count($selectAllUtilisateurs->fetchAll());

        // Je récupère la valeur de $countMails pour alimenter la variable $qty du bloc "analytics"
        $qty = $countMails;

        // Je calcule le pourcentage de personnes qui ont répondu à ce sujet parmi tous les sujet
        $qty_pourcent = $countMails / $mails * 100;

        // Je compte le nombre de question du sujet
        $countSujetQuestions = $db->prepare('SELECT * FROM sujets
                NATURAL JOIN questions
                WHERE sujets.id_sujet = ?
            ');
        $countSujetQuestions->execute([$id]);
        $count = count($countSujetQuestions->fetchAll());

        include($_SERVER['DOCUMENT_ROOT'] . '/bo/_blocks/analytics.php');

        if (isset($_POST["add_question"])) {
            $question = $_POST["question_question"];

            $addQuestion = $db->prepare('INSERT INTO questions SET
                    question_question = ?,
                    id_sujet = ?
                ');
            $addQuestion->execute([$question, $id]);

            echo "<script language='javascript'>
                            document.location.replace('sujet.php?id=" . $id . "&zone=sujets')
                </script>";
        }
        if (isset($_POST['modify_activ'])) {
            if (!empty($_POST['sujet_activ'])) {
                $sujetOn = $db->prepare('UPDATE sujets SET
                        sujet_activ = ?
                        WHERE id_sujet = ?
                    ');
                $sujetOn->execute([1, $id]);
            } else {
                $sujetOn = $db->prepare('UPDATE sujets SET
                        sujet_activ = ?
                        WHERE id_sujet = ?
                    ');
                $sujetOn->execute([0, $id]);
            }

            echo "<script language='javascript'>
                            document.location.replace('sujet.php?zone=sujets')
                        </script>";
        }
?>

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

            <input type="submit" value="Enregistrer" name="modify_activ">
        </form>

        <h1><?php echo $sujet->sujet_nom; ?></h1>

        <form method="POST" class="flexCol formSujet">

            <p>Ajouter une question</p>

            <input type="text" name="question_question">


            <div>
                <input type="submit" value="Ajouter" name="add_question">
            </div>
            <p>Ce sujet comporte <?php echo $count; ?> questions.</p>

        </form>

        <hr class="separateur">

        <?php

        while ($sAq = $selectAllQuestions->fetch(PDO::FETCH_OBJ)) {

            $id_question = $sAq->id_question;

            $selectAllTypes = $db->prepare('SELECT * FROM question_types');
            $selectAllTypes->execute();

            $selectReponse = $db->prepare('SELECT * FROM questions_rep_poss
                    NATURAL JOIN questions
                    NATURAL JOIN rep_poss
                    NATURAL JOIN question_types
                    WHERE id_question = ?
                ');
            $selectReponse->execute([$id_question]);

            if (isset($_POST['add_reponse_' . $sAq->id_question])) {
                $reponse = $_POST['rep_poss_reponse_' . $sAq->id_question];
                $type = $_POST['id_question_type_' . $sAq->id_question];

                $addReponse = $db->prepare('INSERT INTO rep_poss SET
                        rep_poss_reponse = ?,
                        id_question_type = ?
                    ');
                $addReponse->execute([$reponse, $type]);

                $last_id = $db->lastInsertId();

                $question_reponse = $db->prepare('INSERT INTO questions_rep_poss SET
                        id_question = ?,
                        id_rep_poss = ?
                    ');
                $question_reponse->execute([$id_question, $last_id]);

                echo "<script language='javascript'>
                            document.location.replace('sujet.php?id=" . $id . "&zone=sujets')
                        </script>";
            }

        ?>
            <p><?php echo $sAq->question_question; ?></p>
            <form method="POST" class="flexCol formSujet">
                <input type="text" name="rep_poss_reponse_<?php echo $sAq->id_question; ?>">

                <div>
                    <select name="id_question_type_<?php echo $sAq->id_question; ?>">
                        <?php while ($sAt = $selectAllTypes->fetch(PDO::FETCH_OBJ)) { ?>
                            <option value="<?php echo $sAt->id_question_type; ?>"><?php echo $sAt->question_type_nom; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div>
                    <input type="submit" name="add_reponse_<?php echo $sAq->id_question; ?>" value="Enr">
                </div>
            </form>


            <p>Liste des réponses à cette question</p>


            <?php while ($sR = $selectReponse->fetch(PDO::FETCH_OBJ)) {

                $id_reponse = $sR->id_rep_poss;
                $id_question = $sR->id_question;

                // Je compte le nombre de personne qui ont répondu à cette question
                $countReponsesQuestion = $db->prepare('SELECT * FROM reponses_questions
                            WHERE id_question = ?
                        ');
                $countReponsesQuestion->execute([$id_question]);
                $countReponses = count($countReponsesQuestion->fetchAll());

                // Je compte le nombre de personnes qui ont répondu à chaque reponse de cette question
                $countReponsesUtilisateur = $db->prepare('SELECT * FROM reponses_questions
                            NATURAL JOIN questions_rep_poss
                            NATURAL JOIN rep_poss
                            NATURAL JOIN reponses
                            WHERE id_rep_poss = ?
                        ');
                $countReponsesUtilisateur->execute([$id_reponse]);
                $cRu = count($countReponsesUtilisateur->fetchAll());
                $cRu_pourcent = $cRu / $countReponses * 100;

            ?>
                <p><?php echo $sR->rep_poss_reponse; ?> - <?php echo $sR->question_type_nom; ?> - <?php echo $cRu_pourcent; ?>% </p>
                <?php
                if ($sR->question_type_nom == "text") {
                ?>
                    <a href="sujet.php?zone=sujets&action=textLibre&id=<?php echo $id_question; ?>">CLICK</a>
            <?php
                }
            } ?>

            <hr class="separateur">

        <?php
        }
    } else if (isset($_GET['action']) && $_GET['action'] == "textLibre") {
        $id_question = $_GET['id'];
        $selectText = $db->prepare('SELECT * FROM reponses_questions
                    NATURAL JOIN reponses
                    WHERE id_question = ?
                ');
        $selectText->execute([$id_question]);

        while ($sT = $selectText->fetch(PDO::FETCH_OBJ)) {
        ?>
            <div>
                <textarea><?php echo $sT->reponse_reponse; ?></textarea>
            </div>
        <?php
        }
    } else {
        $selectAllSujets = $db->prepare('SELECT * FROM sujets');
        $selectAllSujets->execute();

        ?>

        <div class="records table-responsive">

            <div class="record-header">
                <div class="add">
                    <span>Entries</span>
                    <select name="" id="">
                        <option value="">ID</option>
                    </select>
                    <button>Add record</button>
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
                            <th><span class="las la-sort"></span> SUJET</th>
                            <th><span class="las la-sort"></span> REPONSES</th>
                            <th><span class="las la-sort"></span> DATE DE CREATION</th>
                            <th><span class="las la-sort"></span> ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($sAs = $selectAllSujets->fetch(PDO::FETCH_OBJ)) {
                            $id_sujet = $sAs->id_sujet;

                            $countUtilisateurs = $db->prepare('SELECT * FROM utilisateurs
                                    WHERE utilisateur_mail LIKE "%@%"
                                    AND id_sujet = ?
                                ');
                            $countUtilisateurs->execute([$id_sujet]);
                            $countMails = count($countUtilisateurs->fetchAll());

                        ?>
                            <tr>
                                <td class="flexRow">
                                    <div class="flexRow alingCenter">
                                        #<?php echo $sAs->id_sujet; ?>
                                    </div>
                                    <?php if ($sAs->sujet_activ == 0) {
                                    ?>
                                        <img class="imgActiv" src="../_imgs/red-light.png" alt="sujet inactif">
                                    <?php
                                    } else {
                                    ?>
                                        <img class="imgActiv" src="../_imgs/green-light.png" alt="sujet actif">
                                    <?php
                                    }
                                    ?>
                                </td>
                                <td>
                                    <div class="client">
                                        <div class="client-info">
                                            <h4><?php echo $sAs->sujet_nom; ?></h4>
                                        </div>
                                    </div>
                                </td>
                                <td><?php echo $countMails; ?></td>
                                <td><?php echo $sAs->sujet_date; ?></td>
                                <td>
                                    <div class="actions">
                                        <a href="<?php $_SERVER['DOCUMENT_ROOT'] ?>/bo/_views/sujet.php?id=<?php echo $sAs->id_sujet; ?>&zone=sujets">
                                            <span class="lab la-telegram-plane"></span>
                                        </a>
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
                document.location.replace(" . $_SERVER['DOCUMENT_ROOT'] . "'/bo/_views/login.php')
            </script>";
}
