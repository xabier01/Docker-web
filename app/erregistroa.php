<?php

//header_remove(“Server”);
header('X-Frame-Options: SAMEORIGIN');
header('X-XSS-Protection: 0');
header('X-Content-Type-Options: nosniff');
header_remove("X-Powered-By");

ini_set("session.cookie_httponly", True);
session_start();
    //DB-AREKIN KONEXIOA LORTU
    $konexioa = mysqli_connect("db", "admin", "test", "database");
    //ERROREA EMAN BADU
    if ($konexioa -> connect_error) 
    {
        die("Konexio zapustu da");
    }
    
    $konexioa-> set_charset('utf8');

    //ERREGISTRO BOTOIA SAKATU BADA DB-AN ERREGISTRATU
    if (isset($_POST['erregistroBotoi'])) 
    {
        $erabiltzaile = $konexioa->real_escape_string($_POST['erabiltzaile']);
        $pasahitza = $konexioa->real_escape_string($_POST['pasahitza']);
        $izenAbizen = $konexioa->real_escape_string($_POST['izenAbizen']);
        $nan = $konexioa->real_escape_string(substr($_POST['nan'],0,8));
        $telefonoa = $konexioa->real_escape_string($_POST['telefonoa']);
        $data = $konexioa->real_escape_string($_POST['data']);
        $email = $konexioa->real_escape_string($_POST['email']);
        $mota = $konexioa->real_escape_string($_POST['erregistroBotoi']);
        $csrf = $konexioa->real_escape_string($_POST['csrf']);
        $hashedpasahitza = password_hash($pasahitza, PASSWORD_DEFAULT); 
        if(!empty($erabiltzaile) && !empty($pasahitza) && !empty($izenAbizen) && !empty($nan) && !empty($telefonoa) && !empty($data) && !empty($email) && !empty($csrf)){
            if($_SESSION['csrf'] === $csrf){
                echo "csrf ondo";
                unset($_SESSION['csrf']);
            }else{
                echo "csrf txarto";
            }
        }
        if (strcmp($mota, 'Erregistratu') == 0) 
        { 
            //ERREGISTROA EGIN
            if ($sartu =$konexioa->prepare("INSERT INTO erabiltzaileak(erabiltzaileIzena, pasahitza, izenAbizenak, nan, telefonoa, jaioData ,email) VALUES (? , ? , ? , ? , ? , ? , ? )"))
            {//ONDO JOAN BADA IKUSI
                $sartu->bind_param('sssssss',$erabiltzaile, $hashedpasahitza, $izenAbizen, $nan, $telefonoa, $data, $email);
                $emaitza=$sartu->execute();
                
                if (!$emaitza)
                { 
                    echo '<script>alert("Erabiltzailea ezin da erregistatu")</script>';
                } 
                else 
                {    
                    if ($sartu2 =$konexioa->prepare("INSERT INTO logTxarrak(erabIzena, hutsSaioak) VALUES (? , 0)"))
                    {
                        $sartu2->bind_param('s', $erabiltzaile);
                        $sartu2->execute();
                    }    
                    
                    if ($sartu3 =$konexioa->prepare("INSERT INTO logOnak(erabIzena) VALUES (?)"))
                    {
                        $sartu3->bind_param('s', $erabiltzaile);
                        $sartu3->execute();
                    }    
                    
                    echo '<script>alert("Erabiltzailea erregistratuta")</script>';
                }
                $sartu->close();
            }
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
        <meta http-equiv="Content-Security-Policy"  charset="utf-8">
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
			<input type="hidden" name="csrf" value="<?php echo $token; ?>">
            <input type="submit" class="botoiErregistro" id="erregistroBotoi" name="erregistroBotoi" value="Erregistratu" disabled/>
			<input type="submit" class="botoiReset" value="Reset"/>
		</form>
        <script src="funtzioak.js" type="text/javascript"></script>
	</body>
</html>
