<?php 
require_once 'php_action/db_connect.php';

session_start();
date_default_timezone_set('Africa/Bujumbura');

if(isset($_SESSION['userId'])) {
	header('location: http://localhost/stock/dashboard.php');	
}

$errors = array();

if($_POST) {		

	$username = $_POST['username'];
	$password = $_POST['password'];

	if(empty($username) || empty($password)) {
		if($username == "") {
			$errors[] = "Pseudo est obligatoire";
		} 

		if($password == "") {
			$errors[] = "Mot de passe est obligatoire";
		}
	} else {
		$sql = "SELECT * FROM users WHERE username = '$username' ";
		$result = $connect->query($sql);

		if($result->num_rows == 1) {
			
			// exists and account status
			$sql = "SELECT * FROM users WHERE username = '$username' AND status = 1";
			$result = $connect->query($sql);
			if($result->num_rows == 1) {
				// exists
				$password = md5($password);
				$mainSql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
				$mainResult = $connect->query($mainSql);

				if($mainResult->num_rows == 1) {
					$value = $mainResult->fetch_assoc();
					$user_id = $value['user_id'];
					$role = $value['role'];
					$name = $value['username'];
					$agence = $value['id_agence'];
					$date_enter = date("Y-m-d H:m:s", STRTOTIME(date('h:i:sa')));
					
					$date_close = date("Y-m-d");

					$online = "INSERT INTO user_online(id_user,date_enter,date_close,status) VALUES ($user_id, '$date_enter','$date_close',1)";
					$connect->query($online);

					$lastId = $connect->insert_id;
					$agenceName ="SELECT agence FROM agence WHERE id_agence = $agence"; 
					$agenceSelect = $connect->query($agenceName);
					$agenceResultat = $agenceSelect->fetch_assoc();
					$nameAgence = $agenceResultat["agence"];
					// set session
					$_SESSION['userId'] = $user_id;
					$_SESSION['userRole'] = $role;
					if ($role == 1) {
						$_SESSION['role'] = "Directeur(trice)";
					}elseif ($role == 2) {
						$_SESSION['role'] = "Stock";
					}elseif ($role == 3) {
						$_SESSION['role'] = "Facturation";
					}elseif ($role == 4) {
						$_SESSION['role'] = "Comptable";
					}elseif ($role == 5) {
						$_SESSION['role'] = "Administreteur";
					}
					$_SESSION['userName'] = $name;
					$_SESSION['lastId'] = $lastId;
					$_SESSION["agenceId"] = $agence;
					$_SESSION["nameAgence"] = $nameAgence; 


					header('location: http://localhost/stock/dashboard.php');	
				} else{
					
					$errors[] = "Combinaison nom d'utilisateur / mot de passe incorrecte";
				} // /else
			}else{
				$errors[] = "Veillez contacte l'administrateur du systeme";
			} /// else status
			
		} else {		
			$errors[] = "Le nom d'utilisateur n'existe pas";		
		} // /else
	} // /else not empty username // password
	
} // /if $_POST
?>

<!DOCTYPE html>
<html>
<head>
	<title>Stock Management System</title>
	<link rel="shortcut icon" type="image/x-icon" href="assests/images/stock12.ico" />
	<!-- bootstrap -->
	<link rel="stylesheet" href="assests/bootstrap/css/bootstrap.min.css">
	<!-- bootstrap theme-->
	<link rel="stylesheet" href="assests/bootstrap/css/bootstrap-theme.min.css">
	<!-- font awesome -->
	<link rel="stylesheet" href="assests/font-awesome/css/font-awesome.min.css">

  <!-- custom css -->
  <link rel="stylesheet" href="custom/css/custom.css">	

  <!-- jquery -->
	<script src="assests/jquery/jquery.min.js"></script>
  <!-- jquery ui -->  
  <link rel="stylesheet" href="assests/jquery-ui/jquery-ui.min.css">
  <script src="assests/jquery-ui/jquery-ui.min.js"></script>

  <!-- bootstrap js -->
	<script src="assests/bootstrap/js/bootstrap.min.js"></script>
	<style type="text/css">
		.titre{
			text-align: center;
			font-size: 35px;
			font-family: arial;
		}
		.logo img{
			width:80%;
			height:20%;


		}
</style>

</head>

<body>
	<div class="col-md-12">
		<div class="col-md-9 col-md-offset-2 logo">
			<img src="assests/images/stock.png">	
		</div>	
	</div>
	
	<div class="container">
		<div class="row vertical">
			
			<div class="col-md-5 col-md-offset-4">
				
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title">Connectez - Vous </h3>
					</div>
					<div class="panel-body">

						<div class="messages">
							<?php if($errors) {
								foreach ($errors as $key => $value) {
									echo '<div class="alert alert-danger" role="alert">
									<i class="glyphicon glyphicon-exclamation-sign"></i>
									'.$value.'</div>';										
									}
								} ?>
						</div>

						<form class="form-horizontal backg" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" id="loginForm">
							<fieldset>
							  <div class="form-group">
									<label for="username" class="col-sm-4 control-label">Pseudo</label>
									<div class="col-sm-8">
									  <input type="text" class="form-control" id="username" name="username" placeholder="Pseudo" autocomplete="off" />
									</div>
								</div>
								<div class="form-group">
									<label for="password" class="col-sm-4 control-label">Mot de Passe</label>
									<div class="col-sm-8">
									  <input type="password" class="form-control" id="password" name="password" placeholder="Mot de Passe" autocomplete="off" />
									</div>
								</div>								
								<div class="form-group">
									<div class="col-sm-offset-6 col-sm-10">
									  <button type="submit" class="btn btn-primary"> <i class="glyphicon glyphicon-log-in"></i> Connexion</button>
									</div>
								</div>
							</fieldset>
						</form>
					</div>
					<!-- panel-body -->
				</div>
				<!-- /panel -->
			</div>
			<!-- /col-md-4 -->
		</div>
		<!-- /row -->
	</div>
	<!-- container -->	
</body>
</html>







	