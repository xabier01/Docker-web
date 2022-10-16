<?php
	//Saioa hasi
	session_start();
	//DB-AREKIN KONEXIOA LORTU
	$konexioa = mysqli_connect("db", "admin", "test", "database");
	//ERROREA EMAN BADU
	if ($konexioa -> connect_error) 
	{
		die("Konexio zapustu da");
	}
	//SARTU BOTOIA SAKATU BADA, JOKOA SARTU DB-AN
	if(isset($_POST["sartuJokBotoi"])) 
	{
    
		$titulua= $_POST['titulua'];
		$generoa= $_POST['generoa'];
		$balorazioa= $_POST['balorazioa'];
		$jokoAdina= $_POST['adina'];
		$laburpena= $_POST['laburpena'];
		$pertsonaiPrin= $_POST['printzipalak'];
		$gehitu= "INSERT INTO jokoak(titulua, generoa, balorazioa, jokoAdina, laburpena, pertsonaiPrin) VALUES ('$titulua', '$generoa' , '$balorazioa', '$jokoAdina' , '$laburpena', '$pertsonaiPrin')";
		$emaitza= mysqli_query($konexioa, $gehitu);
		//JOKOA SARTU BADA
		if ($emaitza)
		{
			echo "Jokoa sartu da";
		}			
		else
		{
			//echo "Jokoa ezin da sartu";
			die ("Jokoa gehitzea ez da posible izan" .  $konexioa-> error);
		}
		
	}

	//EDITATU BOTOIA SAKATU BADA, JOKOA EDITATU DB-AN
	if(isset($_POST["editatuJokBotoi"])) 
	{
		$aldatzekoTitulua=$_POST['tituluZahar'];
		$titulua= $_POST['titulua'];
		$generoa= $_POST['generoa'];
		$balorazioa= $_POST['balorazioa'];
		$jokoAdina= $_POST['adina'];
		$laburpena= $_POST['laburpena'];
		$pertsonaiPrin= $_POST['printzipalak'];
		$editatu= "UPDATE jokoak SET titulua='$titulua', generoa='$generoa', balorazioa='$balorazioa', jokoAdina='$jokoAdina', laburpena ='$laburpena' , pertsonaiPrin='$pertsonaiPrin' WHERE titulua='$aldatzekoTitulua' ";
		$emaitza= mysqli_query($konexioa, $editatu);
		//JOKOA EDITATU BADA
		if ($emaitza)
		{
			echo "Jokoa editatu da";
		}			
		else
		{
			//echo "Jokoa ezin da editatu";
			die ("Jokoa editatzea ez da posible izan" .  $konexioa-> error);
		}
		
	}


	//EZABATU BOTOIA SAKATU BADA, JOKOA EZABATU DB-AN
	if(isset($_POST["ezabatuJokBotoi"])) 
	{
		$aldatzekoTitulua=$_POST['tituluZahar'];
		$titulua= $_POST['titulua'];
		$generoa= $_POST['generoa'];
		$balorazioa= $_POST['balorazioa'];
		$jokoAdina= $_POST['adina'];
		$laburpena= $_POST['laburpena'];
		$pertsonaiPrin= $_POST['printzipalak'];
		$ezabatu= "DELETE FROM jokoak WHERE titulua='$aldatzekoTitulua' ";
		$emaitza= mysqli_query($konexioa, $ezabatu);
		//JOKOA EZABATU BADA
		if ($emaitza)
		{
			echo "Jokoa ezabatu da";
		}			
		else
		{
			//echo "Jokoa ezin da ezabatu";
			die ("Jokoa ezabatzea ez da posible izan" .  $konexioa-> error);
		}
		
	}


?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
		<!--METADUATUAK-->
        <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
		<meta content="utf-8" http-equiv="encoding">
        <!--WEB IZENA-->
        <title>Web</title>
        <!--EREMU ERREFERENTZIAK-->
        <link rel="stylesheet" type="text/css" href="grafikak.css">
		<script src="funtzioak.js" type="text/javascript"></script>
    </head>
    <body>
    <!--GOIBURUA-->
        <header class="header2">
            <div class="wrapper">
                <div class="logo">XAGOUN</div>
                
                <nav>
                    <a href="index.php">Home</a>
                    <a href="jokoak.php">Jokoak</a>
                    <a href="pertsonaiak.php">Pertsonaiak</a>
					<a id ="saioaHasi" href="saioaHasi.php">Saioa hasi</a>
                    <a id ="erregistroa" href="erregistroa.php">Erregistroa</a>
					<a hidden class="zelai" id="saioPerfila" href="saioPerfila.php">Perfila</a>
			        <a hidden class="zelai" id="saioaItxi" href="saioaItxi.php">Saioa itxi</a>
					
                </nav>
            </div>
            </div>
        </header>
		<!--JOKOAREN GEHIKETA/ALDAKETA/EZABAKETA DATUAK-->
		<form action="" method="POST" style="float: left; width: 75%; text-align: center; margin: 10%; padding-bottom: 0%" >
			<h3>Jokoa gehitu</h3>
			Editatzeko/Ezabatzeko nahian, sartu aldatu nahi den jokoaren titulua: <input type="text" class="zelai" id="idTitZahar" name="tituluZahar" onblur="egiaztatuJoko(this)"/><br>
			Jokoaren titulua: <input type="text" class="zelai" id="idTitulu" name="titulua" onblur="egiaztatuJoko(this)"/><br>
            Generoa: <input type="text" class="zelai" id="idGeneroa" name="generoa" onblur="egiaztatuJoko(this)"/><br>
			Balorazioa: <input type="text" class="zelai" id="idBalorazioa" name="balorazioa" onblur="egiaztatuJoko(this)"/><br>
			Jokoaren Adina: <input type="text" class="zelai" id="idAdina" name="adina" onblur="egiaztatuJoko(this)"/><br>
			Laburpena: <input type="text" class="zelai" id="idLaburpena" name="laburpena"  onblur="egiaztatuJoko(this)"/><br>
			Pertsonai printzipalak: <input type="text" class="zelai" id="idPrintzipalak" name="printzipalak" onblur="egiaztatuJoko(this)"/><br>
			<input type="submit" class="botoiSartu" id="sartuJokBotoi" name="sartuJokBotoi" value="Sartu jokoa" disabled/>
			<input type="submit" class="botoiEditatu" id="editatuJokBotoi" name="editatuJokBotoi" value="Editatu jokoa" disabled/>
			<input type="submit" class="botoiEzabatu" id="ezabatuJokBotoi" name="ezabatuJokBotoi" value="Ezabatu jokoa" disabled/>
		</form>
		<script src="funtzioak.js" type="text/javascript"></script>
		<div id="Jokoak editatu">
<?php

	//TAULA HASI
	echo
	"<table style= padding-left: 20%;>
    <tr>
        <th bgcolor=#fff>Titulua</th>
        <th bgcolor=#fff>Generoa</th>
        <th bgcolor=#fff>Balorazioa</th>
        <th bgcolor=#fff>Jokatzeko adin rekomendatua</th>
        <th bgcolor=#fff>Laburpena</th>
        <th bgcolor=#fff>Pertsonai printzipalak</th>
    </tr>";
	//JOKOEN KONTSULTA EGIN
	$kontsulta2= "SELECT * FROM jokoak";
	$emaitza2= mysqli_query($konexioa,$kontsulta2);
	//KONTSULTA ONA BADA
	if ($emaitza2)
	{
		while ($jokoa = mysqli_fetch_array($emaitza2)) {
			echo
			"<tr background-color:>
				<td bgcolor=#fff>{$jokoa['titulua']}</td>
				<td bgcolor=#fff>{$jokoa['generoa']}</td>
				<td bgcolor=#fff>{$jokoa['balorazioa']}</td>
				<td bgcolor=#fff>{$jokoa['jokoAdina']}</td>
				<td bgcolor=#fff>{$jokoa['laburpena']}</td>
				<td bgcolor=#fff>{$jokoa['pertsonaiPrin']}</td>
			</tr>
			";
		}
		echo "</table>";
	}

	//Saioa hasi den konprobatu
	if (isset($_SESSION['erabiltzaile'])) {
		//Saioa hasi bada, perfila eta saioa ixteko menua erakutsi behar dira eta saioa hasi eta erregistroa ezkutatu
		echo '<script type="text/javascript"> document.getElementById("erregistroa").style.display="none"; </script>';
		echo '<script type="text/javascript"> document.getElementById("saioaHasi").style.display="none"; </script>';

	}

    else{

		echo '<script type="text/javascript"> document.getElementById("saioPerfila").style.display="none"; </script>';
		echo '<script type="text/javascript"> document.getElementById("saioaItxi").style.display="none"; </script>';
    }


?>

			