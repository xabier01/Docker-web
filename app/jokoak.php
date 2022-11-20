<?php
//header_remove(“Server”);
header('X-Frame-Options: SAMEORIGIN');
header('X-XSS-Protection: 0');
header('X-Content-Type-Options: nosniff');
header_remove("X-Powered-By");

ini_set("session.cookie_httponly", True);
	//Saioa hasi
	session_start();
	//DB-AREKIN KONEXIOA LORTU
	$konexioa = mysqli_connect("db", "admin", "test", "database");
	//ERROREA EMAN BADU
	if ($konexioa -> connect_error) 
	{
		die("Konexio zapustu da");
	}

	$konexioa-> set_charset('utf8');
 	
	//SARTU BOTOIA SAKATU BADA, JOKOA SARTU DB-AN
	if(isset($_POST["sartuJokBotoi"])) 
	{
    
		$titulua = $konexioa->real_escape_string (htmlspecialchars($_POST['titulua']));
		$generoa = $konexioa->real_escape_string (htmlspecialchars($_POST['generoa']));
		$balorazioa = $konexioa->real_escape_string (htmlspecialchars($_POST['balorazioa']));
		$jokoAdina = $konexioa->real_escape_string (htmlspecialchars($_POST['adina']));
		$laburpena = $konexioa->real_escape_string (htmlspecialchars($_POST['laburpena']));
		$pertsonaiPrin = $konexioa->real_escape_string (htmlspecialchars($_POST['printzipalak']));
		$csrf = $konexioa->real_escape_string($_POST['csrf']);
		if(!empty($titulua) && !empty($generoa) && !empty($balorazioa) && !empty($jokoAdina) && !empty($laburpena) && !empty($pertsonaiPrin) && !empty($csrf)){
            if($_SESSION['csrf'] === $csrf){
                echo "csrf ondo";
                unset($_SESSION['csrf']);
            }else{
                echo "csrf txarto";
            }
        }

		if ($gehitu=$konexioa->prepare("INSERT INTO jokoak(titulua, generoa, balorazioa, jokoAdina, laburpena, pertsonaiPrin) VALUES (? , ? , ? , ? , ? , ? )"))
		{
			$gehitu->bind_param('ssssss', $titulua, $generoa, $balorazioa, $jokoAdina, $laburpena, $pertsonaiPrin);
            $emaitza=$gehitu->execute();

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
			$gehitu->close();
		}
		
	}

	//EDITATU BOTOIA SAKATU BADA, JOKOA EDITATU DB-AN
	if(isset($_POST["editatuJokBotoi"])) 
	{
		$aldatzekoTitulua=$konexioa->real_escape_string(htmlspecialchars($_POST['tituluZahar']));
		$titulua=$konexioa->real_escape_string (htmlspecialchars($_POST['titulua']));
		$generoa=$konexioa->real_escape_string (htmlspecialchars($_POST['generoa']));
		$balorazioa=$konexioa->real_escape_string (htmlspecialchars($_POST['balorazioa']));
		$jokoAdina=$konexioa->real_escape_string (htmlspecialchars($_POST['adina']));
		$laburpena=$konexioa->real_escape_string (htmlspecialchars($_POST['laburpena']));
		$pertsonaiPrin=$konexioa->real_escape_string (htmlspecialchars($_POST['printzipalak']));
		$csrf = $konexioa->real_escape_string($_POST['csrf']);
		if(!empty($aldatzekoTitulua) && !empty($titulua) && !empty($generoa) && !empty($balorazioa) && !empty($jokoAdina) && !empty($laburpena) && !empty($pertsonaiPrin) && !empty($csrf)){
            if($_SESSION['csrf'] === $csrf){
                echo "csrf ondo";
                unset($_SESSION['csrf']);
            }else{
                echo "csrf txarto";
            }
        }
		if($editatu= $konexioa->prepare ("UPDATE jokoak SET titulua= ? , generoa= ? , balorazioa= ? , jokoAdina= ? , laburpena = ? , pertsonaiPrin= ? WHERE titulua= ? "))
		{
			$editatu->bind_param('sssssss', $titulua, $generoa, $balorazioa, $jokoAdina, $laburpena, $pertsonaiPrin, $aldatzekoTitulua);
			$emaitza=$editatu->execute();
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
			$editatu->close();
		}
		
	}


	//EZABATU BOTOIA SAKATU BADA, JOKOA EZABATU DB-AN
	if(isset($_POST["ezabatuJokBotoi"])) 
	{
		$aldatzekoTitulua=$konexioa->real_escape_string(htmlspecialchars($_POST['tituluZahar']));
		$titulua= $konexioa->real_escape_string(htmlspecialchars($_POST['titulua']));
		$generoa= $konexioa->real_escape_string(htmlspecialchars($_POST['generoa']));
		$balorazioa= $konexioa->real_escape_string(htmlspecialchars($_POST['balorazioa']));
		$jokoAdina= $konexioa->real_escape_string(htmlspecialchars($_POST['adina']));
		$laburpena= $konexioa->real_escape_string(htmlspecialchars($_POST['laburpena']));
		$pertsonaiPrin= $konexioa->real_escape_string(htmlspecialchars($_POST['printzipalak']));
		$csrf = $konexioa->real_escape_string($_POST['csrf']);
		if(!empty($aldatzekoTitulua) && !empty($csrf)){
            if($_SESSION['csrf'] === $csrf){
                echo "csrf ondo";
                unset($_SESSION['csrf']);
            }else{
                echo "csrf txarto";
            }
        }
		if($ezabatu= $konexioa->prepare("DELETE FROM jokoak WHERE titulua= ? "))
		{
			$ezabatu->bind_param('s', $aldatzekoTitulua);
			$emaitza=$ezabatu->execute();
		
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
			$ezabatu->close();
		}
		
	}
	$token = md5(uniqid(rand(),true));
    $_SESSION['csrf'] = $token; //token del servidor (cada vez que se recarga la pagina se crea nueva)

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
		<!--METADUATUAK-->
        <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
        <meta http-equiv="Content-Security-Policy" charset="utf-8">
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
			<input type="hidden" name="csrf" value="<?php echo $token; ?>">
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

			