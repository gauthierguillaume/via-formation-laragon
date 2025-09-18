<?php 
$vitesse = 200;

if ($vitesse > 80) {
    echo "Flashé a ".$vitesse." km/h";
}

$difference = $vitesse - 80;

if($difference < 5) {
    echo "good";
} else if($difference >= 5 && $difference < 20) {
    echo " perdu 1 pts";
} else if($difference >= 20 && $difference < 30) {
    echo " perdu 2pts";
} else if($difference >= 30 && $difference < 40) {
    echo " perdu 3pts";
} else if($difference >= 40) {
    echo " perdu tribunal";
}

// -------------------------------------------------------------------------------

include($_SERVER['DOCUMENT_ROOT'].'/host.php');

$selectAllTypes = $db->prepare('SELECT * FROM questions_types');
$selectAllTypes->execute();

$selectAllTypeForUpdate = $db->prepare('SELECT * FROM questions_types');
$selectAllTypeForUpdate->execute();

$selectAllSujets = $db->prepare('SELECT * FROM sujets');
$selectAllSujets->execute();

if(isset($_POST['add_type'])){
    $type_name = $_POST['question_type_nom'];

    $addtype = $db->prepare("INSERT INTO questions_types SET
        question_type_nom = ?
    ");
+    $addtype->execute([$type_name]);
}

if(isset($_POST['update_type'])){
    $id_type = $_POST['id_question_type'];
    $new_name = $_POST['new_type_name'];

    $updateType = $db->prepare('UPDATE questions_types SET
        question_type_nom = ?
        WHERE id_question_type = ?
    ');
    $updateType->execute([$new_name, $id_type]);
}


?>
<form method= "POST">
    <input type="text" name="question_type_nom">
    <input type="submit" value="Envoyer" name="add_type">
</form>

<h1>La liste des elements de la table "questions_types"</h1>
<?php 
    while($sAT = $selectAllTypes->fetch(PDO::FETCH_OBJ)){
        ?>
        <p><?php echo $sAT->question_type_nom; ?></p>
        <?php
    }
?>

<h1>Modifier un type</h1>
<form method= "POST">
    <select name="id_question_type">
        <?php
        while($sATfu = $selectAllTypeForUpdate->fetch(PDO::FETCH_OBJ)){ ?>
        <option value="<?php echo $sATfu->id_question_type;?>"><?php echo $sATfu->question_type_nom; ?></option>
        <?php } ?>
    </select>
    <input type="text" name="new_type_name">
    <input type="submit" value="Modifier" name="update_type">
</form>
<h1>La liste et liens vers les sujets</h1>

<?php 
    while($sAS = $selectAllSujets->fetch(PDO::FETCH_OBJ)){
        ?>
        <p><a href="sujet.php?id=<?php echo $sAS->id_sujet; ?>"><?php echo $sAS->sujet_nom; ?></a></p>
        <?php
    }
?>

