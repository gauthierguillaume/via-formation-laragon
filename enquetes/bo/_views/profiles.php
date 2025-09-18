<?php

include($_SERVER['DOCUMENT_ROOT'].'/host.php');

if(isset($_GET['action']) && $_GET['action' == "profile"]){

}else{

    if(isset($_SESSION['admin'])){

        include($_SERVER['DOCUMENT_ROOT'].'/bo/_blocks/sidebar.php');

        include($_SERVER['DOCUMENT_ROOT'].'/bo/_blocks/header.php');

        $domaine = "Profiles";
        $sousDomaine = "Liste des personnes qui ont renseignés les enquêtes";

        include($_SERVER['DOCUMENT_ROOT'].'/bo/_blocks/ariane.php');

        // Je compte tous les utilisateurs ayant répondu à tous les sujets.
        $selectAllUtilisateurs = $db->prepare('SELECT * FROM utilisateurs
            WHERE utilisateur_mail LIKE "%@%"');
        $selectAllUtilisateurs->execute();

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
                            <th><span class="las la-sort"></span> CLIENTS</th>
                            <th><span class="las la-sort"></span> TYPES</th>
                            <th><span class="las la-sort"></span> ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            while($sAu = $selectAllUtilisateurs->fetch(PDO::FETCH_OBJ)){
                            ?>
                            
                                <tr>
                                    <td>#<?php echo $sAu->id_utilisateur;?></td>
                                    <td>
                                        <div class="client">
                                            <div class="client-img bg-img" style="background-image: url(<?php $_SERVER['DOCUMENT_ROOT']?>/bo/_imgs/Van-Damme-Bloodsport.png)"></div>
                                            <div class="client-info">
                                                <small><?php echo $sAu->utilisateur_mail;?></small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        
                                        <?php
                                        if($sAu->utilisateur_type == 0){                                            
                                            echo strtoupper("particulier");
                                        }else if($sAu->utilisateur_type == 1){
                                            echo strtoupper("entreprise");
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <div class="actions">
                                            <a href="profiles.php?zone=profiles&action=profile&id=<?php echo $sAu->id_utilisateur;?>"><span class="lab la-telegram-plane"></span></a>
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


        include($_SERVER['DOCUMENT_ROOT'].'/bo/_blocks/footer.php');
    }else{
        echo "<script language='javascript'>
                document.location.replace('login.php')
            </script>";
    }
}