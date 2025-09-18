<?php
include($_SERVER['DOCUMENT_ROOT'].'/host.php');

if(isset($_SESSION['admin'])){
	

	include($_SERVER['DOCUMENT_ROOT'].'/bo/_blocks/header.php');
	include($_SERVER['DOCUMENT_ROOT'].'/bo/_blocks/sidebar.php');

	$domaine = "Home";
	$sousDomaine = "Dashboard";

	include($_SERVER['DOCUMENT_ROOT'].'/bo/_blocks/ariane.php');
	include($_SERVER['DOCUMENT_ROOT'].'/bo/_blocks/analytics.php');

	$selectAllSujets = $db->prepare('SELECT * FROM sujets ORDER BY id_sujet DESC');
	$selectAllSujets->execute();

	// var_dump($_SESSION['admin']);


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
						<td><?php echo $sAS->id_sujet; ?></td>
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
		include($_SERVER['DOCUMENT_ROOT'].'/bo/_blocks/footer.php');
}else{
	echo
	"<script language='javascript'>
		document.location.replace(".$_SERVER['DOCUMENT_ROOT']."'/bo/_views/login.php')
	</script>";
}
?>