<?php
    //SAIOA HASI
    session_start();
    //DA-AREKIN KONEXIOA LORTU
    $konexioa = mysqli_connect("db", "admin", "test", "database");
    //ERROREA EMAN BADU
    if ($konexioa -> connect_error) {
        die("Konexio zapustu da");
    }
    //SAIOA HASI BOTOIA SAKATU BADA, SAIOAREN PROZESUA HASI
    if (isset($_POST['saioBotoi'])) 
    {
        $erabiltzailea = $_POST['erabiltzaile'];
        $pasahitza = $_POST['pasahitza'];
        //BILAKETA EGIN
        $bilatu = mysqli_query($konexioa,"SELECT pasahitza FROM erabiltzaileak WHERE erabiltzaileIzena='$erabiltzailea'");
        //BILAKETA TXARTO JOAN BADA
        if (!$bilatu) 
        {
            echo '<script>alert("ERRORE")</script>';
        } 
        else 
        {
            //BILAKETAREN DATUAK LORTU
            $datuak = mysqli_fetch_array($bilatu);
            $dbarenPasahitza = $datuak['pasahitza'];
            //PASAHITZA EZ DAGO ERREGISTRATUA
            if (strcmp($dbarenPasahitza, "") == 0) 
            {
                echo '<script>alert("Erabiltzailea ez dago erregistratua")</script>';
            } 
            else 
            {
                //PASAHITZA OKERRA DA
                if (strcmp($pasahitza,$dbarenPasahitza) != 0) 
                {
                    echo '<script>alert("Pasahitz okerra")</script>';
                } 
                else 
                {
                    session_unset();
                    $_SESSION['erabiltzaile'] = $erabiltzailea;
                    echo '<script type="text/javascript"> window.location.href="index.php?init=f" </script>';
                }
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <!--METADUATUAK-->
        <meta charset="utf-8">
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
            <input type="submit" class="botoiSaio" name="saioBotoi" id="saioBotoi" value="Saioa Hasi" disabled>
            <input type="reset" class="resetBotoi" value="Reset">
        </form>
        <script src="funtzioak.js" type="text/javascript"></script>
    </body>
</html>
