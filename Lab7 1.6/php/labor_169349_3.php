<!DOCTYPE html>
<html lang="pl">
<head>
<meta charset="UTF-8">
</head>
<body>

<?php
$nr_indeksu = '169349';
$nrGrupy = '3';

echo 'Jakub Pawlak'.$nr_indeksu.' grupa '.$nrGrupy.'<br /> <br />';
echo 'Zastosowanie metody include() <br />';


if((include 'includeTest.php') == TRUE){
echo 'OK';
echo " A $color $fruit <br>";
}


echo '<br>Zastosowanie metody require_once() <br />';


$s = require_once 'includeTest.php';
echo "\n" . $s;

echo '<br><br>Zastosowanie if, else, elseif<br />';

$a = "pata";
if($a == "sata"){
	echo "To jest sata!";
}else if ($a == "pata")
{
	echo "To jest pata!";
}else
{
	echo "Zmienna nie pasuje do niczego";
}

echo '<br><br>Zastosowanie switch<br />';

$kosc = 5;
switch ($kosc){
	case 1:
	echo "Na kosci widnieje 1!";
	break;	
    case 2:
	echo "Na kosci widnieje 2!";
	break;	
    case 3:
	echo "Na kosci widnieje 3!";
	break;	
    case 4:
	echo "Na kosci widnieje 4!";
	break;	
    case 5:
	echo "Na kosci widnieje 5!";
	break;	
    case 6:
	echo "Na kosci widnieje 6!";
	break;

	
	default:
	echo "Coś chyba poszło nie tak...<br>";
}

echo '<br><br>Zastosowanie for<br />';
for($i = 0; $i < 10; $i++){
	echo "Jesteśmy na: $i <br>";
}

echo '<br>Zastosowanie while<br />';
$j = 9;
while($j >= 0){
	echo "Cyfra to $j <br>";
	$j -= 1;
}


echo "<br>Zastosowanie GET<br>";
echo 'Witaj, ' . htmlspecialchars($_GET["name"]) . '!';
#Trzeba podać przy adresie strony dodatkowo ?name=Imie
?>


<form action="labor_169349_3.php" method="post">
<label for="name">Imię:</label>
<input type="text" id="name" name="name">
<input type="submit" value="Wyślij">
</form>
    
    
<?php
    echo "<br>Zastosowanie POST<br>";
    echo 'Witaj, ' . htmlspecialchars($_POST["name"]) . '!';
    
    echo "<br>Zastosowanie SESSION<br>";
    
    session_start();
    if(isset($_SESSION['counter'])){
        $_SESSION['counter']++;
    } else {
        $_SESSION['counter'] = 1;
    }
    
    echo "Odwiedziłeś tę stronę: " . $_SESSION['counter'] . " razy.";
?>
</body>
</html>