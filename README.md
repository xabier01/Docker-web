Xabier Aramburu, Gonzalo Redondo eta Unai Garcia

# Docker erabiliz, Web Sistema nola abiaratu

Gure proiektua daukan GitHub biltegia klonatu (edo jaitsi): 

$ git clone https://github.com/xabier01/Docker-web.git

Aurretik Docker eta Docker-compose instalatuta izan behar da:

https://docs.docker.com/engine/install/debian/

https://docs.docker.com/compose/install/

Orain, terminalean web sistemaren direktoriora sartu behar gara 'cd' komandoa erabiliz, orain hurrengo komandoak erabili behar dira:

> $ docker build -t="web" .

Eta prozesua amaitzerakon:

> $ docker-compose up -d

Web Sistematik atera nahi badugu hurrengo komandoa erabili:

> $ docker-compose stop

# Web Sistema nola ikusi

Nabigatzailea abiaratuz, 81 portura sartu behar gara 'localhost:81' bilatuz edo link hau erabili: [hemen](http://localhost:81/)

Orain Web sistema abiaratua izan beharko genuke, baina orrialde batzutan errore bat agertuko zaigu, hori kentzeko datu basea kargatu beharko dugu.

## DB-a nola importatu

Beste orrialde bat hasi behar dugu nabigatzailean, baina orain 8890 portura sartu behar gara 'localhost:8890' bilatuz edo link hau erabili: [hemen](http://localhost:8890/), orain phpMyAdmin web-ra bidaliko zaigu, non saioa hasteko esaten digu, hurrengo parametroak sartuko ditugu:

Erabiltzailea: admin

Pasahitza: test

Saioa hasi eta gero, db-a importatu behar dugu, horretarako hurrengo pausuak jarraituko ditugu:

> Ezkerrean dagoen menuan 'database' sakatuko dugu.

> Goiko goiburuan 'Importar' sakatu.

> 'Archivo a importar' atalean 'Seleccionar archivo' botoia sakatu.

> Orain orrialde bat agetuko da, nondik Web Sistema kokatuta dagoen direktoriora joan beharko gara eta 'database.sql' artxiboa ireki beharko da.

> Berriz phpMyAdmin orrialdera bueltan, 'Importar' botoia, non orrialdearen behealdean dagoen, sakatu.

> Web Sistemara bueltatuz, orrialdea berriz kargatu F5 erabiliz.
