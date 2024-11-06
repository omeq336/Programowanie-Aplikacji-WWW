<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);

$filename1 = 'html/film1.html';
$filename2 = 'html/film2.html';
$filename3 = 'html/film3.html';
$filename4 = 'html/film4.html';
$filename5 = 'html/film5.html';
$filename6 = 'html/filmy.html';


if($_GET['idp'] == '') $strona = 'html/glowna.html';

if(file_exists($filename1)){
    if($_GET['idp'] == 'podstrona1') $strona = 'html/film1.html';
}
else{
    $strona = 'html/glowna.html';
}

if(file_exists($filename2)){
    if($_GET['idp'] == 'podstrona2') $strona = 'html/film2.html';
}
else{
    $strona = 'html/glowna.html';
}

if(file_exists($filename3)){
    if($_GET['idp'] == 'podstrona3') $strona = 'html/film3.html';
}
else{
    $strona = 'html/glowna.html';
}

if(file_exists($filename4)){
    if($_GET['idp'] == 'podstrona4') $strona = 'html/film4.html';
}
else{
    $strona = 'html/glowna.html';
}

if(file_exists($filename5)){
    if($_GET['idp'] == 'podstrona5') $strona = 'html/film5.html';
}
else{
    $strona = 'html/glowna.html';
}

if(file_exists($filename6)){
    if($_GET['idp'] == 'podstrona6') $strona = 'html/filmy.html';
}
else{
    $strona = 'html/glowna.html';
}

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
    include($strona)
    ?>
    </menu>
</body>
</html>