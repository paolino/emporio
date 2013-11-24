emporio
=======

gestione emporio a punti

Installazione:

copiare tutti i php nella directory di servizio (/srv/http per arch, /var/www per ubuntu)
creare il database con 
  cat emporio.sql | sqlite3 emporio.db
aggiungere il proprio segreto di amministrazione
  echo "insert into amministrazione ('segreto182783');" | sqlite3 emporio.db
  
spostare emporio.db nella directory di servizio e assegnare all'utente del server il diritto di scrittura sul file

visitare http://127.0.0.1/index.php
