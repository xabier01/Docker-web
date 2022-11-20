<?php
    //header_remove(“Server”);
    header('X-Frame-Options: SAMEORIGIN');
    header('X-XSS-Protection: 0');
    header('X-Content-Type-Options: nosniff');
    header_remove("X-Powered-By");
    
    ini_set("session.cookie_httponly", True);
    //SAIOA HASI
    session_start();
    //DA-AREKIN KONEXIOA LORTU
    $konexioa = mysqli_connect("db", "admin", "test", "database");
    //ERROREA EMAN BADU
    if ($konexioa -> connect_error) {
        die("Konexio zapustu da");
    }

    $konexioa-> set_charset('utf8');

    //SAIOA HASI BOTOIA SAKATU BADA, SAIOAREN PROZESUA HASI
    if (isset($_POST['saioBotoi'])) 
    {
        $erabiltzailea = $konexioa->real_escape_string($_POST['erabiltzaile']);
        $pasahitza = $konexioa->real_escape_string($_POST['pasahitza']);
        $csrf = $konexioa->real_escape_string($_POST['csrf']);
		if(!empty($erabiltzailea) && !empty($pasahitza) && !empty($csrf)){
            if($_SESSION['csrf'] === $csrf){
                echo "csrf ondo";
                unset($_SESSION['csrf']);
            }else{
                echo "csrf txarto";
            }
        }
        //BILAKETA EGIN
        if ($bilatu = $konexioa->prepare("SELECT erabiltzaileIzena, pasahitza FROM erabiltzaileak WHERE erabiltzaileIzena= ? "))
        {
            $bilatu->bind_param('s', $erabiltzailea);
            $emaitza=$bilatu->execute();

            //BILAKETA TXARTO JOAN BADA
            if (!$emaitza) 
            {
                echo '<script>alert("ERRORE")</script>';
            } 
            else 
            {
                //BILAKETAREN DATUAK LORTU
                $emaitzaResult= $bilatu->get_result();
                $datuak = mysqli_fetch_array($emaitzaResult);
                $dbarenErab= $datuak['erabiltzaileIzena'];
                $dbarenPasahitza = $datuak['pasahitza'];
                $checkpasahitza = password_verify($pasahitza,$dbarenPasahitza);
                //PASAHITZA EZ DAGO ERREGISTRATUA
                if (strcmp($dbarenPasahitza, "") == 0) 
                {
                    echo '<script>alert("Erabiltzailea ez dago erregistratua")</script>';
                } 
                else 
                {
                    //PASAHITZA OKERRA DA
                    if ($checkpasahitza === false) //strcmp($pasahitza,$dbarenPasahitza) != 0 
                    {
                        echo '<script>alert("Pasahitz okerra")</script>';
        
                        #Datu basetik inportatu erabiltzailearen saio huts kopurua

                        $kontsulta= "SELECT * FROM logTxarrak WHERE erabIzena = '$dbarenErab' ";
	                    $emaitza2= mysqli_query($konexioa,$kontsulta);
                        
                        if ($emaitza2){
        
                            $logTxarErab = mysqli_fetch_array($emaitza2);
                            $_SESSION['hutsSaioKop']=$logTxarErab['hutsSaioak'];
                        }

                        ++$_SESSION['hutsSaioKop'];
                        
                        #Sartu datuak logTxarrak taulan
                        if ($sartu =$konexioa->prepare("UPDATE logTxarrak SET pasahitza= ? , dataOrdua= ? , hutsSaioak= ? WHERE erabIzena= '$dbarenErab' "))
                        {   
                            $dataOrdua= date('y-m-d h:i:s');
                            $sartu->bind_param('sss', $pasahitza , $dataOrdua , $_SESSION['hutsSaioKop']);
                            $sartu->execute();
                        }    

                        #Huts saio kopurua 5 bada (edo 5-en multiploa), kontuaren blokeoa simulatu eta erreseteatu huts saio kopurua
                        if ($_SESSION['hutsSaioKop']% 5 == 0){
                            echo '<script>alert("Kontua blokeatu da, saiakera asko")</script>';
                            $_SESSION['hutsSaioKop']=0; 
                            
                            if ($sartu2 =$konexioa->prepare("UPDATE logTxarrak SET pasahitza= ? , dataOrdua= ? , hutsSaioak= ? WHERE erabIzena= '$dbarenErab' "))
                            {   
                                $dataOrdua= date('y-m-d h:i:s');
                                $sartu2->bind_param('sss', $pasahitza ,$dataOrdua, $_SESSION['hutsSaioKop']);
                                $sartu2->execute();
                            }    

                        }
                    } 
                    else 
                    {
                        session_unset();

                        #Ezabatu logTxarrak taulan erabiltzaile horren log txar guztiak

                        if ($ezabatu =$konexioa->prepare("UPDATE logTxarrak SET pasahitza= NULL , dataOrdua= NULL , hutsSaioak= 0 WHERE erabIzena= '$dbarenErab' "))
                        {   
                            $ezabatu->execute();
                        }    
                        

                        #Gehitu logOnak taulan erabiltzailea eta logOnaren data eta ordua

                        if ($sartu3 =$konexioa->prepare("INSERT INTO logOnak (erabIzena, dataOrdua) VALUES (? , ? ) "))
                        {   
                            $dataOrdua= date('y-m-d h:i:s');
                            $sartu3->bind_param('ss', $dbarenErab, $dataOrdua);
                            $sartu3->execute();
                        }    


                        $_SESSION['erabiltzaile'] = $erabiltzailea;
                        //$_SESSION['pasahitza'] = $pasahitza;

                        echo '<script type="text/javascript"> window.location.href="index.php?init=f" </script>';
                    }
                }
            }
            $bilatu->close();
        }
    }
    $token = md5(uniqid(rand(),true));
    $_SESSION['csrf'] = $token; //token del servidor (cada vez que se recarga la pagina se crea nueva)
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <!--METADUATUAK-->
        <meta http-equiv="Content-Security-Policy" charset="utf-8">
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
        <!--SAIO HASIERAREN DATUAK SARTZEKO-->
        <form action="" method="POST" style="float: left; width: 55%; text-align: center; margin: 400px;">
            <h3> Saioa hasi </h3>
            Erabiltzaile izena: <input type="text" name="erabiltzaile" onblur="egiaztatuSaioHasiera(this)"><br>
            Sartu zure pasahitza: <input type="password" name="pasahitza" onkeyup="egiaztatuSaioHasiera(this)"><br>
            <input type="hidden" name="csrf" value="<?php echo $token; ?>">
            <input type="submit" class="botoiSaio" name="saioBotoi" id="saioBotoi" value="Saioa Hasi" disabled>
            <input type="reset" class="resetBotoi" value="Reset">
        </form>
        <script src="funtzioak.js" type="text/javascript"></script>
    </body>
</html>
