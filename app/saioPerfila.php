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
    if (isset($_SESSION['erabiltzaile'])){

        $sesioErab=$_SESSION['erabiltzaile'];
        $sesioPas=$_SESSION['pasahitza'];

    }

    $kontsulta= "SELECT * FROM erabiltzaileak WHERE erabiltzaileIzena = '$sesioErab' ";
	$emaitza= mysqli_query($konexioa,$kontsulta);
    if ($emaitza){
        
        $erabiltzailea = mysqli_fetch_array($emaitza);
        $_SESSION['izenAbizen']=$erabiltzailea['izenAbizenak'];
        $_SESSION['nan']=$erabiltzailea['nan'];
        $_SESSION['telefonoa']=$erabiltzailea['telefonoa'];
        $_SESSION['data']=$erabiltzailea['jaioData'];
        $_SESSION['email']=$erabiltzailea['email'];
        $_SESSION['pasahitza']=$erabiltzailea['pasahitza'];
    }


    //EDITATU BOTOIA SAKATU BADA, ERABILTZAILEAREN DATUAK EDITATU DB-AN
	if(isset($_POST["botoiAldatu"])) 
	{
        
		$izenAbizenak=$konexioa->real_escape_string(htmlspecialchars($_POST['izenAbizenak']));
		$nan= $konexioa->real_escape_string(htmlspecialchars($_POST['nan']));
		$telefonoa= $konexioa->real_escape_string(htmlspecialchars($_POST['telefonoa']));
		$jaioData= $konexioa->real_escape_string(htmlspecialchars($_POST['jaioData']));
		$email= $konexioa->real_escape_string(htmlspecialchars($_POST['email']));
        $csrf = $konexioa->real_escape_string($_POST['csrf']);
		if(!empty($izenAbizenak) && !empty($nan) && !empty($telefonoa) && !empty($jaioData) && !empty($email) && !empty($csrf)){
            if($_SESSION['csrf'] === $csrf){
                echo "csrf ondo";
                unset($_SESSION['csrf']);
            }else{
                echo "csrf txarto";
            }
        }
		if($editatu= $konexioa->prepare("UPDATE erabiltzaileak SET izenAbizenak= ? , nan= ? , telefonoa= ? , jaioData= ? , email= ? WHERE erabiltzaileIzena= ? "))
		{
            $editatu->bind_param('ssssss',$izenAbizenak, $nan, $telefonoa, $jaioData, $email, $sesioErab);
            $emaitza2=$editatu->execute();

            //ERABILTZAILEA EDITATU BADA
            if ($emaitza2)
            {
                echo "Erabiltzailea editatu da";

                $kontsulta= "SELECT * FROM erabiltzaileak WHERE erabiltzaileIzena = '$sesioErab' ";
                $emaitza3= mysqli_query($konexioa,$kontsulta);
                if ($emaitza3){
                    
                    $erabiltzailea = mysqli_fetch_array($emaitza3);
                    $_SESSION['izenAbizen']=$erabiltzailea['izenAbizenak'];
                    $_SESSION['nan']=$erabiltzailea['nan'];
                    $_SESSION['telefonoa']=$erabiltzailea['telefonoa'];
                    $_SESSION['data']=$erabiltzailea['jaioData'];
                    $_SESSION['email']=$erabiltzailea['email'];
                
                }
            }			
            else
            {
            
                die ("Erabiltzailea editatzea ez da posible izan" .  $konexioa-> error);
            }
            $editatu->close();
        }
		
	}

 
   



	//EDITATU BOTOIA SAKATU BADA, PASAHITZA EDITATU DB-AN
	if(isset($_POST["botoiPasAldatu"])) 
	{
        
		$pOrain=$konexioa->real_escape_string(htmlspecialchars($_POST['pOrain']));
        $pBerri=$konexioa->real_escape_string(htmlspecialchars($_POST['pBerri']));

        $hashedpBerria = password_hash($pBerri, PASSWORD_DEFAULT); 
        $checkpasahitza = password_verify($pOrain,$sesioPas);

        $csrf = $konexioa->real_escape_string($_POST['csrf']);
		if(!empty($pOrain) && !empty($pBerri) && !empty($csrf)){
            if($_SESSION['csrf'] === $csrf){
                echo "csrf ondo";
                unset($_SESSION['csrf']);
            }else{
                echo "csrf txarto";
            }
        }

        //Pasahitz okerra bada
        if ($checkpasahitza === false){
            echo '<script>alert("Pasahitz okerra")</script>';
            //echo $pOrain;
            //echo $sesioPas;
        }else{
            if($editatu2= $konexioa->prepare("UPDATE erabiltzaileak SET pasahitza= ? WHERE erabiltzaileIzena= ? "))
		    {
          
                $editatu2->bind_param('ss',$hashedpBerria, $sesioErab);
                $emaitza4=$editatu2->execute();
                echo "Pasahitza editatu da";
                $editatu2->close();
            }
        }
		
		
	}
    $token = md5(uniqid(rand(),true));
    $_SESSION['csrf'] = $token; //token del servidor (cada vez que se recarga la pagina se crea nueva)

?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <!--METADUATUAK-->
        <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
        <meta http-equiv="Content-Security-Policy" charset="utf-8">
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
            Izen abizenak: <input type="text" class="zelai" id="idIzenAbizen" name="izenAbizenak" value="<?php echo $_SESSION['izenAbizen']; ; ?>" onchange="egiaztatuPerfil(this)"/><br>
            NAN (Adib. 12345678-A): <input type="text" class="zelai" id="idNAN" name="nan" value="<?php echo $_SESSION['nan']; ?>" onchange="egiaztatuPerfil(this)"/><br>
            Telefonoa (Adib. 123456789): <input type="text" class="zelai" id="idTel" name="telefonoa" value="<?php echo $_SESSION['telefonoa']; ?>" onchange="egiaztatuPerfil(this)"/><br>
            Jaiotze data: <input type="date" class="zelai" id="IdData" name="jaioData" value="<?php echo $_SESSION['data']; ?>" min='1900-01-01' max='2021-11-21' onchange="egiaztatuPerfil(this)"/><br>
            Email (Adib. xagoun@gmail.com): <input type="text" class="zelai" id="IdEmail" name="email" value="<?php echo $_SESSION['email']; ?>" onchange="egiaztatuPerfil(this)"/><br>
            <input type="hidden" name="csrf" value="<?php echo $token; ?>">
            <input type="submit" class="botoiAldatu" name="botoiAldatu" id="botoiAldatu" value="Editatu" disabled >
            <input type="submit" class="botoiReset" value="Reset">
        </form>
        <script src="funtzioak.js" type="text/javascript"></script>
        <form name="pasahitzAldatu" method="POST" style="float: left; width: 75%; text-align: center; margin: 10%; padding-bottom: 0%">
            <h3>PASAHITZ ALDAKETA</h3>
            Oraingo pasahitza: <input type="password" class="zelai" id="idOrain" name="pOrain" onblur="egiaztatuPerfil(this)"><br>
            Pasahitz berria: <input type="password" class="zelai" id="idBerri" name="pBerri" onblur="egiaztatuPerfil(this)"><br>
            <input type="hidden" name="csrf" value="<?php echo $token; ?>">
            <input type="submit" class="botoiPasAldatu" name="botoiPasAldatu" id="botoiPasAldatu" value="Editatu" disabled>
            <input type="submit" class="botoiPasReset" value="Reset">
        </form>
        <script src="funtzioak.js" type="text/javascript"></script>
    </body>
</html>