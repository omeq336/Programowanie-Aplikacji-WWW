<?php
session_start();

include('php/cfg.php');
include('admin/admin.php'); 
include('php/showpage.php'); 
include('php/contact.php');
include('php/shop_mangement.php');
include('php/product_management.php');

error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);

if (!SprawdzDostep()) {
    exit();  
}


if (isset($_GET['akcja'])) {
    if ($_GET['akcja'] === 'dodaj') {
        DodajNowaPodstrone();
    } elseif ($_GET['akcja'] === 'edytuj') {
        EdytujPodstrone();
    } elseif ($_GET['akcja'] === 'usun') {
        UsunPodstrone(); 
    }
} else {
    if ($_GET['idp'] == '') $strona = pokazPodstrone(8);
    if ($_GET['idp'] == 'podstrona1') $strona = pokazPodstrone(9);
    if ($_GET['idp'] == 'podstrona2') $strona = pokazPodstrone(10);
    if ($_GET['idp'] == 'podstrona3') $strona = pokazPodstrone(11);
    if ($_GET['idp'] == 'podstrona4') $strona = pokazPodstrone(12);
    if ($_GET['idp'] == 'podstrona5') $strona = pokazPodstrone(13);
    if ($_GET['idp'] == 'podstrona6') $strona = pokazPodstrone(14);
}
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="css/style.css">
<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
<meta http-equiv="Content-Language" content="pl" />
<meta name="Author" content="k"/>
<script src="js/timedate.js" type="text/javascript"></script>
<script src="js/kolorujtlo.js" type="text/javascript"></script>   
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<title>Filmy oscarowe</title>
</head>
<body>
    <menu>
        <?php
            echo $strona;  
            PokazKontakt();
            ListaPodstron();
            PokazFormularze();
            PokazKategorie();
            PokazFormularzeProduktow();
            PokazProdukty();


        ?>
    </menu>
</body>
</html>
+