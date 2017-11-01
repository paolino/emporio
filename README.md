emporio
=======

Software in italiano per la gestione semplificata di un emporio solidale con tessere a punti.
---------

Questo codice prevede un interfaccia web ad un database (sqlite) contenente le informazioni sugli utenti, le loro tessere 
e le loro spese..

Non compendia la gestione del magazzino.

L'interfaccia è suddivisa in 2 pagine, una per l'amministrazione con gestione transazionale delle oprazioni e un'altra per 
il funzionamento della cassa.

Gli utenti sono responsabili della loro identità tramite introduzione del loro PIN alla cassa.

La cassa prevede la gestione parallela degli utenti durante l'acquisto e prevede persistenza spesa per spesa, storno e 
fallimento esplicito.


Caratteristiche:
-------------

 * Interfaccia web: l'interfaccia web permette di accedere da un browser qualsiasi, permettendo l'utilizzo di pad in maniera naturale.

 * Servizio php: qualsiasi server in rete locale è in grado di fornire il servizio

 * Utilizzo estensivo di sqlite: correttezza impostata a livello di sistema, backup semplificato ad un file

 * Minimalismo: software indicato per empori semplici, rinunciando al carico magazzino e bar coding

Installazione:
----------------

 * installare docker (apt-get install -y docker.io)

 * moversi nella cartella con il codice php

 * creare il database con 

  cat emporio.sql | sqlite3 emporio.db
   
 * aggiungere il proprio segreto di amministrazione

  echo "insert into amministrazione values ('segreto182783');" | sqlite3 emporio.db
  
 * lanciare con ./run.sh

 * visitare http://localhost:8080/index.php
 
 * fermare con ./stop.sh 

Caveat:
---------

Il software è parzialmente dedicato ad una situazione particolare (Borgo val di Taro) dove gli utenti sono identificati da 2 numeri univoci, 
detti colloquio e utente che portano con se sulla tessera e presentano in cassa. 

Attualmente è possibile scaricare copia del database all'indirizzo locale localhost/emporio.db il che presenta una falla nella 
gestione della privacy. E' possibile migliorare con una cifratura del database.

