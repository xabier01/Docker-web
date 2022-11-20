<?php
    //header_remove(“Server”);
    header('X-Frame-Options: SAMEORIGIN');
    header('X-XSS-Protection: 0');
    header('X-Content-Type-Options: nosniff');
    header_remove("X-Powered-By");
    
    ini_set("session.cookie_httponly", True);
//Saioa hasi
session_start();
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
        <form action="" method="POST" style="float: left; width: 75%; text-align: center; margin: 10%; padding-bottom: 0%" >
			<h3>Pertsonaia gehitu</h3>
			Editatzeko/Ezabatzeko nahian, sartu pertsonaiaren izena: <input type="text" class="zelai" id="idTitZahar" name="tituluZahar" onblur="egiaztatuPertsonai(this)"/><br>
            Pertsonaiaren izena: <input type="text" class="zelai" id="idPertsonai" name="pertsonaiIzena" onblur="egiaztatuPertsonai(this)"/><br>
			Agertzen den jokua/k: <input type="text" class="zelai" id="idAgerpenJoku" name="agerpenJoku" onblur="egiaztatuPertsonai(this)"/><br>
			<input type="hidden" name="csrf" value="<?php echo $token; ?>">
            <input type="submit" class="botoiSartu" id="sartuPertsBotoi" name="sartuPertsBotoi" value="Sartu pertsonaia" disabled>
            <input type="submit" class="botoiEditatu" id="editatuPertsBotoi" name="editatuPertsBotoi" value="Editatu pertsonaia" disabled>
			<input type="submit" class="botoiEzabatu" id="ezabatuPertsBotoi" name="ezabatuPertsBotoi" value="Ezabatu pertsonaia" disabled>
		</form>
        <script src="funtzioak.js" type="text/javascript"></script>
    </body>

<?php


	//TAULA HASI
	echo
	"<table>
    <tr>
        <th bgcolor=#fff>Pertsonaiaren izena</th>
        <th bgcolor=#fff>Agertzen den jokuaren izena</th>
        
    </tr>";


    //DB-arkin konexioa lortu
    $konexioa = mysqli_connect("db", "admin", "test", "database");
    //Errorea emon badu
    if ($konexioa -> connect_error) 
    {
        die("Konexio zapustu da");
    }

    $konexioa-> set_charset('utf8');

    if(isset($_POST["sartuPertsBotoi"])) {
        $pertsonaiIzena = $konexioa->real_escape_string(htmlspecialchars($_POST['pertsonaiIzena']));
        $agerpenJokuIzen = $konexioa->real_escape_string(htmlspecialchars($_POST['agerpenJoku']));
        $csrf = $konexioa->real_escape_string($_POST['csrf']);
        if(!empty($pertsonaiIzena) && !empty($agerpenJokuIzen) && !empty($csrf)){
            if($_SESSION['csrf'] === $csrf){
                echo "csrf ondo";
                unset($_SESSION['csrf']);
            }else{
                echo "csrf txarto";
            }
        }
        if ($gehitu = $konexioa->prepare("INSERT INTO pertsonaiak(pertsonaiIzena, agerpenJokuIzen) VALUES ( ? , ? )" )){
            
            $gehitu->bind_param('ss',$pertsonaiIzena, $agerpenJokuIzen);
            $emaitza=$gehitu->execute();
    
            if ($emaitza){ 
                echo "todo bien";
            }
            
            else{
                
                die ("Pertsonaia gehitzea ez da posible izan" .  $konexioa-> error);
            }
            $gehitu->close();
        }
    
    }


        //EDITATU BOTOIA SAKATU BADA, JOKOA EDITATU DB-AN
	if(isset($_POST["editatuPertsBotoi"])) 
	{
		$aldatzekoTitulua=$konexioa->real_escape_string(htmlspecialchars($_POST['tituluZahar']));
        $pertsonaiIzena= $konexioa->real_escape_string(htmlspecialchars($_POST['pertsonaiIzena']));
        $agerpenJokuIzen=$konexioa->real_escape_string(htmlspecialchars($_POST['agerpenJoku']));
		$csrf = $konexioa->real_escape_string($_POST['csrf']);
        if(!empty($aldatzekoTitulua) && !empty($pertsonaiIzena) && !empty($agerpenJokuIzen) && !empty($csrf)){
            if($_SESSION['csrf'] === $csrf){
                echo "csrf ondo";
                unset($_SESSION['csrf']);
            }else{
                echo "csrf txarto";
            }
        }
        if($editatu= $konexioa->prepare("UPDATE pertsonaiak SET pertsonaiIzena= ?, agerpenJokuIzen= ? WHERE pertsonaiIzena= ? ")){
            
            $editatu->bind_param('sss', $pertsonaiIzena, $agerpenJokuIzen, $aldatzekoTitulua);
            $emaitza = $editatu->execute();

            //PERTSONAIA EDITATU BADA
            if ($emaitza)
            {
                echo "Pertsonaia editatu da";
            }			
            else
            {
                
                die ("Pertsonaia editatzea ez da posible izan" .  $konexioa-> error);
            }
           $editatu->close(); 
        }
		
	}


	//EZABATU BOTOIA SAKATU BADA, JOKOA EZABATU DB-AN
	if(isset($_POST["ezabatuPertsBotoi"])) 
	{
		$aldatzekoTitulua=htmlspecialchars($_POST['tituluZahar']);
        $pertsonaiIzena= htmlspecialchars($_POST['pertsonaiIzena']);
        $agerpenJokuIzen= htmlspecialchars($_POST['agerpenJoku']);
		$csrf = $konexioa->real_escape_string($_POST['csrf']);
        if(!empty($aldatzekoTitulua) && !empty($csrf)){
            if($_SESSION['csrf'] === $csrf){
                echo "csrf ondo";
                unset($_SESSION['csrf']);
            }else{
                echo "csrf txarto";
            }
        }
        if($ezabatu= $konexioa->prepare("DELETE FROM pertsonaiak WHERE pertsonaiIzena= ? ")){
            
            $ezabatu->bind_param('s', $aldatzekoTitulua);
            $emaitza = $ezabatu->execute();
            
            //Pertsonaia EZABATU BADA
            if ($emaitza)
            {
                echo "Pertsonaia ezabatu da";
            
            }			
            else
            {
                die ("Pertsonaia ezabatzea ez da posible izan" .  $konexioa-> error);
            }
           $ezabatu->close();
        }
		
	}


	//PERTSONAIEN KONTSULTA EGIN
	$kontsulta= "SELECT * FROM pertsonaiak";
	$emaitza2= mysqli_query($konexioa,$kontsulta);
	//KONTSULTA ONA BADA
	if ($emaitza2)
	{
		while ($pertsonai = mysqli_fetch_array($emaitza2)) {
            
			echo
			"<tr>
				<td bgcolor=#fff>{$pertsonai['pertsonaiIzena']}</td>
				<td bgcolor=#fff>{$pertsonai['agerpenJokuIzen']}</td>
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
$token = md5(uniqid(rand(),true));
$_SESSION['csrf'] = $token; //token del servidor (cada vez que se recarga la pagina se crea nueva)
?>
    
    
    
</html>