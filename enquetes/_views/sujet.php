<?php

include($_SERVER['DOCUMENT_ROOT'].'/host.php');

if(isset($_GET['id']) && $_GET){
    $id = $_GET['id'];

    $verifSujet = $db->prepare('SELECT * FROM sujets
        WHERE id_sujet = ?
    ');
    $verifSujet->execute([$id]);
    $verif = $verifSujet->fetch(PDO::FETCH_OBJ);

    if(!empty($verif)){
        $title = $verif->sujet_nom;

        //echo noAccent($title);

        if($_GET['title'] == noAccent($title)){
        
            $selectSujet = $db->prepare('SELECT * FROM sujets
                WHERE id_sujet = ?
            ');
            $selectSujet->execute([$id]);
            $sujet = $selectSujet->fetch(PDO::FETCH_OBJ);

            $selectSujetQuestions = $db->prepare('SELECT * FROM sujets
                NATURAL JOIN questions
                WHERE sujets.id_sujet = ?
            ');
            $selectSujetQuestions->execute([$id]);

            $countSujetQuestions = $db->prepare('SELECT * FROM sujets
                NATURAL JOIN questions
                WHERE sujets.id_sujet = ?
            ');
            $countSujetQuestions->execute([$id]);
            $count = count($countSujetQuestions->fetchAll());

            ?>

            <h1><?php echo $sujet->sujet_nom;?></h1>

            <h2>Ce sujet comprend <?php echo $count;?> questions</h2>

            <?php

            $i = 0;

            while($sSq = $selectSujetQuestions->fetch(PDO::FETCH_OBJ)){
                $i++;

                $id_question = $sSq->id_question;

                $selectReponseQuestion = $db->prepare('SELECT * FROM questions
                    NATURAL JOIN questions_rep_poss
                    NATURAL JOIN rep_poss
                    NATURAL JOIN question_types
                    WHERE questions.id_question = ?                
                ');
                $selectReponseQuestion->execute([$id_question]);

                if(isset($_SESSION['auth'])){

                    $id_utilisateur = $_SESSION['auth']['id_utilisateur'];

                    $countReponsesUtilisateur = $db->prepare('SELECT id_question FROM reponses
                        NATURAL JOIN reponses_questions
                        NATURAL JOIN questions
                        WHERE id_question = ?
                        AND id_utilisateur = ?
                        GROUP BY id_question
                ');
                $countReponsesUtilisateur->execute([$id_question, $id_utilisateur]);
                $countReponses = count($countReponsesUtilisateur->fetchAll());
                }

                if(isset($_POST['add_reponse'.$id_question])){
                    $checks = $_POST['check'];

                    foreach($checks as $check){
                        //echo $check;

                        $add_reponse = $db->prepare('INSERT INTO reponses SET
                            reponses_reponse = ?,
                            id_utilisateur = ?
                        ');
                        $add_reponse->execute([$check, 1]);

                        $last_id = $db->lastInsertId();
                        
                        $addReponseQuestion = $db->prepare('INSERT INTO reponses_questions SET
                            id_question = ?,
                            id_reponse = ?
                        ');
                        $addReponseQuestion->execute([$id_question, $last_id]);
                    }
                }

                ?>

                <p class="italic">Question N°<?php echo $i;?></p>
                <h3><?php echo $sSq->question_question;?></h3>

                <?php
                
                if(empty($countReponses)){
                    ?>
                

                <form method="POST" class="orientationForm">
                    <?php
                    while($sRq = $selectReponseQuestion->fetch(PDO::FETCH_OBJ)){
                        ?>
                        <div class="orientation">
                            <input type="<?php echo $sRq->question_type_nom;?>" id="reponse_poss<?php echo $sRq->id_rep_poss;?>" name="check[]" value="<?php echo $sRq->rep_poss_reponse?>">
                            <label for="reponse_poss<?php echo $sRq->id_rep_poss;?>"><?php echo $sRq->rep_poss_reponse?></label>
                        </div>
                        <?php
                    
                    }
                        ?>

                    <input type="submit" value="Enregistrer" name="add_reponse<?php echo $sSq->id_question;?>">
                </form>

                <?php
                }else{
                    ?>
                    <p style="color: red;">Vous avez déjà répondu à la question</p>
                    <?php
                }
                ?>

                <?php


            }


        }else{
            echo "Stop, on va s'arrêter là";
        }
    }
}

?>