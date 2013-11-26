emporio
=======

Software in italiano per la gestione semplificata di un emporio solidale con tessere a punti.
------------------------------------------------------

Questo codice prevede un interfaccia web ad un database (sqlite) contenente le informazioni sugli utenti, le loro tessere 
e le loro spese.
Non compendia la gestione del magazzino.
L'interfaccia è suddivisa in 2 pagine, una per l'amministrazione con gestione transazionale delle oprazioni e un'altra per 
il funzionamento della cassa.
Gli utenti sono responsabili della loro identità tramite introduzione del loro PIN alla cassa.

Installazione:
----------------
 * abilitare il server http al servizio di pagine php con accesso pdo a sqlite 
   (pacchetti 'lighttpd' 'php' 'php-pdo' 'php-cgi')

 * copiare tutti i php nella directory di servizio (/srv/http per arch, /var/www per ubuntu)

 * creare il database con 

  cat emporio.sql | sqlite3 emporio.db
  
  
 * aggiungere il proprio segreto di amministrazione

  echo "insert into amministrazione ('segreto182783');" | sqlite3 emporio.db
  
 * spostare emporio.db nella directory di servizio e assegnare all'utente del server il diritto di scrittura sul file
 (utente 'http' per arch o www-data per Ubuntu) con 

  chown www-data emporio.db

 * visitare http://127.0.0.1/index.php
 * 
 
 
Caveat:
---------

Il software è parzialmente dedicato ad una situazione particolare dove gli utenti sono identificati da 2 numeri univoci, 
detti colloquio e utente che portano con se sulla tessera e presentano in cassa. Ovviamente la cosa presenta solo svantaggi


Attualmente è possibile scaricare copia del database all'indirizzo locale *emporio.db* il che presenta una falla nella 
gestione della privacy.

