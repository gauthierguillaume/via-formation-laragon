<?php 

try {
    $db = new PDO('mysql:host=localhost; dbname=questionnaire', 'root', '');
    $db->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES 'utf8'");
} catch (PDOException $e) {
    echo "Impossible de se connecter à la base de données";
    die;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $selectSujet = $db->prepare('SELECT * FROM sujets WHERE id_sujet = ?');
    $selectSujet->execute([$id]);

    $sujet = $selectSujet->fetch(PDO::FETCH_OBJ);
    $selectAllQuestions = $db->prepare('SELECT * FROM questions WHERE id_sujet = ?');
    $selectAllQuestions->execute([$id]);

    
    if (isset($_POST["add_question"])) {
        $question = $_POST['question_question'];
        $addQuestion = $db->prepare("INSERT INTO questions SET question_question = ?, id_sujet = ?");
        $addQuestion->execute([$question, $id]);
    }
    ?>
    <h1><?php echo $sujet->sujet_nom; ?></h1>
    
    <form method="POST">
        <input type="text" name="question_question">
        <input type="submit" value="Ajouter" name="add_question">
    </form>

    <?php

    while($sAQ = $selectAllQuestions->fetch(PDO::FETCH_OBJ)){
        $id_question = $sAQ->id_question;

        $selectAllTypes = $db->prepare('SELECT * FROM questions_types');
        $selectAllTypes->execute();

        $selectReponse = $db->prepare('SELECT * FROM questions_rep_poss NATURAL JOIN questions NATURAL JOIN rep_poss NATURAL JOIN questions_types WHERE id_question = ?');
        $selectReponse->execute([$id_question]);

        if(isset($_POST['add_reponse_'.$sAQ->id_question])){
            $reponse = $_POST['rep_poss_reponse_'.$sAQ->id_question];
            $type = $_POST['id_question_type_'.$sAQ->id_question];

            $addReponse = $db->prepare("INSERT INTO rep_poss SET rep_poss_reponse = ?, id_question_type = ?");
            $addReponse->execute([$reponse, $type]);

            $last_id = $db->lastInsertId();

            $question_reponse = $db->prepare("INSERT INTO questions_rep_poss SET id_question = ?, id_rep_poss = ?");
            $question_reponse->execute([$id_question, $last_id]);

            echo
            "<script language='javascript'>
                document.location.replace('sujet.php?id=".$id."')
            </script>";
        }

        ?>
        <h2><?php echo $sAQ->question_question; ?></h2>
        <form method="POST">
            <input type="text" name="rep_poss_reponse_<?php echo $sAQ->id_question;?>"">
                <select name="id_question_type_<?php echo $sAQ->id_question;?>"">
                    <?php
                        while($sAT = $selectAllTypes->fetch(PDO::FETCH_OBJ)){ ?>
                        <option value="<?php echo $sAT->id_question_type;?>"><?php echo $sAT->question_type_nom; ?></option>
                    <?php } ?>
                </select>
                <input type="submit" value="Envoyer" name="add_reponse_<?php echo $sAQ->id_question;?>">
        </form>

        <h3>Liste des reponses a cette question</h3>

            <?php
                while($sR = $selectReponse->fetch(PDO::FETCH_OBJ)){ ?>
                <p><?php echo $sR->rep_poss_reponse; ?> - (<?php echo $sR->question_type_nom; ?>)</p>
            <?php } ?>

        <?php
    }

} else {
    echo "Aucun sujet sélectionné";
}

?>