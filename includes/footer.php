</div> <!-- container -->
<?php

$sqlSociete = "SELECT nom_societe, siegle_societe, tele_societe, tele_societeSecond, postBP, pays, province, commune_societe, quartier, avenue,numero,email_societe, assujetti_tva, NIF_societe,Registre_commerce, centre_fiscal, forme_juridique, secteur_activite FROM societe";

$societeResult = $connect->query($sqlSociete);
$societeData = $societeResult->fetch_array();

$nom_societe 		= $societeData[0];

$connect->close();

?>

<footer class="main-footer navbar-default navbar-fixed-bottom">
	<div class="pull-right hidden-xs container-fluid">
		<footer align="right">Powered By <a href="https://uvatechs.com"> UVATECHS</a></footer>
	</div>
	<div class="pull-right hidden-xs container-fluid">
		<footer align="right" color="red">Dépôt : <?php echo $_SESSION["nameAgence"]; ?></footer>
	</div>
	<div class="pull-right hidden-xs container-fluid">
		<footer align="right" color="red">Connetez : <?php echo $_SESSION["userName"] . " - " . $_SESSION["role"]; ?></footer>
	</div>
	<div class="align-left">

		<strong>Copyright &copy; <?php echo date('Y'); ?> <a href="#"><?php echo $nom_societe; ?></a>.</strong> All rights reserved.

	</div>

</footer>

</div><!-- ./wrapper -->

<div id="loadbargood" class="loadbargood hidden"></div>

<!-- file input -->
<script src="assests/plugins/fileinput/js/plugins/canvas-to-blob.min.js" type="text/javascript"></script>
<script src="assests/plugins/fileinput/js/plugins/sortable.min.js" type="text/javascript"></script>
<script src="assests/plugins/fileinput/js/plugins/purify.min.js" type="text/javascript"></script>
<script src="assests/plugins/fileinput/js/fileinput.min.js"></script>
<script src="assests/plugins/datatables/dataTables.responsive.min.js"></script>

<!-- <script src="assests/plugins/datatables/datatables.min.js"></script>	 -->


<!-- DataTables -->
<!--<script src="assests/plugins/datatables/jquery.dataTables.min.js"></script>-->

</body>

</html>