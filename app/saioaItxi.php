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
                        <a id ="saioaHasi" href="saioaHasi.php">Saioa hasi</a>
                        <a id ="erregistroa" href="erregistroa.php">Erregistroa</a>
                    </nav>
                </div>
            </div>
        <!--AGURRA-->
        </header>
        <!--<div style="float: left; width: 100%; text-align: center; margin: 20px;">-->
        <div style="float: left; width: 75%; text-align: center; margin: 10%; padding-bottom: 0%">
            <h3>AGUR <?php echo $_SESSION['erabiltzaile'] ?>!</h3>
            <a href="index.php" class="indexBotoi">HOME-era bueltatu</a>
        </div>
    </body>
</html>
<?php
    //SAIOA GARBITU
    session_unset();
    //SAIOA AMAITU
    session_destroy();
?>
