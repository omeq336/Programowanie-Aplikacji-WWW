<?php
include('cfg.php');
include('showpage.php');

error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);

$filename1 = isset($_GET['page']) ? intval($_GET['page']) : 2;
$filename2 = 'html/film2.html';
$filename3 = 'html/film3.html';
$filename4 = 'html/film4.html';
$filename5 = 'html/film5.html';
$filename6 = 'html/filmy.html';


if($_GET['idp'] == '') $strona = pokazPodstrone(3);
if($_GET['idp'] == 'podstrona1') $strona = pokazPodstrone(2);
if($_GET['idp'] == 'podstrona2') $strona = pokazPodstrone(4);
if($_GET['idp'] == 'podstrona3') $strona = pokazPodstrone(5);
if($_GET['idp'] == 'podstrona4') $strona = pokazPodstrone(6);
if($_GET['idp'] == 'podstrona5') $strona = pokazPodstrone(7);
if($_GET['idp'] == 'podstrona6') $strona = pokazPodstrone(8);
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="css/mojcss.css">
<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
<meta http-equiv="Content-Language" content="pl" />
<meta name="Author" content="Jakub Pawlak"/>
<script src="js/timedate.js" type="text/javascript"></script>
<script src="js/kolorujtlo.js" type="text/javascript"></script>   
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<title>Filmy oscarowe</title>
</head>
<body>
	<menu>
    <?php
        echo $strona;
    ?>
    </menu>
</body>
</html>