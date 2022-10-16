
//---------------------------------------------------------------------------------------------------
//  ERREGISTRO ETA SAIOA HASI
//---------------------------------------------------------------------------------------------------

//Bariable guztiak (erregistro eta saioa hasi)
var erabiltzaileErregistroa = false;
var izenAbizenErregistroa = false;
var pasahitzErregistroa = false;
var nanErregistroa = false;
var telefonoErregistroa = false;
var dataErregistroa = false;
var emailErregistroa = false;
var erabiltzaileSaioa = false;
var pasahitzSaioa = false;


var erregistroBotoia = document.getElementById("erregistroBotoi");
var saioBotoia = document.getElementById("saioBotoi");

//Erregistroetan, saio hasieran,... ikusteko sartu den informazioa zuzena bada
function egiaztatuErregistroa(ikusteko) 
{
    //Ikustekoaren balioa eta izena hartu behar dugu informazioa egiaztatzeko
    var infoMota = ikusteko.name;
    var balioa = ikusteko.value;
    //Nulua edo hutsik badago
    if (balioa !== "" && balioa !== null) 
    {
        //Informazio mota ikusi
        if (infoMota === "erabiltzaile") 
        {
            //Erabiltzailea bada egiaztatu
            if (/^[A-Za-z0-9\-_]{1,100}$/.test(balioa)) {
                //Erabiltzailea da
                erabiltzaileErregistroa = true;
                ikusteko.style.borderColor = "green";
                ikusiBotoi();
                return;
            }
        } 
        else if (infoMota === "pasahitza") 
        {
            //Pasahitza bada egiaztatu
            if (/^[A-ZÁÉÍÓÚÑa-záéíóúñ0-9\-_$&]{8,100}$/.test(balioa)) 
            {
                //Pasahitz da
                pasahitzErregistroa = true;
                ikusteko.style.borderColor = "green";
                ikusiBotoi();
                return;
            }
        } 
        else if(infoMota === "izenAbizen") 
        {
            //Izen Abizen bada egiaztatu
            if (/^[A-Za-zÁÉÍÓÚa-záéíóú ]+$/.test(balioa)) 
            {
                //Izen Abizen da
                izenAbizenErregistroa = true;
                ikusteko.style.borderColor = "green";
                ikusiBotoi();
                return;
            }
        } 
        else if(infoMota === "nan") 
        {
            //NAN bada egiaztatu
            if (nanEgiaztatu(balioa)) 
            {
                //NAN da
                nanErregistroa = true;
                ikusteko.style.borderColor = "green";
                ikusiBotoi();
                return;
            }
        }
        else if(infoMota === "telefonoa") 
        {
            //Telefonoa bada egiaztatu
            if (/^[0-9]{9}$/.test(balioa)) {
                //Telefonoa da
                telefonoErregistroa = true;
                ikusteko.style.borderColor = "green";
                ikusiBotoi();
                return;
            }
        }
        else if(infoMota === "data") 
        {
            dataErregistroa = true;
            ikusteko.style.borderColor = "green";
            ikusiBotoi();
            return;
        }
        else if(infoMota === "email") 
        {
            //Email bada egiaztatu
            if (/^[A-za-z0-9.]+@[a-z]+\.[a-z]+$/.test(balioa)) 
            {
                //Email da
                emailErregistroa = true;
                ikusteko.style.borderColor = "green";
                ikusiBotoi();
                return;
            }
        }
    }
    ikusteko.style.borderColor = "red";
    erregistroBotoia.disabled = true;
}

function dataLortu() {
    var data = new Date();
    //Balio ezberdinetan banatu behar dugu manipulatu ahal izateko
    var eguna = data.getDate();
    var hilabete = data.getMonth();
    var urtea = data.getFullYear();
    //Eguna 2 digitu ez badauka, 0 bat gehitu hasieran
    if (eguna < 10) 
    {
        eguna = "0" + eguna;
    }
    //Hlabete 2 digitu ez badauka, 0 bat gehitu hasieran
    if (hilabete < 10) 
    {
        hilabete = "0" + hilabete;
    }
    //Data maximoa definitu
    document
        .getElementById("dataErreg")
        .setAttribute("max", urtea + "-" + mm + "-" + dd);
}

function nanEgiaztatu(nan) 
{
    //NAN-a nola den
    var nanEgiaztapen = /^[0-9]{8}\-[A-Za-z]{1}$/;
    //Nan ondo dago 
    if(nanEgiaztapen.test(nan))
    {
        //NAN bitan moztu
        var sp = nan.split("-");
        var zenbakia = sp[0];
        var hizkia = sp[1].toUpperCase();
        zenbakia = zenbakia % 23;
        var hizkiKatea = "TRWAGMYFPDXBNJZSQVHLCKET";
        hizkiKalkulatua = hizkiKatea.substring(zenbakia, zenbakia + 1);
        if (hizkia != hizkiKalkulatua) 
        {
            return false;
        } 
        else 
        {
            return true;
        }
    }
    /* -----------------------------------------
    else
    {
        return false;
    }
    ------------------------------------------- */
}
    
function egiaztatuSaioHasiera(ikusteko) 
{
    //Ikustekoaren balioa eta izena hartu behar dugu informazioa egiaztatzeko
    var infoMota = ikusteko.name;
    var balioa = ikusteko.value;
    //Nulua edo hutsik badago
    if (balioa !== "" && balioa !== null) 
    {
        //Informazio mota ikusi
        if (infoMota === "erabiltzaile") 
        {
            //Erabiltzailea bada egiaztatu
            if (/^[A-Za-z0-9\-_]{1,100}$/.test(balioa)) {
                //Erabiltzailea da
                erabiltzaileSaioa = true;
                ikusteko.style.borderColor = "green";
                begiraBotoi();
                return;
            }
        } 
        else if (infoMota === "pasahitza") 
        {
            //Pasahitza bada egiaztatu
            if (/^[A-ZÁÉÍÓÚÑa-záéíóúñ0-9\-_$&]{8,100}$/.test(balioa)) 
            {
                //Pasahitz da
                pasahitzSaioa = true;
                ikusteko.style.borderColor = "green";
                ikusiBotoi();
                return;
            }
        } 
    }
    ikusteko.style.borderColor = "red";
    erregistroBotoia.disabled = true;
    if(erabiltzaileErregistroa && pasahitzErregistroa && izenAbizenErregistroa && nanErregistroa && telefonoErregistroa && 
        dataErregistroa && emailErregistroa)
    {
        erregistroBotoia.disabled = false;
    }
    else
    {
        
    }
}

//---------------------------------------------------------------------------------------------------
//  JOKOAK
//---------------------------------------------------------------------------------------------------

//Bariable guztiak (jokoak)
var tituluZaharJoko = false;
var tituluJoko = false;
var generoJoko = false;
var balorazioJoko = false;
var adinJoko = false;
var laburpenJoko = false;
var pertsPrintzJoko = false;

var sartuJokBotoia = document.getElementById("sartuJokBotoi");
var editatuJokBotoia = document.getElementById("editatuJokBotoi");
var ezabatuJokBotoia = document.getElementById("ezabatuJokBotoi");

//Jokoetan gehitzean ikusteko sartu den informazioa zuzena bada
function egiaztatuJoko(ikusteko)
{
    //Ikustekoaren balioa eta izena hartu behar dugu informazioa egiaztatzeko
    var infoMota = ikusteko.name;
    var balioa = ikusteko.value;
    //Nulua edo hutsik badago
    if (balioa !== "" && balioa !== null) 
    {
        //Informazio mota ikusi
        if (infoMota === "tituluZahar") 
        {
            //titulua bada egiaztatu
            if (/^[A-Za-zÁÉÍÓÚa-záéíóú0-9,. ]+$/.test(balioa)) 
            {
                //titulua da
                tituluZaharJoko = true;
                ikusteko.style.borderColor = "green";
                ikusiBotoi();
                return;
            }
        } 
        else if (infoMota === "titulua") 
        {
            //titulua bada egiaztatu
            if (/^[A-Za-zÁÉÍÓÚa-záéíóú0-9,. ]+$/.test(balioa)) 
            {
                //titulua da
                tituluJoko = true;
                ikusteko.style.borderColor = "green";
                ikusiBotoi();
                return;
            }
        } 
        else if (infoMota === "generoa") 
        {
            //Generoa bada egiaztatu
            if (/^[A-Za-zÁÉÍÓÚa-záéíóú ]+$/.test(balioa))  
            {
                //Generoa da
                generoJoko = true;
                ikusteko.style.borderColor = "green";
                ikusiBotoi();
                return;
            }
        } 
        else if(infoMota === "balorazioa") 
        {
            //Balorazioa bada egiaztatu
            if (/^[0-9]{1,2}$/.test(balioa)) {
                //Balorazioa da
                balorazioJoko = true;
                ikusteko.style.borderColor = "green";
                ikusiBotoi();
                return;
            }
        }
        else if(infoMota === "adina") 
        {
            //Adina bada egiaztatu
            if (/^[0-9]{1,2}$/.test(balioa)) {
                //Telefonoa da
                adinJoko = true;
                ikusteko.style.borderColor = "green";
                ikusiBotoi();
                return;
            }
        }
        else if(infoMota === "laburpena") 
        {
            //Laburpena bada egiaztatu
            if (/^[A-Za-zÁÉÍÓÚa-záéíóú0-9,. ]+$/.test(balioa)) 
            {
                //Laburpena da
                laburpenJoko = true;
                ikusteko.style.borderColor = "green";
                ikusiBotoi();
                return;
            }
        }
        else if(infoMota === "printzipalak") 
        {
            //Printzipalak badiren egiaztatu
            if (/^[A-Za-zÁÉÍÓÚa-záéíóú0-9,. ]+$/.test(balioa)) 
            {
                //Printzipalak dira
                pertsPrintzJoko = true;
                ikusteko.style.borderColor = "green";
                ikusiBotoi();
                return;
            }
        }
    }
    ikusteko.style.borderColor = "red";
    sartuJokBotoia.disabled = true;
    editatuJokBotoia.disabled = true;
    ezabatuJokBotoia.disabled = true;
}

//---------------------------------------------------------------------------------------------------
//  PERTSONAIAK
//---------------------------------------------------------------------------------------------------

//Bariable guztiak (pertsonaiak)
var izenZaharPertsonai = false;
var izenPertsonai = false;
var agerpenJokPertsonai = false;

var sartuPertsBotoia = document.getElementById("sartuPertsBotoi");
var editatuPertsBotoia = document.getElementById("editatuPertsBotoi");
var ezabatuPertsBotoia = document.getElementById("ezabatuPertsBotoi");

//Pertsonaia gehitzean ikusteko sartu den informazioa zuzena bada
function egiaztatuPertsonai(ikusteko)
{
    //Ikustekoaren balioa eta izena hartu behar dugu informazioa egiaztatzeko
    var infoMota = ikusteko.name;
    var balioa = ikusteko.value;
    //Nulua edo hutsik badago
    if (balioa !== "" && balioa !== null) 
    {
        //Informazio mota ikusi
        if (infoMota === "tituluZahar") 
        {
            //pertsonai izena bada egiaztatu
            if (/^[A-Za-zÁÉÍÓÚa-záéíóú ]+$/.test(balioa))  
            {
                //pertsonai izena da
                izenZaharPertsonai = true;
                ikusteko.style.borderColor = "green";
                ikusiBotoi();
                return;
            }
        }
        else if (infoMota === "pertsonaiIzena") 
        {
            //pertsonai izena bada egiaztatu
            if (/^[A-Za-zÁÉÍÓÚa-záéíóú ]+$/.test(balioa))  
            {
                //pertsonai izena da
                izenPertsonai = true;
                ikusteko.style.borderColor = "green";
                ikusiBotoi();
                return;
            }
        } 
        else if (infoMota === "agerpenJoku") 
        {
            //AgerpenJoko bada egiaztatu
            if (/^[A-Za-zÁÉÍÓÚa-záéíóú0-9,. ]+$/.test(balioa)) 
            {
                //AgerpenJoko da
                agerpenJokPertsonai = true;
                ikusteko.style.borderColor = "green";
                ikusiBotoi();
                return;
            }
        } 
    }
    ikusteko.style.borderColor = "red";
    sartuPertsBotoia.disabled = true;
    editatuPertsBotoia.disabled = true;
    ezabatuPertsBotoia.disabled = true;
}

//---------------------------------------------------------------------------------------------------
//  PERFILA
//---------------------------------------------------------------------------------------------------

//Bariable guztiak (Perfila)
var izenAbizenPerfila = false;
var nanPerfila = false;
var telefonoPerfila = false;
var dataPerfila = false;
var emailPerfila = false;
var orainPasahitza = false;
var berriPasahitza = false;

var perfilBotoia = document.getElementById("botoiAldatu");
var pasahitzBotoia = document.getElementById("botoiPasAldatu");

//Perfilean ikusteko sartu den informazioa zuzena bada
function egiaztatuPerfil(ikusteko) 
{
    //Ikustekoaren balioa eta izena hartu behar dugu informazioa egiaztatzeko
    var infoMota = ikusteko.name;
    var balioa = ikusteko.value;
    //Nulua edo hutsik badago
    if (balioa !== "" && balioa !== null) 
    {
        //Informazio mota ikusi
        if(infoMota === "izenAbizenak") 
        {
            //Izen Abizen bada egiaztatu
            if (/^[A-Za-zÁÉÍÓÚa-záéíóú ]+$/.test(balioa)) 
            {
                //Izen Abizen da
                izenAbizenPerfila = true;
                ikusteko.style.borderColor = "green";
                ikusiBotoi();
                return;
            }
        } 
        else if(infoMota === "nan") 
        {
            //NAN bada egiaztatu
            if (nanEgiaztatu(balioa)) 
            {
                //NAN da
                nanPerfila = true;
                ikusteko.style.borderColor = "green";
                ikusiBotoi();
                return;
            }
        }
        else if(infoMota === "telefonoa") 
        {
            //Telefonoa bada egiaztatu
            if (/^[0-9]{9}$/.test(balioa)) {
                //Telefonoa da
                telefonoPerfila= true;
                ikusteko.style.borderColor = "green";
                ikusiBotoi();
                return;
            }
        }
        else if(infoMota === "jaioData") 
        {
            dataPerfila = true;
            ikusteko.style.borderColor = "green";
            ikusiBotoi();
            return;
        }
        else if(infoMota === "email") 
        {
            //Email bada egiaztatu
            if (/^[A-za-z0-9.]+@[a-z]+\.[a-z]+$/.test(balioa)) 
            {
                //Email da
                emailPerfila = true;
                ikusteko.style.borderColor = "green";
                ikusiBotoi();
                return;
            }
        }
        else if(infoMota === "pOrain") 
        {
            //Pasahitza bada egiaztatu
            if (/^[A-ZÁÉÍÓÚÑa-záéíóúñ0-9\-_$&]{8,100}$/.test(balioa)) 
            {
                //Pasahitza da
                orainPasahitza = true;
                ikusteko.style.borderColor = "green";
                ikusiBotoi();
                return;
            }
        }
        else if(infoMota === "pBerri") 
        {
            //Pasahitza bada egiaztatu
            if (/^[A-ZÁÉÍÓÚÑa-záéíóúñ0-9\-_$&]{8,100}$/.test(balioa)) 
            {
                //Pasahitza da
                berriPasahitza = true;
                ikusteko.style.borderColor = "green";
                ikusiBotoi();
                return;
            }
        }
    }
    ikusteko.style.borderColor = "red";
    perfilBotoia.disabled = true;
    pasahitzBotoia.disabled = true;
}


function ikusiBotoi()
{
    if(erabiltzaileErregistroa && pasahitzErregistroa && izenAbizenErregistroa && nanErregistroa && telefonoErregistroa && 
        dataErregistroa && emailErregistroa)
    {
        erregistroBotoia.disabled = false;
    }
    if(erabiltzaileSaioa && pasahitzSaioa)
    {
        saioBotoia.disabled = false;
    }
    if(tituluZaharJoko && tituluJoko && generoJoko && balorazioJoko && adinJoko && laburpenJoko && pertsPrintzJoko)
    {
        editatuJokBotoia.disabled = false;
    }
    if(tituluJoko && generoJoko && balorazioJoko && adinJoko && laburpenJoko && pertsPrintzJoko)
    {
        sartuJokBotoia.disabled = false;
    }
    if(tituluZaharJoko)
    {
        ezabatuJokBotoia.disabled = false;
    }
    if(izenZaharPertsonai && izenPertsonai && agerpenJokPertsonai)
    {
        editatuPertsBotoia.disabled = false;
    }
    if(izenPertsonai && agerpenJokPertsonai)
    {
        sartuPertsBotoia.disabled = false;
    }
    if(izenZaharPertsonai)
    {
        ezabatuPertsBotoia.disabled = false;
    }
    if(izenAbizenPerfila && nanPerfila && telefonoPerfila && 
        dataPerfila && emailPerfila)
    {
        perfilBotoia.disabled = false;
    }
    if(orainPasahitza && berriPasahitza)
    {
        pasahitzBotoia.disabled = false;
    }
}

