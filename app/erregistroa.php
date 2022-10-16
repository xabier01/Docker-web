<?php
    //DB-AREKIN KONEXIOA LORTU
    $konexioa = mysqli_connect("db", "admin", "test", "database");
    //ERROREA EMAN BADU
    if ($konexioa -> connect_error) 
    {
        die("Konexio zapustu da");
    }
    //ERREGISTRO BOTOIA SAKATU BADA DB-AN ERREGISTRATU
    if (isset($_POST['erregistroBotoi'])) 
    {
        $erabiltzaile = $_POST['erabiltzaile'];
        $pasahitza = $_POST['pasahitza'];
        $izenAbizen = $_POST['izenAbizen'];
        $nan = substr($_POST['nan'],0,8);
        $telefonoa = $_POST['telefonoa'];
        $data = $_POST['data'];
        $email = $_POST['email'];
        $mota = $_POST['erregistroBotoi'];
        if (strcmp($mota, 'Erregistratu') == 0) 
        { 
            //ERREGISTROA EGIN
            $sartu = mysqli_query($konexioa, "INSERT INTO erabiltzaileak(erabiltzaileIzena, pasahitza, izenAbizenak, nan, telefonoa, jaioData ,email)
            VALUES ('$erabiltzaile', '$pasahitza', '$izenAbizen', '$nan', '$telefonoa', '$data', '$email')");
            //ONDO JOAN BADA IKUSI
            if (!$sartu)
            { 
                echo '<script>alert("Erabiltzailea ezin da erregistatu")</script>';
            } 
            else 
            { 
                echo '<script>alert("Erabiltzailea erregistratuta")</script>';
            }
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
                    <a href="saioaHasi.php">Saioa hasi</a>
                    <a href="erregistroa.php">Erregistroa</a>
                </nav>
            </div>
            </div>
        </header>
        <!--DATUEN ERREGISTROA-->
        <form action="" method="POST" style="float: left; width: 55%; text-align: center; margin: 400px;" >
			<h3>Erregistroa</h3>
			Erabiltzaile izena: <input type="text" class="eremu" id="erabilErreg" name="erabiltzaile" onblur="egiaztatuErregistroa(this)"/><br>
            Pasahitza (minimo 8 karaktere): <input type="password" class="eremu" id="pasahitzErreg" name="pasahitza" onblur="egiaztatuErregistroa(this)"/><br>
			Izen-Abizenak: <input type="text" class="eremu" id="eremuIzenAbizen" name="izenAbizen" onblur="egiaztatuErregistroa(this)"/><br>
			NAN (Adib. 12345678-A): <input type="text" class="eremu" id="nanErreg" name="nan" onblur="egiaztatuErregistroa(this)"/><br>
			Telefonoa (Adib. 123456789): <input type="tel" class="eremu" maxlen="9" id="telefonoErreg" name="telefonoa"  onblur="egiaztatuErregistroa(this)"/><br>
			Jaio-Data (Adib. 2022-10-10): <input type="date" class="eremu" id="dataErreg" name="data" min="1922-01-01" max="2022-10-30" onfocus="dataLortu()" onblur="egiaztatuErregistroa(this)"/><br>
			Email (Adib. email@xagoun.com): <input type="email" class="eremu" id="emeailErreg" name="email" onkeyup="egiaztatuErregistroa(this)"/><br>
			<input type="submit" class="botoiErregistro" id="erregistroBotoi" name="erregistroBotoi" value="Erregistratu" disabled/>
			<input type="submit" class="botoiReset" value="Reset"/>
		</form>
        <script src="funtzioak.js" type="text/javascript"></script>
	</body>
</html>
