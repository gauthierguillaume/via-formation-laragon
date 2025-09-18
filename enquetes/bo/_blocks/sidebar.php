<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>Modern Admin Dashboard</title>
    <link rel="stylesheet" href="<?php $_SERVER['DOCUMENT_ROOT'] ?>/styles/style.css">
    <link rel="stylesheet" href="<?php $_SERVER['DOCUMENT_ROOT'] ?>/styles/generic.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
</head>

<body>
    <?php
    if (isset($_SESSION['flash'])) {
        foreach ($_SESSION['flash'] as $type => $message) {
    ?>
            <div class="" id='zoneDeNotification'>
                <div class="alert alert-<?php echo $type; ?>">
                    <?php echo $message; ?>
                </div>
            </div>

    <?php
        }
        unset($_SESSION['flash']);
    }
    ?>

    <input type="checkbox" id="menu-toggle">
    <div class="sidebar">
        <div class="side-header">
            <h3>M<span>odern</span></h3>
        </div>

        <div class="side-content">
            <div class="profile">
                <div class="profile-img bg-img" style="background-image: url(/bo/_imgs/Van-Damme-Bloodsport.png)"></div>
                <h4><?php echo $_SESSION['admin']['user_first_name']; ?> <?php echo $_SESSION['admin']['user_last_name']; ?></h4>
                <small><?php echo $_SESSION['admin']['role_name']; ?></small>
            </div>

            <div class="side-menu">
                <ul>
                    <li>
                        <a href="<?php $_SERVER['DOCUMENT_ROOT'] ?>/bo/index.php?zone=dashboard" class="<?php if (isset($_GET["zone"]) && $_GET['zone'] == "dashboard") {
                                                                                                            echo "active";
                                                                                                        } ?>">
                            <span class="las la-home"></span>
                            <small>Dashboard</small>
                        </a>
                    </li>
                    <li>
                        <a href="<?php $_SERVER['DOCUMENT_ROOT'] ?>/bo/_views/profiles.php?zone=profiles" class="<?php if (isset($_GET["zone"]) && $_GET['zone'] == "profiles") {
                                                                                                                        echo "active";
                                                                                                                    } ?>">
                            <span class="las la-tasks"></span>
                            <small>Profiles</small>
                        </a>
                    </li>
                    <li>
                        <a href="class=" <?php if (isset($_GET["zone"]) && $_GET['zone'] == "mails") {
                                                echo "active";
                                            } ?>"">
                            <span class="las la-envelope"></span>
                            <small>Mailbox</small>
                        </a>
                    </li>
                    <li>
                        <a href="<?php $_SERVER['DOCUMENT_ROOT'] ?>/bo/_views/sujet.php?zone=sujets" class="<?php if (isset($_GET["zone"]) && $_GET['zone'] == "sujets") {
                                                                                                                echo "active";
                                                                                                            } ?>">
                            <span class="las la-clipboard-list"></span>
                            <small>Sujets</small>
                        </a>
                    </li>
                    <li>
                        <a href="">
                            <span class="las la-shopping-cart"></span>
                            <small>Orders</small>
                        </a>
                    </li>
                    <?php
                    if (isset($_SESSION['admin']) && $_SESSION['admin']['role_level'] > 99) {
                    ?>
                        <li>
                            <a href="<?php $_SERVER['DOCUMENT_ROOT'] ?>/bo/_views/admin.php?zone=admin" class="<?php if (isset($_GET["zone"]) && $_GET['zone'] == "admin") {
                                                                                                                    echo "active";
                                                                                                                } ?>">
                                <span class="las la-tasks"></span>
                                <small>Admin</small>
                            </a>
                        </li>
                    <?php
                    }
                    ?>

                </ul>
            </div>
        </div>
    </div>