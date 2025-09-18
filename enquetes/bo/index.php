<?php

include($_SERVER['DOCUMENT_ROOT'] . '/host.php');

if (isset($_SESSION['admin'])) {
    //var_dump($_SESSION['admin']);

    include($_SERVER['DOCUMENT_ROOT'] . '/bo/_blocks/sidebar.php');

    include($_SERVER['DOCUMENT_ROOT'] . '/bo/_blocks/header.php');

    $domaine = "Home";
    $sousDomaine = "Dashboard";

    include($_SERVER['DOCUMENT_ROOT'] . '/bo/_blocks/ariane.php');

    $selectAllUtilisateurs = $db->prepare('SELECT * FROM utilisateurs
                WHERE utilisateur_mail LIKE "%@%"');
    $selectAllUtilisateurs->execute();
    $mails = count($selectAllUtilisateurs->fetchAll());

    $qty = $mails;

    include($_SERVER['DOCUMENT_ROOT'] . '/bo/_blocks/analytics.php');

    $selectAllSujets = $db->prepare('SELECT * FROM sujets
                ORDER BY id_sujet DESC
            ');
    $selectAllSujets->execute();

    //var_dump($_SESSION['admin']);
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
                        $countmails = count($countUtilisateurs->fetchAll());

                    ?>
                        <tr>
                            <td><?php echo $sAs->id_sujet; ?></td>
                            <td>
                                <div class="client">
                                    <div class="client-info">
                                        <h4><?php echo $sAs->sujet_nom; ?></h4>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <?php echo $countmails; ?>
                            </td>
                            <td>
                                <?php echo $sAs->sujet_date; ?>
                            </td>
                            <td>
                                <div class="actions">
                                    <a href="<?php $_SERVER['DOCUMENT_ROOT'] ?>/bo/_views/sujet.php?id=<?php echo $sAs->id_sujet; ?>&zone=sujets>">
                                        <span class="lab la-telegram-plane"></span></a>
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

    include($_SERVER['DOCUMENT_ROOT'] . '/bo/_blocks/footer.php');
} else {
    echo "<script language='javascript'>
            document.location.replace(" . $_SERVER['DOCUMENT_ROOT'] . "'/bo/_views/login.php')
        </script>";
}

?>