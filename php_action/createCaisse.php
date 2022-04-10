<?php 	
	date_default_timezone_set('Africa/Bujumbura');
	require_once 'core.php';

	$valid['success'] = array('success' => false, 'messages' => array());

	if($_POST) {	
		$date_caisse 		= date('Y-m-d', strtotime($_POST['date_caisse']));

		$sql = "SELECT * FROM caisse WHERE date_caisse = '$date_caisse'";
  		$ligne = $connect->query($sql);

  		$ligneback = $ligne->num_rows;

  		if ( $ligneback == 0) {

  			///// total de vente a une date x CAST(PROD_CODE) AS INT

  			$sql = "SELECT SUM(grand_total) AS total FROM orders WHERE order_status = 1 AND order_date = '$date_caisse'";
  			$ligne = $connect->query($sql);
        $ligneback = $ligne->num_rows;
        $order_total;
        if ($ligneback == 0) {
          # code...
          $order_total=0;
        }else{
          $result = $ligne->fetch_assoc();
          $order_total = $result["total"];
        }

  			////////////// vente a credit pour une date x

  			$sql = "SELECT SUM(grand_total) AS total_credit FROM orders WHERE order_status = 1 AND payment_status = 3 AND order_date = '$date_caisse'";
  			$ligne = $connect->query($sql);
        $ligneback = $ligne->num_rows;
        $total_credit;
        if ($ligneback == 0) {
          # code...
          $total_credit=0;
        }else{
          $result = $ligne->fetch_assoc();
          $total_credit = floatval($result["total_credit"]);
        }

  			/////////// reboursement a une date x 

  			$sql = "SELECT SUM(montant) AS total_remboursement FROM remborsement WHERE  date_remb = '$date_caisse'";
  			$ligne = $connect->query($sql);

        $ligneback = $ligne->num_rows;
        $total_rembourse;
        if ($ligneback == 0) {
          # code...
          $total_rembourse=0;
        }else{
          $result = $ligne->fetch_assoc();
          $total_rembourse = floatval($result["total_remboursement"]);
        }

  			/////////// depense a une date x 

  			$sql = "SELECT SUM(prix_total_depense) AS total_depense FROM depenses WHERE  date_depense = '$date_caisse'";
  			$ligne = $connect->query($sql);
          $ligneback = $ligne->num_rows;
        $total_depense;
        if ($ligneback == 0) {
          # code...
          $total_depense=0;
        }else{
          $result = $ligne->fetch_assoc();
          $total_depense = floatval($result["total_depense"]);
        }

  			/////////// depense a une date x 

  			$sql = "SELECT SUM(montant_verse) AS montant_verse FROM versement WHERE  date_bordereau = '$date_caisse'";
  			$ligne = $connect->query($sql);
        $ligneback = $ligne->num_rows;
  			$total_verse;
        if ($ligneback == 0) {
          # code...
          $total_verse=0;
        }else{
          $result = $ligne->fetch_assoc();
        $total_verse= floatval($result["montant_verse"]);
        }

          /////////// sortie a une date x 

        $sql = "SELECT SUM(montant) AS total_sortie FROM bon_sortie WHERE  date_sortie = '$date_caisse'";
        $ligne = $connect->query($sql);
          $ligneback = $ligne->num_rows;
        $total_sortie;
        if ($ligneback == 0) {
          # code...
          $total_sortie=0;
        }else{
          $result = $ligne->fetch_assoc();
          $total_sortie = floatval($result["total_sortie"]);
        }

  			/////////// caisse a une date x 
  			
  			$hier = new DateTime('-1 day');
  			$date_caisseHier = $hier -> format('Y-m-d');

  			$sql = "SELECT SUM(montant_caisse) AS montant_caisse FROM caisse WHERE  date_caisse = '$date_caisseHier'";
  			$ligne = $connect->query($sql);
  			$ligneback = $ligne->num_rows;
  			$total_caisse;
  			if ($ligneback == 0) {
  				# code...
  				$total_caisse=0;
  			}else{
  				$result = $ligne->fetch_assoc();
  				$total_caisse= floatval($result["montant_caisse"]);
  			}

  			
        $montant_caisse =0;
  			$montant_caisse = $total_caisse + $order_total - $total_credit -  $total_depense - $total_sortie + $total_rembourse - $total_verse;

  			//$date_caisse 		= date("Y-m-d");
  			$user_add_caisse 	= $_SESSION['userId'];
	  		$date_add_caisse 	= date("Y-m-d H:m:s"); 


  			$sql = "INSERT INTO caisse (montant_caisse, date_caisse, user_add_caisse, date_add_caisse) VALUES ('$montant_caisse', '$date_caisse', $user_add_caisse, '$date_add_caisse')";

        if($connect->query($sql) === TRUE) {
          $valid['success'] = true;
          $valid['messages'] = "La caisse du jour a été créer";  
        } else {
          $valid['success'] = false;
          $valid['messages'] = "Error while adding the members ".mysqli_error($connect);
        }

  		}else{
          $date_caisse    = date('Y-m-d', strtotime($_POST['date_caisse']));
            ///// total de vente a une date x CAST(PROD_CODE) AS INT

        $sql = "SELECT SUM(grand_total) AS total FROM orders WHERE order_status = 1 AND order_date = '$date_caisse'";
        $ligne = $connect->query($sql);
        $ligneback = $ligne->num_rows;
        $order_total;
        if ($ligneback == 0) {
          # code...
          $order_total=0;
        }else{
          $result = $ligne->fetch_assoc();
          $order_total = $result["total"];
        }

        ////////////// vente a credit pour une date x

        $sql = "SELECT SUM(grand_total) AS total_credit FROM orders WHERE order_status = 1 AND payment_status = 3 AND order_date = '$date_caisse'";
        $ligne = $connect->query($sql);
        $ligneback = $ligne->num_rows;
        $total_credit;
        if ($ligneback == 0) {
          # code...
          $total_credit=0;
        }else{
          $result = $ligne->fetch_assoc();
          $total_credit = floatval($result["total_credit"]);
        }

        /////////// reboursement a une date x 

        $sql = "SELECT SUM(montant) AS total_remboursement FROM remborsement WHERE  date_remb = '$date_caisse'";
        $ligne = $connect->query($sql);

        $ligneback = $ligne->num_rows;
        $total_rembourse;
        if ($ligneback == 0) {
          # code...
          $total_rembourse=0;
        }else{
          $result = $ligne->fetch_assoc();
          $total_rembourse = floatval($result["total_remboursement"]);
        }

        /////////// depense a une date x 

        $sql = "SELECT SUM(prix_total_depense) AS total_depense FROM depenses WHERE  date_depense = '$date_caisse'";
        $ligne = $connect->query($sql);
          $ligneback = $ligne->num_rows;
        $total_depense;
        if ($ligneback == 0) {
          # code...
          $total_depense=0;
        }else{
          $result = $ligne->fetch_assoc();
          $total_depense = floatval($result["total_depense"]);
        }

        /////////// depense a une date x 

        $sql = "SELECT SUM(montant_verse) AS montant_verse FROM versement WHERE  date_bordereau = '$date_caisse'";
        $ligne = $connect->query($sql);
        $ligneback = $ligne->num_rows;
        $total_verse;
        if ($ligneback == 0) {
          # code...
          $total_verse=0;
        }else{
          $result = $ligne->fetch_assoc();
        $total_verse= floatval($result["montant_verse"]);
        }

             /////////// sortie a une date x 

        $sql = "SELECT SUM(montant) AS total_sortie FROM bon_sortie WHERE  date_sortie = '$date_caisse'";
        $ligne = $connect->query($sql);
          $ligneback = $ligne->num_rows;
        $total_sortie;
        if ($ligneback == 0) {
          # code...
          $total_sortie=0;
        }else{
          $result = $ligne->fetch_assoc();
          $total_sortie = floatval($result["total_sortie"]);
        }

        /////////// caisse a une date x 
        
       /* $hier = new DateTime('-1 day');
        $date_caisseHier = $hier -> format('Y-m-d');*/

        $dayJuour = new DateTime($date_caisse);
        $day = $dayJuour->format("d");
        $mois = $dayJuour->format("m");
        $anne = $dayJuour->format("Y");
        $dayHier = $day - 1;
        $dateComplete = "".$dayHier."-".$mois."-".$anne."";
        $dateCompleHier = new DateTime("$dateComplete");
        $date_caisseHier = $dateCompleHier->format("Y-m-d");

        $sql = "SELECT SUM(montant_caisse) AS montant_caisse FROM caisse WHERE  date_caisse = '$date_caisseHier'";
        $ligne = $connect->query($sql);
        $ligneback = $ligne->num_rows;
        $total_caisseHier;
        if ($ligneback == 0) {
          # code...
          $total_caisseHier=0;
        }else{
          $result = $ligne->fetch_assoc();
          $total_caisseHier= floatval($result["montant_caisse"]);
        }


        $montant_caisse = $total_caisseHier + $order_total - $total_credit -  $total_depense - $total_sortie  + $total_rembourse - $total_verse;

        $sql = "UPDATE  caisse 
          SET montant_caisse = '$montant_caisse'
          WHERE date_caisse = '$date_caisse'
         ";

        if($connect->query($sql) === TRUE) {
          $valid['success'] = true;
          $valid['messages'] = "La caisse  a été mise a jour";  
        } else {
          $valid['success'] = false;
          $valid['messages'] = "Error while adding the members ".mysqli_error($connect);
        }

      }

       echo json_encode($valid);

	}
?>