<?php
//header_remove(“Server”);
header('X-Frame-Options: SAMEORIGIN');
header('X-XSS-Protection: 0');
header('X-Content-Type-Options: nosniff');

header_remove("X-Powered-By");

//Saioa hasi
ini_set("session.cookie_httponly", True);
session_start();
//Konektatu datu basea
$konexioa = mysqli_connect("db", "admin", "test", "database");
//Konexioa ezartzea posiblea izan ez bada begiratu
if ($konexioa -> connect_error) {
    die("Konexioa ez da lortu");
}

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
        <script src="funtzioak.js" type="text/javascript"></script>
    </head>
    <!--GOIBURUA-->
    <body>
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
        <!--WEB-AREN INFORMAZIOA-->
        <section class="textua">
            <h1>Zertan datza web honek?</h1>
            <br>
            <h2>Web honetan hainbat bideojokoren eta bere pertsonaien informazioa kudeatu daiteke. Bideojokoen atalean, titulua, balorazioa, laburpena eta pertsonai printzipalak adierazten dira. Pertsonaien alde, berriz, bere izena eta zein bideojokotan agertzen den.</h2>
            <br>
            <h1>Kontaktua</h1>
            <br>
            <h2>Mail: xagoun@gmail.com</h2>
            <br>
            <h2>Telefonoa:123123123</h2>
            <br>
        </section>
    </body>
</html>


<?php

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
