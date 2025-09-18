<?php 
	include($_SERVER['DOCUMENT_ROOT'].'/host.php');

    if(isset($_SESSION['admin'])){

        include($_SERVER['DOCUMENT_ROOT'].'/bo/_blocks/header.php');
        include($_SERVER['DOCUMENT_ROOT'].'/bo/_blocks/sidebar.php');

        $domaine = "Sujets";
        $sousDomaine = "Liste des Sujets";
        
        include($_SERVER['DOCUMENT_ROOT'].'/bo/_blocks/ariane.php');

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

                echo
                    "<script language='javascript'>
                        document.location.replace('/sujet.php?id=".$id."&zone=sujets')
                    </script>";
            }

            if(isset($_POST['modify_activ'])){
                if(!empty($_POST['sujet_activ'])){
                    $sujetOn = $db->prepare("UPDATE sujets SET sujet_activ = ? WHERE id_sujet = ?");
                    $sujetOn->execute([1, $id]);
                } else {
                    $sujetOn = $db->prepare("UPDATE sujets SET sujet_activ = ? WHERE id_sujet = ?");
                    $sujetOn->execute([0, $id]);
                }

                echo
                "<script language='javascript'>
                    document.location.replace('sujet.php?zone=sujets')
                </script>";
            }

            ?>

            <form method="POST" class="formSujet">
                <label class="switch-button" for="switch">
                <div class="switch-outer">
                    <input id="switch" type="checkbox" name="sujet_activ" <?php if($sujet->sujet_activ == 1){echo "checked";}?>>
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
            </form>

            <hr class="separator">

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
                        document.location.replace('sujet.php?id=".$id."&zone=sujets')
                    </script>";
                }

                ?>
                <h2><?php echo $sAQ->question_question; ?></h2>
                
                <form method="POST" class="flexCol formSujet">
                    <input type="text" name="rep_poss_reponse_<?php echo $sAQ->id_question;?>"">
                    <div>
                        <select name="id_question_type_<?php echo $sAQ->id_question;?>"">
                            <?php
                                while($sAT = $selectAllTypes->fetch(PDO::FETCH_OBJ)){ ?>
                                <option value="<?php echo $sAT->id_question_type;?>"><?php echo $sAT->question_type_nom; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div>
                        <input type="submit" value="Envoyer" name="add_reponse_<?php echo $sAQ->id_question;?>">
                    </div>
                </form>

                <h3>Liste des reponses a cette question</h3>

                    <?php
                        while($sR = $selectReponse->fetch(PDO::FETCH_OBJ)){ ?>
                        <p><?php echo $sR->rep_poss_reponse; ?> - (<?php echo $sR->question_type_nom; ?>)</p>
                    <?php } ?>
                    <hr class="separator">

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
                                <td class="flexRow ">
                                    <div class="flexRow aiCenter">
                                        #<?php echo $sAS->id_sujet; ?>
                                    </div>
                                    <?php if($sAS->sujet_activ == 0){ 
                                    ?>
                                    <img class="imgActiv" src="../img/red-light.png" alt="sujet inactif">
                                    <?php
                                } else { 
                                    ?>
                                    <img class="imgActiv" src="../img/green-light.png" alt="sujet actif">
                                    <?php 
                                } 
                                ?>
                                </td>
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
    } else {        echo
        "<script language='javascript'>
            document.location.replace('/login.php')
        </script>";
    }