<?php 
require_once 'php_action/core.php'; ?>
<?php date_default_timezone_set('Africa/Cairo'); ?>
<!DOCTYPE html>
<html>
<head>

	<title>Stock Management System</title>
  <meta charset="utf-8">

  <link rel="shortcut icon" type="image/x-icon" href="assests/images/stock12.ico" />
	<!-- bootstrap -->
	<link rel="stylesheet" href="assests/bootstrap/css/bootstrap.min.css">
	<!-- bootstrap theme-->
	<link rel="stylesheet" href="assests/bootstrap/css/bootstrap-theme.min.css">

    <link rel="stylesheet" href="assests/bootstrap/css/dataTables.bootstrap.min.css">
    <!-- <link rel="stylesheet" href="assests/plugins/datatables/datatables.min.css"> -->


	<!-- font awesome -->
	<link rel="stylesheet" href="assests/font-awesome/css/font-awesome.min.css">

  <!-- custom css -->
  <link rel="stylesheet" href="custom/css/custom.css">

	<!-- DataTables -->
  <!--<link rel="stylesheet" href="assests/plugins/datatables/jquery.dataTables.min.css"> -->

  <!-- file input -->
  <link rel="stylesheet" href="assests/plugins/fileinput/css/fileinput.min.css">

  <!-- jquery -->
	<script src="assests/jquery/jquery.min.js"></script>
  <script src="assests/jquery/jquery.dataTables.min.js"></script>
  <script src="assests/jquery/dataTables.bootstrap.min.js"></script>
  <!-- jquery ui -->  
 <link rel="stylesheet" href="assests/jquery-ui/jquery-ui.min.css">
  <script src="assests/jquery-ui/jquery-ui.min.js"></script>

  <!-- bootstrap js -->
	<script src="assests/bootstrap/js/bootstrap.min.js"></script>
<style type="text/css">
.imageLogo{
  float:left;
  
}

.imageLogo img{
  width: 60%;
  float:left;
  margin: 0px;
}

</style>
</head>
<body>

</body>
	<nav class="navbar navbar-default  navbar-fixed-top">
		<div class="container container-fluid">
    <div class="col-md-2 imageLogo"><img src="assests/images/stock123.png" style="" ></div>
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <!-- <a class="navbar-brand" href="#">Brand</a> -->
    </div>


    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">      

      <ul class="nav navbar-nav navbar-right">        

      	<li id="navDashboard"><a href="index.php"><i class="glyphicon glyphicon-list-alt"></i>  Tableau de Bord</a></li>  
        <?php if($_SESSION["userRole"] == 1 || $_SESSION["userRole"] == 5) { ?>
        
           
        
          
        <li class="dropdown" id="navProduct">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-ruble"></i> Produits <span class="caret"></span></a>
          <ul class="dropdown-menu">   
          <li id="navProductStock"><a href="stockGeneral.php"> <i class="glyphicon glyphicon-ruble"></i> Stock Général </a></li>          
           <li id="navProductList"><a href="product.php?o=produit"> <i class="glyphicon glyphicon-ruble"></i> Liste de produits </a></li>  
           <li id="navstock"><a href="product.php?o=stock"> <i class="glyphicon glyphicon-ruble"></i> Gestion de stock </a></li>           
            <li id="topNavManage"><a href="product.php?o=stockAgence"> <i class="glyphicon glyphicon-ruble"></i> Liste de transfer de produits </a></li>
             <li id="topNavManageAgenceStock"><a href="product.php?o=stockParAgence"> <i class="glyphicon glyphicon-ruble"></i> Gestion de stock Par dépôt </a></li>

            </li>            
          </ul>
        </li>
          <li class="dropdown" id="navDepense">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-money"></i> Gestion <span class="caret"></span></a>
          <ul class="dropdown-menu">            
            <li id="topNavManageDepense"><a href="depense.php"> <i class="fa fa-money"></i> Depenses</a></li>            
            <li id="topNavManageCommande"><a href="commande.php"> <i class="fa fa-first-order"></i> Commandes</a></li>
            <li id="topNavManageSortie"><a href="sortie.php"> <i class="fa fa-money"></i> Sorties</a></li> 
              <li>---------------------------------</li> 
              <li id="topNavManageVersement"><a href="versement.php"> <i class="fa fa-money"></i> Versements</a></li>
              <li>---------------------------------</li> 
              <li id="topNavManageCaisse"><a href="caisse.php"> <i class="fa fa-money"></i> Caisse</a></li>            
          </ul>
        </li>   
        <li class="dropdown" id="navOrder">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="glyphicon glyphicon-shopping-cart"></i> Ventes <span class="caret"></span></a>
          <ul class="dropdown-menu">            
            <li id="topNavAddOrder"><a href="orders.php?o=add"> <i class="glyphicon glyphicon-plus"></i>Nouvelle Facture</a></li>            
            <li id="topNavManageOrder"><a href="orders.php?o=manord"> <i class="glyphicon glyphicon-edit"></i> Gestion des Ventes</a></li>            
          </ul>
        </li> 
        <li class="dropdown" id="navUser">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-cog"></i> Parametrages <span class="caret"></span></a>
          <ul class="dropdown-menu">            
            <li id="topNavAddUser"><a href="utilisateur.php?o=addUser"> <i class="fa fa-user"></i> Ajoute Utilisateur</a></li>            
            <li id="topNavManageUsers"><a href="utilisateur.php?o=manOnline"> <i class="fa fa-users"></i> Gestion Utilisateur</a></li>  


            <li id="topNavSociete"><a href="societe.php?o=societe"> <i class="glyphicon glyphicon-home"></i> Gestion Société</a>
             <li id="topNavAgence"><a href="agence.php?o=agence"> <i class="fa fa-building"></i> Gestion des agences</a>
              
            </li>
            <li>----------------------------------------</li>
            <li id="navBrand"><a href="brand.php"><i class="glyphicon glyphicon-btc"></i> Fournisseurs</a></li>
            <li>----------------------------------------</li>
          <li id="navClient"><a href="client.php"> <i class="fa fa-users"></i> Clients</a></li> 
           <li>----------------------------------------</li>
          <li id="navCategories"><a href="categories.php"> <i class="fa fa-list"></i> Categories</a></li>
          <li>----------------------------------------</li>
          <li id="navCategories"><a href="banque.php"> <i class="fa fa-list"></i> Banque</a></li>
          <li>----------------------------------------</li>
          <li id="navComptabilite"><a href="comptabilite.php?o=classe"> <i class="fa fa-list"></i> Comptabilités</a></li>             
          </ul>

        </li> 
        <li id="navReport"><a href="report.php"> <i class="fa fa-flag"></i> Rapports </a></li>
        
<?php } elseif ($_SESSION["userRole"] == 2 ) { ?>
     <li class="dropdown" id="navProduct">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-ruble"></i> Produits <span class="caret"></span></a>
          <ul class="dropdown-menu">   
          <li id="navProductStock"><a href="stockGeneral.php"> <i class="glyphicon glyphicon-ruble"></i> Stock Général </a></li>          
           <li id="navProductList"><a href="product.php?o=produit"> <i class="glyphicon glyphicon-ruble"></i> Liste de produits </a></li>  
           <li id="navstock"><a href="product.php?o=stock"> <i class="glyphicon glyphicon-ruble"></i> Gestion de stock </a></li>           
            <li id="topNavManage"><a href="product.php?o=stockAgence"> <i class="glyphicon glyphicon-ruble"></i> Liste de transfer de produits </a></li>
             <li id="topNavManageAgenceStock"><a href="product.php?o=stockParAgence"> <i class="glyphicon glyphicon-ruble"></i> Gestion de stock Par dépôt </a></li>

            </li>            
          </ul>
        </li>
          <li class="dropdown" id="navDepense">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-money"></i> Gestion <span class="caret"></span></a>
          <ul class="dropdown-menu">            
            <li id="topNavManageDepense"><a href="depense.php"> <i class="fa fa-money"></i> Depenses</a></li>            
            <li id="topNavManageCommande"><a href="commande.php"> <i class="fa fa-first-order"></i> Commandes</a></li>
            <li id="topNavManageSortie"><a href="sortie.php"> <i class="fa fa-money"></i> Sorties</a></li> 
              <li>---------------------------------</li> 
              <li id="topNavManageVersement"><a href="versement.php"> <i class="fa fa-money"></i> Versements</a></li>
              <li>---------------------------------</li> 
              <li id="topNavManageCaisse"><a href="caisse.php"> <i class="fa fa-money"></i> Caisse</a></li>            
          </ul>
        </li>   
        <li class="dropdown" id="navOrder">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="glyphicon glyphicon-shopping-cart"></i> Ventes <span class="caret"></span></a>
          <ul class="dropdown-menu">            
            <li id="topNavAddOrder"><a href="orders.php?o=add"> <i class="glyphicon glyphicon-plus"></i>Nouvelle Facture</a></li>            
            <li id="topNavManageOrder"><a href="orders.php?o=manord"> <i class="glyphicon glyphicon-edit"></i> Gestion des Ventes</a></li>            
          </ul>
        </li> 
        <li class="dropdown" id="navUser">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-cog"></i> Parametrages <span class="caret"></span></a>
          <ul class="dropdown-menu">            
            <li id="topNavAddUser"><a href="utilisateur.php?o=addUser"> <i class="fa fa-user"></i> Ajoute Utilisateur</a></li>            
            <li id="topNavManageUsers"><a href="utilisateur.php?o=manOnline"> <i class="fa fa-users"></i> Gestion Utilisateur</a></li>  


            <li id="topNavSociete"><a href="societe.php?o=societe"> <i class="glyphicon glyphicon-home"></i> Gestion Société</a>
             <li id="topNavAgence"><a href="agence.php?o=agence"> <i class="fa fa-building"></i> Gestion des agences</a>
              
            </li>
            <li>----------------------------------------</li>
            <li id="navBrand"><a href="brand.php"><i class="glyphicon glyphicon-btc"></i> Fournisseurs</a></li>
            <li>----------------------------------------</li>
          <li id="navClient"><a href="client.php"> <i class="fa fa-users"></i> Clients</a></li> 
           <li>----------------------------------------</li>
          <li id="navCategories"><a href="categories.php"> <i class="fa fa-list"></i> Categories</a></li>
          <li>----------------------------------------</li>

          <li id="navCategories"><a href="banque.php"> <i class="fa fa-list"></i> Banque</a></li>
           <li>----------------------------------------</li>
          <li id="navComptabilite"><a href="comptabilite.php?o=classe"> <i class="fa fa-list"></i> Comptabilités</a></li>             
          </ul>

        </li> 
        <li id="navReport"><a href="report.php"> <i class="fa fa-flag"></i> Rapports </a></li>
         

  <?php
 
} elseif($_SESSION["userRole"] == 3 ) { ?>
           <li class="dropdown" id="navOrder">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="glyphicon glyphicon-shopping-cart"></i> Ventes <span class="caret"></span></a>
          <ul class="dropdown-menu">            
            <li id="topNavAddOrder"><a href="orders.php?o=add"> <i class="glyphicon glyphicon-plus"></i> Nouvelle Facture</a></li>            
            <li id="topNavManageOrder"><a href="orders.php?o=manord"> <i class="glyphicon glyphicon-edit"></i>Gestion des ventes </a></li>            
          </ul>
        </li> 
         <li class="dropdown" id="navSetting">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="glyphicon glyphicon-user"></i> <span class="caret"></span></a>
          <ul class="dropdown-menu">            
            <li id="topNavSetting"><a href="setting.php"> <i class="glyphicon glyphicon-wrench"></i> Parametre</a></li>            
            <li id="topNavLogout"><a href="logout.php"> <i class="glyphicon glyphicon-log-out"></i> Deconnection</a></li>            
          </ul>
        </li>  
         <?php }elseif ($_SESSION["userRole"] == 4) {
          ?>
           <li id="navReport"><a href="report.php"> <i class="glyphicon glyphicon-check"></i> Rapports </a></li>
       
          <?php
         } ?>

          <li class="dropdown" id="navSetting">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="glyphicon glyphicon-user"></i> <span class="caret"></span></a>
          <ul class="dropdown-menu">            
            <li id="topNavSetting"><a href="setting.php"> <i class="glyphicon glyphicon-wrench"></i> Parametre</a></li>            
            <li id="topNavLogout"><a href="logout.php"> <i class="glyphicon glyphicon-log-out"></i> Deconnection</a></li>            
          </ul>
        </li>      
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
	</nav><br><br><br>

	<div class="container">