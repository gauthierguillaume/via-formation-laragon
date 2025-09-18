<?php

//http://php.test/_views/login.php?id=1&title=sujet-1

include($_SERVER['DOCUMENT_ROOT'].'/host.php');

include($_SERVER['DOCUMENT_ROOT'].'/_blocks/nav.php');

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $title = $_GET['title'];

    //Vérification du bon titre en fonction de l'id
    $selectSujet = $db->prepare('SELECT * FROM sujets
        WHERE id_sujet = ?
    ');
    $selectSujet->execute([$id]);
    $sujet = $selectSujet->fetch(PDO::FETCH_OBJ);

    $verifTitle = noAccent($sujet->sujet_nom);

    if($title == $verifTitle){

        if(isset($_POST['add_utilisateur'])){
            $mail = $_POST['utilisateur_mail'];

            $countEmail = $db->prepare('SELECT * FROM utilisateurs
                WHERE utilisateur_mail = ?
                AND id_sujet = ?
            ');
            $countEmail->execute([$mail, $id]);
            $count = count($countEmail->fetchAll());

            $selectUtilisateur = $db->prepare('SELECT * FROM utilisateurs
            WHERE utilisateur_mail = ?
            ');
            $selectUtilisateur->execute([$mail]);
            $utilisateur = $selectUtilisateur->fetch(PDO::FETCH_OBJ);

            $id_utilisateur = $utilisateur->id_utilisateur;

            if(empty($count)){

            $addUtilisateur = $db->prepare('INSERT INTO utilisateurs SET
                utilisateur_mail = ?
                id_sujet = ?
            ');
            $addUtilisateur->execute([$mail, $id]);

            echo "<script language='javascript'>
                document.location.replace('../_views/sujet.php?id=".$id."&title=".$title."')
            </script>";

            }else{
                // Compter le nombre de sujet
                $countQuestionsSujet = $db->prepare('SELECT * FROM questions
                    WHERE id_sujet = ?
                ');
                $countQuestionsSujet->execute([$id]);
                $countQuestions = $countQuestionsSujet->fetchAll();

                // Compter le nombre de réponse de cet utilisateur sur ce sujet
                $countReponsesUtilisateur = $db->prepare('SELECT id_question FROM reponses
                    NATURAL JOIN reponses_questions
                    NATURAL JOIN questions
                    WHERE id_sujet = ?
                    AND id_utilisateur = ?
                    GROUP BY id_question
                ');
                $countReponsesUtilisateur->execute([$id, $id_utilisateur]);
                $countReponses = count($countReponsesUtilisateur->fetchAll());

                if($countQuestions > $countReponses){

                    $_SESSION['auth'] = $utilisateur;

                    echo "<script language='javascript'>
                        document.location.replace('../_views/sujet.php?id=".$id."&title=".$title."')
                    </script>";

                }
            }
        }

        if($sujet->sujet_type == 0){
            echo "formulaire particulier";

            ?>
            
                <form method="POST">

                    <input type="mail" name="utilisateur_mail">

                    <input type="submit" value="Go !" name="add_utilisateur">

                </form>

            <?php

        }else if($sujet->sujet_type == 1){
            echo "formulaire entreprise";
            ?>

                <form method="POST">

                    <input type="mail" name="utilisateur_name">

                    <input type="text" name="utilisateur_societe">

                    <input type="submit" value="Go !" name="add_societe">

                </form>

            <?php
        }

    
    }else{
        echo "Vous n'avez rien à faire ici.";
    }


}else{
    echo "Aucune enquête de satisfaction n'a été séléctionnée.";
}


include($_SERVER['DOCUMENT_ROOT'].'/_blocks/footer.php');

?>