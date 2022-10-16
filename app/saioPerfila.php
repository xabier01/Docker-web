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

    $kontsulta= "SELECT * FROM erabiltzaileak";
	$emaitza= mysqli_query($konexioa,$kontsulta);
    if ($emaitza){
    $erabiltzailea = mysqli_fetch_array($emaitza);
    $erab=$erabiltzailea['erabiltzaileIzena'];
    }


    	//EDITATU BOTOIA SAKATU BADA, JOKOA EDITATU DB-AN
	if(isset($_POST["botoiAldatu"])) 
	{
        
		$izenAbizenak=$_POST['izenAbizenak'];
		$nan= $_POST['nan'];
		$telefonoa= $_POST['telefonoa'];
		$jaioData= $_POST['jaioData'];
		$email= $_POST['email'];

		$editatu= "UPDATE erabiltzaileak SET izenAbizenak='$izenAbizenak', nan='$nan', telefonoa='$telefonoa', jaioData='$jaioData', email='$email' WHERE erabiltzaileIzena='$erab' ";
		$emaitza2= mysqli_query($konexioa, $editatu);
		//ERABILTZAILEA EDITATU BADA
		if ($emaitza2)
		{
			echo "Erabiltzailea editatu da";
		}			
		else
		{
		
			die ("Erabiltzailea editatzea ez da posible izan" .  $konexioa-> error);
		}
		
	}

 
    $kontsulta= "SELECT * FROM erabiltzaileak";
	$emaitza3= mysqli_query($konexioa,$kontsulta);
    if ($emaitza3){
    $erabiltzailea = mysqli_fetch_array($emaitza3);
    }



	//EDITATU BOTOIA SAKATU BADA, JOKOA EDITATU DB-AN
	if(isset($_POST["botoiPasAldatu"])) 
	{
        
		$pOrain=$_POST['pOrain'];
        $pBerri=$_POST['pBerri'];

		$editatu2= "UPDATE erabiltzaileak SET pasahitza='$pBerri' WHERE pasahitza='$pOrain' ";
		$emaitza4= mysqli_query($konexioa, $editatu2);
		//PASAHITZA EDITATU BADA
		if ($emaitza4)
		{
			echo "Pasahitza editatu da";
		}			
		else
		{
			//echo "Pasahitza ezin da editatu";
			die ("Pasahitza editatzea ez da posible izan" .  $konexioa-> error);
		}
		
	}


?>





<!DOCTYPE html>
<html lang="en">
    <head>
        <!--METADUATUAK-->
        <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
        <meta content="utf-8" http-equiv="encoding">
        <!--WEB IZENA-->
        <title>Web</title>
        <!--EREMU ERREFERENTZIAK-->
        <link rel="stylesheet" href="grafikak.css">
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
                    <a id="saioPerfila" href="saioPerfila.php">Perfila</a>
                    <a id ="saioItxi" href="saioaItxi.php">Saioa itxi</a>
                </nav>
                </div>
            </div>
        </header>
        
        <form name="datuakAldatu" method="POST" style="float: left; width: 75%; text-align: center; margin: 10%; padding-bottom: 0%">
            <h3>DATU ALDAKETA</h3>
            Izen abizenak: <input type="text" class="zelai" id="idIzenAbizen" name="izenAbizenak" value="<?php echo $erabiltzailea['izenAbizenak']; ?>" onchange="egiaztatuPerfil(this)"/><br>
            NAN (Adib. 12345678-A): <input type="text" class="zelai" id="idNAN" name="nan" value="<?php echo $erabiltzailea['nan']; ?>" onchange="egiaztatuPerfil(this)"/><br>
            Telefonoa (Adib. 123456789): <input type="text" class="zelai" id="idTel" name="telefonoa" value="<?php echo $erabiltzailea['telefonoa']; ?>" onchange="egiaztatuPerfil(this)"/><br>
            Jaiotze data: <input type="date" class="zelai" id="IdData" name="jaioData" value="<?php echo $erabiltzailea['jaioData']; ?>" min='1900-01-01' max='2021-11-21' onchange="egiaztatuPerfil(this)"/><br>
            Email (Adib. xagoun@gmail.com): <input type="text" class="zelai" id="IdEmail" name="email" value="<?php echo $erabiltzailea['email']; ?>" onchange="egiaztatuPerfil(this)"/><br>
            <input type="submit" class="botoiAldatu" name="botoiAldatu" id="botoiAldatu" value="Editatu" disabled >
            <input type="submit" class="botoiReset" value="Reset">
        </form>
        <script src="funtzioak.js" type="text/javascript"></script>
        <form name="pasahitzAldatu" method="POST" style="float: left; width: 75%; text-align: center; margin: 10%; padding-bottom: 0%">
            <h3>PASAHITZ ALDAKETA</h3>
            Oraingo pasahitza: <input type="password" class="zelai" id="idOrain" name="pOrain" onblur="egiaztatuPerfil(this)"><br>
            Pasahitz berria: <input type="password" class="zelai" id="idBerri" name="pBerri" onblur="egiaztatuPerfil(this)"><br>
            <input type="submit" class="botoiPasAldatu" name="botoiPasAldatu" id="botoiPasAldatu" value="Editatu" disabled>
            <input type="submit" class="botoiPasReset" value="Reset">
        </form>
        <script src="funtzioak.js" type="text/javascript"></script>
    </body>
</html>