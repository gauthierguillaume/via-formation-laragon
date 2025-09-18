<?php

echo "Bonjour tout le monde";

$variable = "Ma première variable";

echo $variable;

$couleur = "color: red;"

?>

<p style="<?php echo $couleur;?>"><?php echo $variable;?></p>

<?php

$vitesse = 151;

if($vitesse > 80){
    echo "Vous avez été flashé à ".$vitesse."km/h, vous êtes en excès de vitesse.";
}

$difference = $vitesse - 80;

if($difference < 5){
    echo "Vous n'avez pas perdu de point";
}else if($difference >= 5 && $difference < 20){
    echo "<p>Vous avez perdu 1 point.</p>";
}else if($difference >= 20 && $difference < 30){
    echo "<p>Vous avez perdu 2 point.</p>";
}else if($difference >= 30 && $difference < 40){
    echo "<p>Vous avez perdu 3 point.</p>";
}else if($difference >= 40){
    echo "<p>Vous êtes mal, ça sent le tribunal</p>";
}


try{
    $db = new PDO('mysql:host=localhost; dbname=questionnaire', 'root', '');
    $db->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES 'utf8'"); 
}catch(Exception $e){
    echo "Impossible de se connecter à la base de données";
    die;
}


$selectAllTypes = $db->prepare('SELECT * FROM question_types');
$selectAllTypes->execute();

$selectAllTypesForUpdate = $db->prepare('SELECT * FROM question_types');
$selectAllTypesForUpdate->execute();

$selectAllSujets = $db->prepare('SELECT * FROM sujets');
$selectAllSujets->execute();




if(isset($_POST['add_type'])){
    $type_name = $_POST['question_type_nom'];

    $addType = $db->prepare('INSERT INTO question_types SET
        question_type_nom = ?
    ');
    $addType->execute([$type_name]);
}

if(isset($_POST['update_type'])){
    $id_type = $_POST['id_question_type'];
    $new_name = $_POST['new_type_name'];

    $updateType = $db->prepare('UPDATE question_types SET
        question_type_nom = ?
        WHERE id_question_type = ?
    ');

    $updateType->execute([$new_name, $id_type]);
}





?>

<form method="POST">

    <input type="text" name="question_type_nom">

    <input type="submit" value="OK" name="add_type">
</form>

<h1>La liste des éléments de la table "Question_types"</h1>

<?php
    while($sAt = $selectAllTypes->fetch(PDO::FETCH_OBJ)){
        ?>
            <p><?php echo$sAt->question_type_nom;?></p>
        <?php
    }
?>


<h1>Modifier un type</h1>

<form method="POST">
    <select name="id_question_type">
        <?php while($sAutf = $selectAllTypesForUpdate->fetch(PDO::FETCH_OBJ)){?>
        <option value="<?php echo $sAutf->id_question_type;?>"><?php echo $sAutf->question_type_nom;?></option>
        <?php } ?>
    </select>
    
    <input type="text" name="new_type_name">

    <input type="submit" value="Modifier" name="update_type">

</form>



<h1>La liste et liens vers les sujets</h1>

<?php
    while($sAs = $selectAllSujets->fetch(PDO::FETCH_OBJ)){
        ?>
            <p><a href="sujet.php?id=<?php echo $sAs->id_sujet;?>"><?php echo $sAs->sujet_nom;?></a></p>
        <?php
    }
?>
