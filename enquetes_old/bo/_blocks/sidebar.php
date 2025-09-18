<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1" />
		<title>Modern Admin Dashboard</title>
		<link rel="stylesheet" href="<?php $_SERVER['DOCUMENT_ROOT']?>/styles/style.css" />
		<link rel="stylesheet" href="<?php $_SERVER['DOCUMENT_ROOT']?>/styles/generic.css" />
		<link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css" />
	</head>
	<body>
		<input type="checkbox" id="menu-toggle" />
		<div class="sidebar">
			<div class="side-header">
				<h3>M<span>odern</span></h3>
			</div>

			<div class="side-content">
				<div class="profile">
					<div class="profile-img bg-img" style="background-image: url(img/3.jpeg)"></div>
					<h4><?php echo $_SESSION['admin']['user_first_name']; ?> <?php echo $_SESSION['admin']['user_last_name']; ?></h4>
					<small><?php echo $_SESSION['admin']['role_name']; ?></small>
				</div>

				<div class="side-menu">
					<ul>
						<li>
							<a href="<?php $_SERVER['DOCUMENT_ROOT']?>/bo/index.php?zone=dashboard" class="<?php if(isset($_GET['zone']) && $_GET['zone'] == 'dashboard'){ echo 'active'; } ?>">
								<span class="las la-home"></span>
								<small>Dashboard</small>
							</a>
						</li>
						<li>
							<a href="<?php $_SERVER['DOCUMENT_ROOT']?> /bo/_views/sujet.php" class="<?php if(isset($_GET['zone']) && $_GET['zone'] == 'profil'){ echo 'active'; } ?>">
								<span class="las la-user-alt"></span>
								<small>Profile</small>
							</a>
						</li>
						<li>
							<a href="<?php $_SERVER['DOCUMENT_ROOT']?> /bo/_views/sujet.php" class="<?php if(isset($_GET['zone']) && $_GET['zone'] == 'mail'){ echo 'active'; } ?>">
								<span class="las la-envelope"></span>
								<small>Mailbox</small>
							</a>
						</li>
						<li>
							<a href="<?php $_SERVER['DOCUMENT_ROOT']?> /bo/_views/sujet.php?zone=sujet" class="<?php if(isset($_GET['zone']) && $_GET['zone'] == 'sujet'){ echo 'active'; } ?>">
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
						if(isset($_SESSION['admin']) && $_SESSION['admin']['role_level']> 99){
							?>
							<li>
								<a href="<?php $_SERVER['DOCUMENT_ROOT']?> /bo/_views/admin.php?zone=admin" class="<?php if(isset($_GET['zone']) && $_GET['zone'] == 'admin'){ echo 'active'; } ?>">
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